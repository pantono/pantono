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
     * @param string $message
     * @param array $params
     * @return mixed
     */
    abstract public function showError(OutputInterface $output, $message, $params = []);

    /**
     * @param string $id
     * @param array $params
     * @return mixed
     */
    abstract public function translate($id, $params = []);

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
