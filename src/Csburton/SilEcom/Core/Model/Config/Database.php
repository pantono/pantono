<?php

namespace Csburton\SilEcom\Core\Model\Config;

class Database
{
    private $host;
    private $driver;
    private $username;
    private $password;
    private $database_name;

    public function __construct($data = array())
    {
        $this->setData($data);
    }

    public function setData(array $data)
    {
        if (isset($data['database_name'])) {
            $this->setDatabaseName($data['database_name']);
        }

        if (isset($data['driver'])) {
            $this->setDriver($data['driver']);
        }

        if (isset($data['username'])) {
            $this->setUsername($data['username']);
        }

        if (isset($data['password'])) {
            $this->setPassword($data['password']);
        }

        if (isset($data['host'])) {
            $this->setHost($data['host']);
        }
    }

    /**
     * @return mixed
     */
    public function getDatabaseName()
    {
        return $this->database_name;
    }

    /**
     * @param mixed $database_name
     */
    public function setDatabaseName($database_name)
    {
        $this->database_name = $database_name;
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