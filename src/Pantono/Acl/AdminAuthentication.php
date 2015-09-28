<?php namespace Pantono\Acl;

use Pantono\Acl\Entity\AdminUser;
use Pantono\Acl\Entity\Repository\AclRepository;
use Pantono\Acl\Model\Filter\AdminUserList;
use Pantono\Contacts\Entity\Contact;
use Pantono\Core\Event\Dispatcher;
use Pantono\Core\Model\Config\Config;
use Symfony\Component\HttpFoundation\Session\Session;
use \Pantono\Core\Event\Events\AdminUser as AdminUserEvent;

/**
 * Provides functionality related to Administrator authentication
 *
 * Class AdminAuthentication
 *
 * @package Pantono\Acl
 * @author  Chris Buton <csburton@gmail.com>
 */
class AdminAuthentication
{
    private $repository;
    private $session;
    private $config;
    private $dispatcher;

    /**
     * @param AclRepository $repository ACL Repository
     * @param Session       $session    Session Class
     * @param Config        $config     Config model
     * @param Dispatcher    $dispatcher Dispatcher class
     */
    public function __construct(AclRepository $repository, Session $session, Config $config, Dispatcher $dispatcher)
    {
        $this->repository = $repository;
        $this->session = $session;
        $this->config = $config;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Gets currently logged in user details, null if no-one is logged in
     *
     * @return null|AdminUser
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
     * Check if currently logged in user is authenticated. Returns current user id if logged in
     *
     * @return bool|int
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

    /**
     * Gets a singleuser record from the database given the ID
     *
     * @param int $id User ID
     *
     * @return null|AdminUser
     */
    public function getSingleUser($id)
    {
        return $this->repository->getUserInfo($id);
    }

    /**
     * Deletes a user given their ID
     *
     * @param int $id User ID
     *
     * @return bool
     */
    public function deleteAdminUserById($id)
    {
        $user = $this->getSingleUser($id);
        if (!$user) {
            return false;
        }
        return $this->deleteAdminUser($user);
    }

    /**
     * Delete an admin user
     *
     * @param AdminUser $user User to delete
     *
     * @return bool
     */
    public function deleteAdminUser(AdminUser $user)
    {
        $this->dispatcher->dispatchAdminUserEvent(AdminUserEvent::PRE_DELETE, $user);
        $this->repository->delete($user);
        $this->dispatcher->dispatchAdminUserEvent(AdminUserEvent::POST_DELETE, $user);
        return true;
    }

    /**
     * Performs authentication on a given username and password pair
     *
     * @param string $username Username to check
     * @param string $password Password to check
     *
     * @return bool|AdminUser
     */
    public function authenticateAdminUser($username, $password)
    {
        $user = $this->getActiveAdminUserByUsername($username);
        if (!$user) {
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


    /**
     * Get an active admin user by specified username
     *
     * @param string $username Username to check
     *
     * @return null|AdminUser
     */
    public function getActiveAdminUserByUsername($username)
    {
        $user = $this->repository->getUserByUsername($username);
        if (!$user) {
            return null;
        }

        if (!$user->getActive()) {
            return null;
        }
        return $user;
    }


    /**
     * Perform logout of current user
     *
     * @return bool
     */
    public function logoutUser()
    {
        $this->session->set('admin_user_id', null);
        $this->session->set('last_admin_action', null);
        return true;
    }

    /**
     * Adds a new admin user
     *
     * @param string $userName Username
     * @param string $password Password (plain text)
     * @param string $realName Real name of user
     *
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
     * Changes a password for the given user
     *
     * @param AdminUser $user     User object
     * @param string    $password New password (plain text)
     */
    public function changeUserPassword(AdminUser $user, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user->setPassword($hashedPassword);
        $this->repository->save($user);
        $this->repository->flush();
    }

    /**
     * Checks if a username is already registered
     *
     * @param string $username Username to check
     *
     * @return bool
     */
    public function userExists($username)
    {
        $user = $this->repository->getUserByUsername($username);
        return ($user) ? true : false;
    }

    /**
     * Find a user by their e-mail (usernames are e-mail addresses)
     *
     * @param string $email Email/Username to check
     *
     * @return AdminUser|null
     */
    public function findSingleUserByEmail($email)
    {
        $user = $this->repository->getUserByUsername($email);
        return $user;
    }

    /**
     * Returns a list of admin users
     *
     * @param AdminUserList $filter Filter model
     *
     * @return array
     */
    public function getAdminUserList(AdminUserList $filter)
    {
        return $this->repository->getAdminUserList($filter);
    }

    /**
     * Saves an admin user and fires event handlers around user saving
     *
     * @param AdminUser $user User to save
     *
     * @return bool
     */
    public function saveAdminUser(AdminUser $user)
    {
        $this->dispatcher->dispatchAdminUserEvent(AdminUserEvent::PRE_SAVE, $user);
        $this->repository->save($user);
        $this->repository->flush();
        $this->dispatcher->dispatchAdminUserEvent(AdminUserEvent::POST_SAVE, $user);
        return true;
    }
}
