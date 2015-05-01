<?php namespace Pantono\Core\Event\Events;

use Pantono\Assets\Entity\Asset as AssetEntity;

class Asset extends General
{
    private $asset;
    const PRE_SAVE = 'pantono.assets.pre-save';
    CONST POST_SAVE = 'pantono.assets.post-save';

    /**
     * @param AssetEntity $asset
     */
    public function setAsset(AssetEntity $asset)
    {
        $this->asset = $asset;
    }

    /**
     * @return mixed
     */
    public function getAsset()
    {
        return $this->asset;
    }
}