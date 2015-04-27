<?php namespace Pantono\Acl\Command;

use Pantono\Acl\AdminAuthentication;use Pantono\Core\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class CreateUser extends AbstractCommand
{
    use UserCommandTraits;
    protected function configure()
    {
        $this->setName('user:create')
            ->setDescription('Add new admin user');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fullName = $this->getFullName($input, $output);
        $user = $this->getEmail($input, $output);
        $password = $this->getPassword($input, $output);

        $userEntity = $this->getAuthenticationClass()->addAdminUser($user, $password, $fullName);
        $this->showInfo($output, 'User Created! ID: %id%', ['%id%' => $userEntity->getId()]);
    }

    private function getEmail(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $userQuestion = new Question($this->translate('Please enter the email address for the new user').': ', '');
        $user = $helper->ask($input, $output, $userQuestion);
        if (strlen($user) < 4) {
            $this->showError($output, 'error_min_length', ['%length%' => 4]);
            return $this->getEmail($input, $output);
        }
        return $user;
    }


    private function getFullName(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $nameQuestion = new Question($this->translate('Please enter the name for the user').': ', '');
        $password = $helper->ask($input, $output, $nameQuestion);
        if (!$password) {
            $this->showError($output, 'error_min_length', ['%length%' => 6]);
            return $this->getFullName($input, $output);
        }
        return $password;
    }

    /**
     * @return AdminAuthentication
     */
    private function getAuthenticationClass()
    {
        return $this->getContainer()->getPantonoService('AdminAuthentication');
    }
}