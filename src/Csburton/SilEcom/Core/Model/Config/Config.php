<?php

namespace Csburton\SilEcom\Core\Model\Config;

use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Yaml\Exception\ParseException;
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

    public function getItem($section, $value = null)
    {
        if (!$this->contents) {
            $this->parseFile();
        }
        if (!isset($this->contents[$section])) {
            return null;
        }
        if (!$value) {
            return $this->contents[$section];
        } else {
            return isset($this->contents[$section][$value])?$this->contents[$section][$value]:null;
        }
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