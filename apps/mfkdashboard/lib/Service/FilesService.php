<?php

namespace OCA\MFKDashboard\Service;

use OC\URLGenerator;
use \OCP\Files\IRootFolder;
use \OCP\Files\Node;
use  \OCP\Util;
use \OCP\IUserSession;
use OCP\Share;
use OCP\IURLGenerator;
use OCP\Share\IManager;
use OCP\Share\IShare;


class FilesService
{
    private IRootFolder $rootFolder;
    private IUserSession $userSession;
    private IManager $shareManager;
    private IURLGenerator $urlGenerator;

    public function __construct(IUserSession $userSession, IRootFolder $rootFolder, IManager $shareManager, IURLGenerator $urlGenerator)
    {
        $this->rootFolder = $rootFolder;
        $this->userSession = $userSession;
        $this->shareManager = $shareManager;
        $this->urlGenerator = $urlGenerator;
    }

    private function listFilesInFolder(string $folderPath)
    {
        $userId = $this->getCurrentUserId();
        $userFolder = $this->rootFolder->getUserFolder($userId);

        // check if folder exists
        if (!$userFolder->nodeExists($folderPath)) {
            throw new \Exception("Ordner nicht gefunden: $folderPath");
        }

        $folder = $userFolder->get($folderPath);

        // check if folder is empty
        if (!($folder instanceof \OCP\Files\Folder)) {
            throw new \Exception("$folderPath ist kein Ordner!");
        }

        // Dateien im Ordner auflisten
        $files = $folder->getDirectoryListing();

        $fileList = [];
        foreach ($files as $file) {
            $fileList[] = [
                'name' => $file->getName(),
                'path' => $file->getPath(),
                'type' => $file instanceof \OCP\Files\File ? 'file' : 'folder',
                'size' => $file instanceof \OCP\Files\File ? $file->getSize() : null,
            ];
        }

        return $fileList;
    }

    public function createPublicLinkForFolder(string $folderPath): string
    {
        $userId = $this->getCurrentUserId();
        $userFolder = $this->rootFolder->getUserFolder($userId);

        if (!$userFolder->nodeExists($folderPath)) {
            throw new \Exception("Ordner nicht gefunden: $folderPath");
        }

        $folder = $userFolder->get($folderPath);

        if (!($folder instanceof \OCP\Files\Folder)) {
            throw new \Exception("$folderPath ist kein Ordner!");
        }

        $s = $this->shareManager->newShare();
        $s->setNode($folder);
        $s->setPermissions(\OCP\Constants::PERMISSION_READ);
        $s->setSharedBy($this->getCurrentUserId());
        $s->setShareType(IShare::TYPE_LINK);
        $share = $this->shareManager->createShare($s);

        $shareUrl = $this->urlGenerator->linkToRouteAbsolute('files_sharing.sharecontroller.showShare', ['token' => $share->getToken()]);

        return $shareUrl;
    }

    public function getAllPostingLinks($jobFolder)
    {
        $links = [];
        $files = $this->listFilesInFolder($jobFolder . "/Werbematerial/Ausgewählte Bildmaterialien");
        $shares = $this->getSharesInFolder($jobFolder . "/Werbematerial/Ausgewählte Bildmaterialien");
        // get all file paths
        $paths = [];
        foreach ($files as $key => $file) {
            array_push($paths, $file["path"]);
        }
        // match files with existing shares
        foreach ($shares as $fileId => $share) {
            // Datei-Knoten basierend auf der Datei-ID abrufen
            $fileNodes = $this->rootFolder->getById($fileId);
            if (!empty($fileNodes) && $fileNodes[0] instanceof \OCP\Files\Node) {
                $fileNode = $fileNodes[0];
                $path = $fileNode->getPath();
                // Überprüfen, ob der Pfad in der Liste der Dateien vorhanden ist
                if (in_array($path, array_column($files, 'path'))) {
                    array_push($links, $this->urlGenerator->linkToRouteAbsolute('files_sharing.sharecontroller.showShare', ['token' => $share[0]->getToken()]) . "/download");
                    unset($paths[array_search($path, $paths)]);
                }
            } else {
                return "that shouldn't have happen";
            }
        }
        // create shares for new files
        foreach ($paths as $key => $p) {
            array_push($links, $this->createPublicLinkForFile($p) . "/download");
        }
        return $links;
    }

    public function verifyCompanyLogo($jobFolder)
    {
        try {
            $jobFolderParts = explode("/", rtrim($jobFolder, "/"));
            array_pop($jobFolderParts);
            $companyFolder = implode("/", $jobFolderParts);
            $files = $this->listFilesInFolder($companyFolder);
            foreach ($files as $key => $file) {
                if (str_contains($file["name"], "logo")) {
                    return True;
                }
            }
            return False;
        } catch (\Throwable $th) {
            return False;
        }
    }

    public function getCompanyLogoLink($jobFolder)
    {
        try {
            $jobFolderParts = explode("/", rtrim($jobFolder, "/"));
            array_pop($jobFolderParts);
            $companyFolder = implode("/", $jobFolderParts);
            $files = $this->listFilesInFolder($companyFolder);
            $logoFile = null;
            foreach ($files as $key => $file) {
                if (str_contains($file["name"], "logo")) {
                    $logoFile = $file;
                    break;
                }
            }
            if ($logoFile == null) {
                return "";
            }
            // check if file is already shared
            $shareLink = "";
            $shares = $this->getSharesInFolder($companyFolder);
            foreach ($shares as $fileId => $share) {
                // Datei-Knoten basierend auf der Datei-ID abrufen
                $fileNodes = $this->rootFolder->getById($fileId);
                if (!empty($fileNodes) && $fileNodes[0] instanceof \OCP\Files\Node) {
                    $fileNode = $fileNodes[0];
                    if ($logoFile["path"] == $fileNode->getPath()) {
                        $s = $this->shareManager->updateShare($share[0]);
                        $expirationDate = new \DateTime();
                        $expirationDate->modify("+180 days");
                        $s->setExpirationDate($expirationDate);
                        $this->shareManager->updateShare($s);
                        $shareLink = $this->urlGenerator->linkToRouteAbsolute('files_sharing.sharecontroller.showShare', ['token' => $s->getToken()]);
                    }
                }
            }
            if ($shareLink != "") {
                // extend and get share link
                return $shareLink;
            } else {
                // extend and get share link
                return $this->createPublicLinkForFile($logoFile["path"], 180);
            }
            return "";
        } catch (\Throwable $th) {
            return "";
        }
    }

    public function getCustomerPostingMaterialLink($mediaFolderPath)
    {
        try {
            $jobFolderParts = explode("/", rtrim($mediaFolderPath, "/"));
            array_pop($jobFolderParts);
            $parentFolderPath = implode("/", $jobFolderParts);

            $userId = $this->getCurrentUserId();
            $userFolder = $this->rootFolder->getUserFolder($userId);

            // check if folder exists
            if (!$userFolder->nodeExists($parentFolderPath)) {
                return "";
            }

            // check if folder is already shared
            $shareLink = "";
            $shares = $this->getSharesInFolder($parentFolderPath);
            foreach ($shares as $fileId => $share) {
                // Datei-Knoten basierend auf der Datei-ID abrufen
                $fileNodes = $this->rootFolder->getById($fileId);
                if (!empty($fileNodes) && $fileNodes[0] instanceof \OCP\Files\Folder) {
                    $fileNode = $fileNodes[0];
                    if (str_contains($fileNode->getPath(), $mediaFolderPath)) {
                        $s = $this->shareManager->updateShare($share[0]);
                        $expirationDate = new \DateTime();
                        $expirationDate->modify("+180 days");
                        $s->setExpirationDate($expirationDate);
                        $this->shareManager->updateShare($s);
                        $shareLink = $this->urlGenerator->linkToRouteAbsolute('files_sharing.sharecontroller.showShare', ['token' => $s->getToken()]);
                    }
                }
            }
            if ($shareLink != "") {
                // extend and get share link
                return $shareLink;
            } else {
                // extend and get share link
                return $this->createPublicLinkForFile($mediaFolderPath, 180);
            }
            return "";
        } catch (\Throwable $th) {
            return "";
        }
    }

    private function getSharesInFolder($path)
    {
        $userId = $this->getCurrentUserId();
        $userFolder = $this->rootFolder->getUserFolder($userId);

        if (!$userFolder->nodeExists($path)) {
            throw new \Exception("Ordner nicht gefunden: $path");
        }

        $folder = $userFolder->get($path);

        if (!($folder instanceof \OCP\Files\Folder)) {
            throw new \Exception("$path ist kein Ordner!");
        }

        $s = $this->shareManager->getSharesInFolder($userId, $folder);

        return $s;
    }

    private function createPublicLinkForFile($path, $duration = null)
    {
        $userId = $this->getCurrentUserId();
        $userFolder = $this->rootFolder->getUserFolder($userId);
        if ($userFolder->nodeExists($path)) {
            $file = $userFolder->get($path);
        }else{
            $file = $this->rootFolder->get($path);
        }

        if (!($file instanceof \OCP\Files\Node)) {
            throw new \Exception("invalid element");
        }

        $s = $this->shareManager->newShare();
        $s->setNode($file);
        $s->setPermissions(\OCP\Constants::PERMISSION_READ);
        $s->setSharedBy($this->getCurrentUserId());
        $s->setShareType(IShare::TYPE_LINK);
        if ($duration != null) {
            $expirationDate = new \DateTime();
            $expirationDate->modify("+$duration days");
            $s->setExpirationDate($expirationDate);
        }
        $share = $this->shareManager->createShare($s);

        $shareUrl = $this->urlGenerator->linkToRouteAbsolute('files_sharing.sharecontroller.showShare', ['token' => $share->getToken()]);
        return $shareUrl;
    }

    public function getNumberOfFiles($folderPath)
    {
        $userId = $this->getCurrentUserId();
        $userFolder = $this->rootFolder->getUserFolder($userId);

        // check if folder exists
        if (!$userFolder->nodeExists($folderPath)) {
            throw new \Exception("Ordner nicht gefunden: $folderPath");
        }

        $folder = $userFolder->get($folderPath);

        // check if folder is empty
        if (!($folder instanceof \OCP\Files\Folder)) {
            throw new \Exception("$folderPath ist kein Ordner!");
        }

        // Dateien im Ordner auflisten
        $files = $folder->getDirectoryListing();

        $fileCount = 0;
        foreach ($files as $file) {
            if ($file instanceof \OCP\Files\File) {
                $fileCount += 1;
            }
        }
        return $fileCount;
    }

    private function getCurrentUserId()
    {
        $currentUser = $this->userSession->getUser();
        if ($currentUser === null) {
            throw new \Exception("Kein Benutzer ist angemeldet.");
        }
        return $currentUser->getUID();
    }
}
