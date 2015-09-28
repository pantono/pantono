<?php namespace Pantono\Acl\Model\Filter;

/**
 * Model used for filtering admin users
 *
 * Class AdminUserList
 *
 * @package Pantono\Acl\Model\Filter
 * @author Chris Burton <csburton@gmail.com>
 */
class AdminUserList
{
    private $email;
    private $supplierId;
    private $active = true;

    /**
     * Gets email address
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets email address
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Gets current supplier id
     *
     * @return integer
     */
    public function getSupplierId()
    {
        return intval($this->supplierId);
    }

    /**
     * Set the current supplier ID
     *
     * @param integer $supplierId
     */
    public function setSupplierId($supplierId)
    {
        $this->supplierId = $supplierId;
    }

    /**
     * Returns status of active state to search for
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Sets status of the active state to search for
     *
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }
}
