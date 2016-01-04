<?php
/**
 * @user: Pawel Babilas
 * @date: 03.01.2016
 */

namespace app\module\thumbnailer\picture;


use yii\web\UploadedFile;

class Uploader
{

	/** @var string */
	private $customName = null;

	/** @var string */
	private $uploadFilesPath;

	const UPLOAD_FOLDER = 'full_size';

	public function __construct($uploadFilesPath, $useMd5Names = false)
	{
		$this->uploadFilesPath = $uploadFilesPath;
		$this->useMd5Names = $useMd5Names;
	}

	/**
	 * @param UploadedFile[] $uploadedFiles
	 *
	 * @return array
	 */
	public function runForFiles(array $uploadedFiles)
	{
		$fileNames = [];

		foreach ($uploadedFiles as $id => $uploadedFile)
		{
			$fileNames[$id] = $this->runForFile($uploadedFile);
		}

		return $fileNames;
	}

	/**
	 * @param UploadedFile $uploadedFile
	 *
	 * @return bool|string
	 */
	public function runForFile(UploadedFile $uploadedFile)
	{
		$extension = $uploadedFile->getExtension();
		$baseName = $uploadedFile->getBaseName();

		if ($this->useMd5Names)
		{
			$filename = sprintf('%s', md5(time() . $baseName));
		}
		elseif(is_null($this->customName) == false)
		{
			$filename = sprintf("%s", $this->customName);
		}
		else
		{
			$filename = sprintf("%s", $baseName);
		}

		$filename = $this->getUniqueFilename($filename, $extension);

		$filePath = $this->getFilePath($filename);

		if ($uploadedFile->saveAs($filePath))
		{
			return $filename;
		}

		return false;
	}

	/**
	 * @param string $filename
	 * @return string
	 */
	private function getFilePath($filename)
	{
		return \Yii::$app->getBasePath() . $this->uploadFilesPath . Uploader::UPLOAD_FOLDER . '/' . $filename;
	}

	/**
	 * @param string $filename
	 * @param string $extension
	 * @param null $filesCount
	 *
	 * @return string
	 */
	private function getUniqueFilename($filename, $extension, $filesCount = null)
	{
		if (file_exists($this->getFilePath($filename)))
		{
			if (is_null($filesCount))
			{
				$pattern = $this->uploadFilesPath . Uploader::UPLOAD_FOLDER . '/' . '*_*' . $extension;
				$filesCount = glob($pattern);
			}

			$this->getUniqueFilename($filename, $extension, $filesCount);
		}

		return sprintf('%s%s.%s', $filename, is_null($filesCount) ? '' : '_' . $filesCount, $extension);
	}

	/**
	 * @param string $customName
	 */
	public function setCustomName($customName)
	{
		$this->customName = $customName;
	}
}