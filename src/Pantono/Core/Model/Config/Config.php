<?php

namespace Pantono\Core\Model\Config;

use Symfony\Component\Yaml\Parser;

class Config
{
    private $files;
    private $contents;

    public function addFile($filename)
    {
        $this->files[] = $filename;
        $this->parseFile($filename);
    }

    public function getItem($section, $value = null, $default = null)
    {
        if (!$this->contents) {
            $this->parseFile();
        }
        if (!isset($this->contents[$section])) {
            return null;
        }
        if (!$value) {
            return isset($this->contents[$section])?$this->contents[$section]:$default;
        }

        return isset($this->contents[$section][$value])?$this->contents[$section][$value]:$default;
    }

    private function parseFile()
    {
        $parser = new Parser();
        $contents = [];
        foreach ($this->files as $file) {
            $contents += $parser->parse(file_get_contents($file));
        }
        $this->contents= $contents;
    }
}