<?php namespace Pantono\Core\Cache\Redis;

use Pantono\Core\Cache\CacheInterface;
use Predis\Client;

class Redis implements CacheInterface
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getItem($key)
    {
        $item = $this->client->get($key);
        return $item;
    }

    public function clear()
    {
        $items = $this->client->get('*');
        return $this->client->del($items);
    }

    public function getItems(array $items = array())
    {
        $returnItems = [];
        foreach ($items as $item) {
            $returnItems[] = $this->getItem($item);
        }
        return $returnItems;
    }
}