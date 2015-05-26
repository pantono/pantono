<?php namespace Pantono\Acl;

use Pantono\Acl\Entity\AdminUser;
use Pantono\Acl\Entity\Repository\AclRepository;
use Pantono\Acl\Model\Filter\AdminUserList;
use Pantono\Contacts\Entity\Contact;
use Pantono\Core\Event\Dispatcher;
use Pantono\Core\Model\Config\Config;
use Symfony\Component\HttpFoundation\Session\Session;
use \Pantono\Core\Event\Events\AdminUser as AdminUserEvent;

class AdminAuthentication
{
    private $repository;
    private $session;
    private $config;
    private $dispatcher;

    public function __construct(AclRepository $repository, Session $session, Config $config, Dispatcher $dispatcher)
    {
        $this->repository = $repository;
        $this->session = $session;
        $this->config = $config;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @return null|object
     */
    public function getCurrentUser()
    {
        $userId = $this->session->get('admin_user_id');
        if (!$userId) {
            return null;
        }
        $user = $this->repository->getUserInfo($userId);
        return $user;
    }

    /**
     * @return bool|mixed
     */
    public function isCurrentUserAuthenticated()
    {
        $currentUserId = $this->session->get('admin_user_id');
        $lastAction = $this->session->get('last_admin_action');
        if (!$currentUserId) {
            return false;
        }
        if (!$lastAction) {
            $lastAction = '-1 hour';
        }
        $lastAction = new \DateTime($lastAction);
        $currentTime = new \DateTime();
        $timeout = $this->config->getItem('admin', 'session_timeout', 1800);
        if ($currentTime->format('U') - $lastAction->format('U') >= $timeout) {
            return false;
        }
        $this->session->set('last_admin_action', $currentTime->format('Y-m-d H:i:s'));
        return $currentUserId;
    }

    public function getSingleUser($id)
    {
        return $this->repository->getUserInfo($id);
    }

    public function deleteAdminUserById($id)
    {

    }

    public function deleteAdminUser(AdminUser $user)
    {
        $this->dispatcher->dispatchAdminUserEvent(AdminUserEvent::PRE_DELETE, $user);
        $this->repository->delete($user);
        $this->dispatcher->dispatchAdminUserEvent(AdminUserEvent::POST_DELETE, $user);
        return true;
    }

    /**
     * @param $username
     * @param $password
     * @return bool|AdminUser
     */
    public function authenticateAdminUser($username, $password)
    {
        $user = $this->repository->getUserByUsername($username);
        if (!$user) {
            return false;
        }

        if (!$user->getActive()) {
            return false;
        }
        if (password_verify($password, $user->getPassword())) {
            if (password_needs_rehash($user->getPassword(), PASSWORD_DEFAULT)) {
                $hash = password_hash($user->getPassword(), PASSWORD_DEFAULT);
                $user->setPassword($hash);
            }
            $user->setLastLogin(new \DateTime);
            $this->repository->save($user);
            $this->repository->flush();
            $this->session->set('admin_user_id', $user->getId());
            $this->session->set('last_admin_action', (new \DateTime)->format('Y-m-d H:i:s'));
            return $user;
        }
        return false;
    }

    public function logoutUser()
    {
        $this->session->set('admin_user_id', null);
        $this->session->set('last_admin_action', null);
        return true;
    }

    /**
     * @param $userName
     * @param $password
     * @param $realName
     * @return AdminUser
     */
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
        $this->repository->flush();
        return $adminUser;
    }

    /**
     * @param AdminUser $user
     * @param $password
     */
    public function changeUserPassword(AdminUser $user, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user->setPassword($hashedPassword);
        $this->repository->save($user);
        $this->repository->flush();
    }

    /**
     * @param $email
     * @return bool
     */
    public function userExists($email)
    {
        $user = $this->repository->getUserByUsername($email);
        return ($user) ? true : false;
    }

    /**
     * @param $email
     * @return \Pantono\Acl\Entity\AdminUser|null
     */
    public function findSingleUserByEmail($email)
    {
        $user = $this->repository->getUserByUsername($email);
        return $user;
    }

    public function getAdminUserList(AdminUserList $filter)
    {
        return $this->repository->getAdminUserList($filter);
    }

    public function saveAdminUser(AdminUser $user)
    {
        $this->dispatcher->dispatchAdminUserEvent(AdminUserEvent::PRE_SAVE, $user);
        $this->repository->save($user);
        $this->repository->flush();
        $this->dispatcher->dispatchAdminUserEvent(AdminUserEvent::POST_SAVE, $user);
        return true;
    }
}
