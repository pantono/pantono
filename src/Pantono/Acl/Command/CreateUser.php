<?php namespace Pantono\Acl\Command;

use Pantono\Acl\AdminAuthentication;
use Pantono\Core\Command\AbstractCommand;
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

        $fullName = $this->askQuestion($input, $output, new Question($this->translate('Please enter the name for the user') . ': ', ''), 'error_min_length', ['%length%' => 6]);

        $user = $this->askQuestion($input, $output, new Question($this->translate('Please enter the email address for the new user') . ': ', ''), 'error_min_length', ['%length%' => 4]);
        $passwordQuestion = new Question($this->translate('Please enter the password for the new user') . ': ', '');
        $passwordQuestion->setHidden(true);
        $password = $this->askQuestion($input, $output, $passwordQuestion, 'error_min_length', ['%length%' => 4]);
        $userEntity = $this->getAuthenticationClass()->addAdminUser($user, $password, $fullName);
        $this->showInfo($output, 'User Created! ID: %id%', ['%id%' => $userEntity->getId()]);
    }

    /**
     * @return AdminAuthentication
     */
    private function getAuthenticationClass()
    {
        return $this->getContainer()->getPantonoService('AdminAuthentication');
    }
}
