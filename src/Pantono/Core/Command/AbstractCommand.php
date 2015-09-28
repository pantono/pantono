<?php namespace Pantono\Core\Command;

use Pantono\Core\Container\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Abstract command class. All console commands should extend this class
 *
 * @package Pantono\Core\Command
 * @author  Chris Burton <csburton@gmail.com>
 */
abstract class AbstractCommand extends Command
{
    /**
     * @var Application
     */
    protected $container;

    /**
     * @param Application $container
     */
    public function setContainer(Application $container)
    {
        $this->container = $container;
    }

    /**
     * Gets current service container
     *
     * @return Application
     */
    protected function getContainer()
    {
        return $this->container;
    }

    /**
     * Translates a given string in the local translation database
     *
     * @param string $id     String "ID" to translate
     * @param array  $params Parameters to replace
     *
     * @return string
     */
    protected function translate($id, $params = [])
    {
        return $this->getContainer()->getTranslator()->trans($id, $params);
    }

    /**
     * Helper method to show info message to console output
     *
     * @param OutputInterface $output  Output interface
     * @param string          $message Message to show
     * @param array           $params  parameters within message
     */
    protected function showInfo(OutputInterface $output, $message, $params = [])
    {
        $output->writeln('<info>' . $this->translate($message, $params) . '</info>');
    }

    /**
     * Helper method to show error message to console output
     *
     * @param OutputInterface $output  Output Interface
     * @param string          $message Message to show
     * @param array           $params  Parameters within message
     */
    protected function showError(OutputInterface $output, $message, $params = [])
    {
        $output->writeln('<error>' . $this->translate($message, $params) . '</error>');
    }
}
