<?php

namespace SilEcom\Core\Model\Config;

use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser;

class Config
{
    private $config_file;
    private $content;

    public function __construct($config_file = null)
    {
        $this->config_file = $config_file;
    }

    public function getItem($section, $value)
    {
        if (!$this->content) {
            $this->parseFile();
        }
    }

    private function parseFile()
    {
        $parser = new Parser();
        $contents = $parser->parse(file_get_contents($this->config_file));
        print_r($contents);
        exit;
    }
}