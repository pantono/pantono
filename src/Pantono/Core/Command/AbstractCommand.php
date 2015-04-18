<?php namespace Pantono\Core\Command;

use Pantono\Core\Container\Application;
use Symfony\Component\Console\Command\Command;use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractCommand extends Command
{
    protected $container;
    public function setContainer(Application $container)
    {
        $this->container = $container;
    }

    /**
     * @return Application
     */
    protected function getContainer()
    {
        return $this->container;
    }

    protected function translate($id, $params = [])
    {
        return $this->getContainer()->getTranslator()->trans($id, $params);
    }

    protected function showInfo(OutputInterface $output, $message, $params = [])
    {
        $output->writeln('<info>'.$this->translate($message, $params).'</info>');
    }

    protected function showError(OutputInterface $output, $message, $params = [])
    {
        $output->writeln('<error>'.$this->translate($message, $params).'</error>');
    }
}