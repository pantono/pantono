<?php namespace Pantono\Assets;

use League\Flysystem\Filesystem;
use Pantono\Assets\Entity\Asset;
use Pantono\Assets\Entity\Repository\AssetsRepository;
use Pantono\Assets\Exception\AssetUploadFailed;
use Pantono\Core\Event\Dispatcher;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Assets
{
    private $filesystem;
    private $repository;
    private $dispatcher;
    const TYPE_IMAGE = 1;
    const TYPE_DOCUMENT = 2;
    private $typeMap = [
        'image/jpeg' => self::TYPE_IMAGE,
        'image/png' => self::TYPE_IMAGE,
        'image/gif' => self::TYPE_IMAGE,
        'image/bmp' => self::TYPE_IMAGE,
        'image/x-windows-bmp' => self::TYPE_IMAGE,
        'image/x-icon' => self::TYPE_IMAGE,
        'image/pjpeg' => self::TYPE_IMAGE,
        'image/x-jps' => self::TYPE_IMAGE,
        'image/x-portable-bitmap' => self::TYPE_IMAGE,
        'image/x-pict' => self::TYPE_IMAGE,
        'image/x-pcx' => self::TYPE_IMAGE,
        'image/pict' => self::TYPE_IMAGE,
        'image/tiff' => self::TYPE_IMAGE,
        'image/x-tiff' => self::TYPE_IMAGE,

        'application/x-excel' => self::TYPE_DOCUMENT,
        'application/vnd.mx-excel' => self::TYPE_DOCUMENT,
        'application/pdf' => self::TYPE_DOCUMENT,
        'application/msword' => self::TYPE_DOCUMENT,
        'application/mspowerpoint' => self::TYPE_DOCUMENT,
        'application/powerpoint' => self::TYPE_DOCUMENT,
        'application/x-mspowerpoint' => self::TYPE_DOCUMENT,
        'application/vnd.ms-powerpoint' => self::TYPE_DOCUMENT
    ];

    public function __construct(Filesystem $filesystem, AssetsRepository $repository, Dispatcher $dispatcher)
    {
        $this->filesystem = $filesystem;
        $this->repository = $repository;
        $this->dispatcher = $dispatcher;
    }

    public function uploadAsset(UploadedFile $file)
    {
        $filename = uniqid() . '_' . $file->getClientOriginalName();
        if (!$this->filesystem->writeStream($filename, fopen($file->getRealPath(), 'r'))) {
            throw new AssetUploadFailed('Asset failed to upload');
        }
        $mimeType = $this->filesystem->getMimetype($filename);
        $asset = new Asset();
        $asset->setFilename($filename);
        $asset->setFilesize($this->filesystem->getSize($filename));
        $asset->setMimeType($file->getMimeType());
        $asset->setPublicUrl($file->getClientOriginalName());
        $asset->setType($this->repository->getTypeReference($this->getTypeFromMimeType($mimeType)));
        $this->dispatcher->dispatchAssetEvent(\Pantono\Core\Event\Events\Asset::PRE_SAVE, $asset);
        $this->repository->save($asset);
        $this->repository->flush();
        $this->dispatcher->dispatchAssetEvent(\Pantono\Core\Event\Events\Asset::POST_SAVE, $asset);
        return $asset;
    }

    public function deleteAssets($filename)
    {
        $this->filesystem->delete($filename);
    }

    public function getTypeFromMimeType($mimeType)
    {
        return isset($this->typeMap[$mimeType]) ? $this->typeMap[$mimeType] : null;
    }
}