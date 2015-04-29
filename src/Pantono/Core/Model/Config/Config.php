<?php

namespace Pantono\Core\Model\Config;

use Symfony\Component\Yaml\Parser;

class Config
{
    private $files = [];
    private $contents;

    public function addFile($filename)
    {
        $this->files[] = $filename;
        $this->parseConfigFiles();
    }

    public function getItem($key, $subKey = null, $default = null)
    {
        if (!$this->contents) {
            $this->parseConfigFiles();
        }
        if ($subKey === null) {
            return $this->getKeyValue($key, $default);
        }
        return $this->getSubKeyValue($key, $subKey, $default);
    }

    public function getKeyValue($key, $default)
    {
        if (!isset($this->contents[$key])) {
            return $default;
        }
        return $this->contents[$key];
    }

    public function getSubKeyValue($key, $subKey, $default)
    {
        if (!isset($this->contents[$key][$subKey])) {
            return $default;
        }
        return $this->contents[$key][$subKey];
    }

    private function parseConfigFiles()
    {
        $parser = new Parser();
        $contents = [];
        foreach ($this->files as $file) {
            $fileContents = $parser->parse(file_get_contents($file));
            if ($fileContents) {
                $contents = array_merge_recursive($contents, $fileContents);
            }
        }
        $this->contents = $contents;
    }
}