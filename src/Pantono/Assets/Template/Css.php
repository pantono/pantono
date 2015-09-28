<?php namespace Pantono\Assets\Template;

use Pantono\Core\Model\Config\Config;

/**
 * Class which aggregates css files used in the current request
 *
 * Class Css
 *
 * @package Pantono\Assets\Template
 * @author  Chris Burton <csburton@gmail.com>
 */
class Css
{
    /**
     * @var array Current array of css files
     */
    private $files = [];
    /**
     * @var Config Site config model
     */
    private $config;

    /**
     * @param Config $config Site config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Adds a new css file to be added to the current stack
     *
     * @param string $path Css file path to add
     */
    public function addFile($path)
    {
        $this->files[] = $path;
    }

    /**
     * Outputs html for including all css files in the current stack
     *
     * @return string
     */
    public function getCompiled()
    {
        $output = '';
        $defaultHost = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
        $host = $this->config->getItem('website', 'host', $defaultHost);
        if ($host != '') {
            $host = 'http://' . $host;
            if (substr($host, -1) !== '/') {
                $host .= '/';
            }
        }
        foreach ($this->files as $file) {
            $output .= '<link rel="stylesheet" href="' . $host . $file . '" />';
        }
        return $output;
    }
}