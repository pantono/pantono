<?php namespace Pantono\Acl;

use Pantono\Acl\Entity\AdminUser;
use Pantono\Acl\Entity\Repository\AdminUserRepository;
use Pantono\Contacts\Entity\Contact;
use Pantono\Core\Model\Config\Config;
use Pantono\Core\Model\Controller\Admin;
use Silex\Provider\SessionServiceProvider;

class AdminAuthentication
{
    private $repository;
    private $session;
    private $config;

    public function __construct(AdminUserRepository $repository, SessionServiceProvider $session, Config $config)
    {
        $this->repository = $repository;
        $this->session = $session;
        $this->config = $config;
    }

    public function getCurrentUser()
    {
        $userId = $this->session->get('admin_user_id');
        $user = $this->repository->getUserInfo($userId);
        return $user;
    }

    public function isCurrentUserAuthenticated()
    {
        $currentUserId = $this->session->get('admin_user_id');
        $lastAction = $this->session->get('last_admin_action');
        if (!$lastAction) {
            $lastAction = new \DateTime('-1 hour');
        } else {
            $lastAction = new \DateTime($lastAction);
        }
        $currentTime = new \DateTime();
        $timeout = $this->config->getItem('admin', 'session_timeout', 1800);
        if ($currentTime->diff($lastAction)->format('U') > $timeout) {

        }
        $this->session->set('last_admin_action', $currentTime->format('Y-m-d H:i:s'));
        return $this->session->get('admin_user_id');
    }

    public function authenticateAdminUser($username, $password)
    {
        $user = $this->repository->getUserByUsername($username);
        if (!$user) {
            return false;
        }

        if (password_verify($password, $user->getPassword())) {
            if (password_needs_rehash($user->getPassword(), PASSWORD_DEFAULT)) {
                $hash = password_hash($user->getPassword(), PASSWORD_DEFAULT);
                $user->setPassword($hash);
                $this->repository->save($user);
            }
            return $user;
        }
        return false;
    }

    public function addAdminUser($userName, $password, $realName)
    {
        $contact = new Contact();
        list($firstName, $lastName) = explode(' ', $realName, 2);
        $contact->setFirstName($firstName);
        $contact->setLastName($lastName);
        $adminUser = new AdminUser();
        $adminUser->setPassword(password_hash($password, PASSWORD_DEFAULT));
        $adminUser->setUsername($userName);
        $adminUser->setContact($contact);
        $this->repository->save($adminUser);
        return $adminUser;
    }

    public function changeUserPassword(AdminUser $user, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user->setPassword($hashedPassword);
        $this->repository->save($user);
    }

    public function userExists($email)
    {
        $user = $this->repository->findBy(['username' => $email]);
        return ($user) ? true : false;
    }

    public function findSingleUserByEmail($email)
    {
        $user = $this->repository->findOneBy(['username' => $email]);
        return $user;
    }
}