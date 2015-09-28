<?php namespace Pantono\Acl\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Traits used for user modification/creation console commands
 *
 * Class UserCommandTraits
 *
 * @package Pantono\Acl\Command
 * @author Chris Burton <csburton@gmail.com>
 */
trait UserCommandTraits
{
    /**
     * @param $name
     */
    abstract public function getHelper($name);

    /**
     * @param OutputInterface $output
     * @param string $message
     * @param array $params
     * @return mixed
     */
    abstract public function showError(OutputInterface $output, $message, $params = []);

    /**
     * Translate given input with the given parameters
     *
     * @param string $id Translation string ID
     * @param array $params Translation parameters
     *
     * @return string
     */
    abstract public function translate($id, $params = []);

    /**
     * Prompts user for user password
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return string
     */
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

    /**
     * Prompts the user for a response to a question
     *
     * @param InputInterface $input Input Interface
     * @param OutputInterface $output Output Interface
     * @param Question $question Question to ask the user
     * @param string $errorMessage Error message to display to the user when no content provided
     * @param array $errorArguments Arguments for the error message
     *
     * @return string
     */
    protected function askQuestion(InputInterface $input, OutputInterface $output, Question $question, $errorMessage, $errorArguments = [])
    {
        $helper = $this->getHelper('question');
        $content = $helper->ask($input, $output, $question);
        if (!$content) {
            $this->showError($output, $errorMessage, $errorArguments);
            return $this->askQuestion($input, $output, $question, $errorMessage, $errorArguments);
        }
        return $content;
    }
}
