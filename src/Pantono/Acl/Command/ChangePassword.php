<?php namespace Pantono\Acl\Command;

use Pantono\Acl\AdminAuthentication;use Pantono\Core\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class ChangePassword extends AbstractCommand
{
    protected function configure()
    {
        $this->setName('user:change-password')
            ->setDescription('Change admin user password');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = $this->getEmail($input, $output);
        $password = $this->getPassword($input, $output);

        $userEntity = $this->getAuthenticationClass()->findSingleUserByEmail($user);
        $this->getAuthenticationClass()->changeUserPassword($userEntity, $password);
        $this->showInfo($output, 'Password updated');
    }


    private function getEmail(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $userQuestion = new Question($this->translate('Please enter the email address for the user account').': ', '');
        $user = $helper->ask($input, $output, $userQuestion);
        if (strlen($user) < 4) {
            $this->showError($output, 'error_min_length', ['%length%' => 4]);
            return $this->getEmail($input, $output);
        }

        if (!$this->getAuthenticationClass()->userExists($user)) {
            $this->showError($output, 'Username %user% does not exist', ['%user%' => $user]);
            return $this->getEmail($input, $output);
        }
        return $user;
    }

    private function getPassword(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $passwordQuestion = new Question($this->translate('Please enter the new password for the user').': ', '');
        $passwordQuestion->setHidden(true);
        $password = $helper->ask($input, $output, $passwordQuestion);
        if (!$password) {
            $this->showError($output, 'error_min_length', ['%length%' => 6]);
            return $this->getPassword($input, $output);
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