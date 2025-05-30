<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\Files\Controller;

use OC\Files\Utils\PathHelper;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\Attribute\ApiRoute;
use OCP\AppFramework\Http\Attribute\NoAdminRequired;
use OCP\AppFramework\Http\Attribute\UserRateLimit;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\OCS\OCSException;
use OCP\AppFramework\OCS\OCSForbiddenException;
use OCP\AppFramework\OCS\OCSNotFoundException;
use OCP\AppFramework\OCSController;
use OCP\Files\Conversion\IConversionManager;
use OCP\Files\File;
use OCP\Files\IRootFolder;
use OCP\IL10N;
use OCP\IRequest;

class ConversionApiController extends OCSController {
	public function __construct(
		string $appName,
		IRequest $request,
		private IConversionManager $fileConversionManager,
		private IRootFolder $rootFolder,
		private IL10N $l10n,
		private ?string $userId,
	) {
		parent::__construct($appName, $request);
	}

	/**
	 * Converts a file from one MIME type to another
	 *
	 * @param int $fileId ID of the file to be converted
	 * @param string $targetMimeType The MIME type to which you want to convert the file
	 * @param string|null $destination The target path of the converted file. Written to a temporary file if left empty
	 *
	 * @return DataResponse<Http::STATUS_CREATED, array{path: string}, array{}>
	 *
	 * 201: File was converted and written to the destination or temporary file
	 *
	 * @throws OCSException The file was unable to be converted
	 * @throws OCSNotFoundException The file to be converted was not found
	 */
	#[NoAdminRequired]
	#[UserRateLimit(limit: 25, period: 120)]
	#[ApiRoute(verb: 'POST', url: '/api/v1/convert')]
	public function convert(int $fileId, string $targetMimeType, ?string $destination = null): DataResponse {
		$userFolder = $this->rootFolder->getUserFolder($this->userId);
		$file = $userFolder->getFirstNodeById($fileId);

		if (!($file instanceof File)) {
			throw new OCSNotFoundException($this->l10n->t('The file cannot be found'));
		}

		if ($destination !== null) {
			$destination = PathHelper::normalizePath($destination);
			$parentDir = dirname($destination);

			if (!$userFolder->nodeExists($parentDir)) {
				throw new OCSNotFoundException($this->l10n->t('The destination path does not exist: %1$s', [$parentDir]));
			}

			if (!$userFolder->get($parentDir)->isCreatable()) {
				throw new OCSForbiddenException();
			}

			$destination = $userFolder->getFullPath($destination);
		}

		try {
			$convertedFile = $this->fileConversionManager->convert($file, $targetMimeType, $destination);
		} catch (\Exception $e) {
			throw new OCSException($e->getMessage());
		}

		$convertedFileRelativePath = $userFolder->getRelativePath($convertedFile);
		if ($convertedFileRelativePath === null) {
			throw new OCSNotFoundException($this->l10n->t('Could not get relative path to converted file'));
		}

		return new DataResponse([
			'path' => $convertedFileRelativePath,
		], Http::STATUS_CREATED);
	}
}
