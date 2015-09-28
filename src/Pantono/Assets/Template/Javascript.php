<?php namespace Pantono\Assets\Template;

use Pantono\Core\Model\Config\Config;

/**
 * Class which aggregates javascript files used in the current request
 *
 * Class Javascript
 *
 * @package Pantono\Assets\Template
 * @author  Chris Burton <csburton@gmail.com>
 */
class Javascript
{
    /**
     * @var array Javascript file paths in current stack
     */
    private $files = [];
    /**
     * @var Config Site config model
     */
    private $config;

    /**
     * @param Config $config Site config model
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Adds a javascript file to the current stack
     *
     * @param string $relativePath Path to javascript file
     */
    public function addFile($relativePath)
    {
        $this->files[] = $relativePath;
    }

    /**
     * Gets all files in current stack
     *
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Outputs html for all javascript files in current stack
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
            $output .= '<script src="' . $host . $file . '" type="text/javascript"></script>';
        }
        return $output;
    }
}