<?php namespace Pantono\Acl\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

trait UserCommandTraits
{
    /**
     * @param $name
     */
    abstract public function getHelper($name);

    /**
     * @param OutputInterface $output
     * @param string $name
     * @param $options
     * @return mixed
     */
    abstract public function showError($output, $name, $options);

    /**
     * @param $string
     * @return mixed
     */
    abstract public function translate($string);
    protected function getPassword(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $passwordQuestion = new Question($this->translate('Please enter the password for the new user') . ': ', '');
        $passwordQuestion->setHidden(true);
        $password = $helper->ask($input, $output, $passwordQuestion);
        if (!$password) {
            $this->showError($output, 'error_min_length', ['%length%' => 6]);
            return $this->getPassword($input, $output);
        }
        return $password;
    }
}