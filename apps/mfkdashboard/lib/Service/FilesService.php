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

    public function __construct(IUserSession $userSession, IRootFolder $rootFolder, IManager $shareManager, IURLGenerator $urlGenerator) {
        $this->rootFolder = $rootFolder;
        $this->userSession = $userSession;
        $this->shareManager = $shareManager;
        $this->urlGenerator = $urlGenerator;
    }

    public function listFilesInFolder(string $folderPath) {
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

    public function createPublicLinkForFolder(string $folderPath): string {
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

    private function getCurrentUserId() {
        $currentUser = $this->userSession->getUser();
        if ($currentUser === null) {
            throw new \Exception("Kein Benutzer ist angemeldet.");
        }
        return $currentUser->getUID();
    }
}