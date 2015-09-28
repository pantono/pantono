<?php namespace Pantono\Acl\Command;

use Pantono\Acl\AdminAuthentication;
use Pantono\Core\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Symfony command handler for changing user passwords
 *
 * Class ChangePassword
 *
 * @package Pantono\Acl\Command
 * @author Chris Burton <csburton@gmail.com>
 */
class ChangePassword extends AbstractCommand
{
    use UserCommandTraits;

    /**
     * Configure the command
     */
    protected function configure()
    {
        $this->setName('user:change-password')
            ->setDescription('Change admin user password');
    }

    /**
     * Execute the change password command
     *
     * @param InputInterface $input Input Interface
     * @param OutputInterface $output Output Interface
     * @return null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = $this->askQuestion($input, $output, new Question($this->translate('Please enter the email address for the new user') . ': ', ''), 'error_min_length', ['%length%' => 4]);
        $passwordQuestion = new Question($this->translate('Please enter the password for the new user') . ': ', '');
        $passwordQuestion->setHidden(true);
        $password = $this->askQuestion($input, $output, $passwordQuestion, 'error_min_length', ['%length%' => 4]);

        $userEntity = $this->getAuthenticationClass()->findSingleUserByEmail($user);
        if ($userEntity === null) {
            $this->showError($output, 'error_user_not_exists', ['%user%' => $user]);
            return null;
        }
        $this->getAuthenticationClass()->changeUserPassword($userEntity, $password);
        $this->showInfo($output, 'Password updated');
    }

    /**
     * Gets the current admin authentication class
     *
     * @return AdminAuthentication
     */
    private function getAuthenticationClass()
    {
        return $this->getContainer()->getPantonoService('AdminAuthentication');
    }
}
