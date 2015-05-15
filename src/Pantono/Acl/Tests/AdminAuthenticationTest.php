<?php namespace Pantono\Acl\Tests;

use Pantono\Acl\Entity\AdminUser;
use Pantono\Contacts\Entity\Contact;

class AdminAuthentication extends \PHPUnit_Framework_TestCase
{
    private $authRepository;
    private $session;
    private $config;
    /**
     * @var \Pantono\Acl\AdminAuthentication
     */
    private $adminAuthentication;

    public function setUp()
    {
        $this->authRepository = $this->getPantonoMock('Pantono\Acl\Entity\Repository\AdminUserRepository');
        $this->session = $this->getPantonoMock('Symfony\Component\HttpFoundation\Session\Session');
        $this->config = $this->getPantonoMock('Pantono\Core\Model\Config\Config');
        $this->adminAuthentication = new \Pantono\Acl\AdminAuthentication($this->authRepository, $this->session, $this->config);
    }

    public function testGetCurrentUserWhenExists()
    {
        $userEntity = new AdminUser();
        $this->authRepository->expects($this->once())
            ->method('getUserInfo')
            ->with('1')
            ->willReturn($userEntity);
        $this->session->expects($this->once())
            ->method('get')
            ->with('admin_user_id')
            ->willReturn('1');
        $this->assertEquals($userEntity, $this->adminAuthentication->getCurrentUser());
    }

    public function testGetCurrentUserWhenNotExists()
    {
        $this->session->expects($this->once())
            ->method('get')
            ->with('admin_user_id')
            ->willReturn(null);
        $this->assertEquals(false, $this->adminAuthentication->getCurrentUser());
    }

    public function tesIsCurrentUserAuthenticated()
    {
        $this->session->expects($this->at(0))
            ->method('get')
            ->with('admin_user_id')
            ->willReturn(1);
        $this->session->expects($this->at(1))
            ->method('get')
            ->with('last_admin_action')
            ->willReturnCallback((new \DateTime)->format('Y-m-d H:i:s'));
        $this->session->expects($this->at(2))
            ->method('set')
            ->with('last_admin_action')
            ->willReturn(true);
        $this->config->expects($this->at(0))
            ->method('getItem')
            ->with('admin', 'session_timeout', 1800)
            ->willReturn('1800');
        $this->assertEquals(1, $this->adminAuthentication->isCurrentUserAuthenticated());
    }

    public function testIsCurrentUserAuthenticatedNot()
    {
        $this->session->expects($this->at(0))
            ->method('get')
            ->with('admin_user_id')
            ->willReturn(1);
        $this->session->expects($this->at(1))
            ->method('get')
            ->with('last_admin_action')
            ->willReturn((new \DateTime('-2 hour'))->format('Y-m-d H:i:s'));
        $this->config->expects($this->at(0))
            ->method('getItem')
            ->with('admin', 'session_timeout', 1800)
            ->willReturn('1800');
        $this->assertEquals(false, $this->adminAuthentication->isCurrentUserAuthenticated());
    }

    public function testAuthenticateAdminUserValid()
    {
        $adminUser = $this->getTestAdminUser();
        $this->authRepository->expects($this->once())
            ->method('getUserByUsername')
            ->willReturn($adminUser);
        $this->assertEquals($adminUser, $this->adminAuthentication->authenticateAdminUser('test', 'test'));
    }

    public function testAuthenticateAdminUserInvalidPassword()
    {
        $adminUser = $this->getTestAdminUser();
        $this->authRepository->expects($this->once())
            ->method('getUserByUsername')
            ->willReturn($adminUser);
        $this->assertEquals(false, $this->adminAuthentication->authenticateAdminUser('test', 'test1'));
    }

    public function testAuthenticateAdminUserNotExists()
    {
        $this->authRepository->expects($this->once())
            ->method('getUserByUsername')
            ->willReturn(false);
        $this->assertEquals(false, $this->adminAuthentication->authenticateAdminUser('test', 'test'));
    }


    public function testAddAdminUser()
    {
        /**
         * This test overwrites the generated password as password_hash will
         * always be different
         */
        $contact = new Contact();
        $contact->setFirstName('Chris');
        $contact->setLastName('Test');
        $generatedAdminuser = new AdminUser();
        $generatedAdminuser->setPassword(password_hash('test', PASSWORD_DEFAULT));
        $generatedAdminuser->setUsername('chris_test@test.com');
        $generatedAdminuser->setContact($contact);
        $this->authRepository->expects($this->once())
            ->method('save')
            ->willReturn(false);
        $newUser = $this->adminAuthentication->addAdminUser('chris_test@test.com', 'test', 'Chris Test');
        $generatedAdminuser->setPassword('test');
        $newUser->setPassword('test');
        $this->assertEquals($generatedAdminuser, $newUser);
    }

    public function testChangeUserPassword()
    {
        $adminUser = new AdminUser();
        $this->authRepository->expects($this->once())
            ->method('save')
            ->willReturn($adminUser);

        $this->adminAuthentication->changeUserPassword($adminUser, 'test');
    }

    public function testUserExists()
    {
        $this->authRepository->expects($this->once())
            ->method('getUserByUsername')
            ->with('test')
            ->willReturn(true);
        $this->assertEquals(true, $this->adminAuthentication->userExists('test'));
    }

    public function testUserExistsNot()
    {
        $this->authRepository->expects($this->once())
            ->method('getUserByUsername')
            ->with('test')
            ->willReturn(false);
        $this->assertEquals(false, $this->adminAuthentication->userExists('test'));
    }

    public function testFindSingleUserByEmail()
    {
        $this->authRepository->expects($this->once())
            ->method('getUserByUsername')
            ->with('test@test.com')
            ->willReturn(true);
        $this->assertEquals(true, $this->adminAuthentication->userExists('test@test.com'));
    }

    public function testFindSingleUserByEmailNot()
    {
        $this->authRepository->expects($this->once())
            ->method('getUserByUsername')
            ->with('test@test.com')
            ->willReturn(false);
        $this->assertEquals(false, $this->adminAuthentication->userExists('test@test.com'));
    }

    private function getPantonoMock($class)
    {
        return $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    private function getTestAdminUser()
    {
        $adminUser = new AdminUser();
        $adminUser->setId(1);
        $adminUser->setUsername('test');
        $password = password_hash('test', PASSWORD_DEFAULT);
        $adminUser->setPassword($password);
        return $adminUser;
    }
}
