<?php

namespace Pantono\Core\Model\Config;

class Database
{
    private $host;
    private $driver;
    private $username;
    private $password;
    private $databaseName;

    public function __construct($data = array())
    {
        $this->setData($data);
    }

    public function setData(array $data)
    {
        foreach ($data as $key => $value) {
            $setter = str_replace('_', ' ', $key);
            $setter = ucwords($setter);
            $setter = 'set'.str_replace(' ', '', $setter);
            $this->{$setter}($value);
        }
    }

    /**
     * @return mixed
     */
    public function getDatabaseName()
    {
        return $this->databaseName;
    }

    /**
     * @param mixed $databaseName
     */
    public function setDatabaseName($databaseName)
    {
        $this->databaseName = $databaseName;
    }

    /**
     * @return mixed
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @param mixed $driver
     */
    public function setDriver($driver)
    {
        $this->driver = $driver;
    }

    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param mixed $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }
}
