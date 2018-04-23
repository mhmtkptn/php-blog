<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 17.07.2017
 * Time: 13:32
 */

namespace src\entity;


class User extends Entity
{

    /**
     * @var integer
     */
    protected $id;
    /**
     * @var string
     */
    protected $nameSurname;
    /**
     * @var string
     */
    protected $userName;
    /**
     * @var string
     */
    protected $eMail;
    /**
     * @var string
     */
    protected $password;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getNameSurname()
    {
        return $this->nameSurname;
    }

    /**
     * @param string $nameSurname
     */
    public function setNameSurname($nameSurname)
    {
        $this->nameSurname = $nameSurname;

        return $this;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * @return string
     */
    public function getEMail()
    {
        return $this->eMail;
    }

    /**
     * @param string $eMail
     */
    public function setEMail($eMail)
    {
        $this->eMail = $eMail;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }



}