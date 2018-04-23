<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 28.07.2017
 * Time: 11:36
 */

namespace src\entity;


class Contact extends Entity
{


    /**
     * @var integer
     */
    protected $id;

    protected $nameSurname;

    protected $eMail;

    protected $title;

    protected $message;

    protected $date;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getNameSurname()
    {
        return $this->nameSurname;
    }

    /**
     * @param mixed $nameSurname
     */
    public function setNameSurname($nameSurname)
    {
        $this->nameSurname = $nameSurname;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getEMail()
    {
        return $this->eMail;
    }

    /**
     * @param mixed $eMail
     */
    public function setEMail($eMail)
    {
        $this->eMail = $eMail;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;

    }


    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;

    }


}