<?php

namespace BulutYazilim\FeedbackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="feedback")
 */
class Feedback
{
    const STATUS_NONE = 0;
    const STATUS_READ = 1;
    const STATUS_DONE = 2;
    /**
     * @var string
     *
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var integer
     * @Expose
     */
    private $status;

    /**
     * @var screenshot
     *
     */
    protected $screenshot;


    /**
     * @var text
     *
     * @Assert\NotBlank()
     */
    protected $body;
    protected $created;
    protected $updated;
    protected $deleted;

    /**
     * Get the id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Get the status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param  integer
     * @return Feedback
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function getDeleted()
    {
        return $this->deleted;
    }

    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
        return $this;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    public function delete()
    {
        $this->deleted = true;
    }

    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * @var string
     */
    private $senderIp;

    /**
     * @var string
     */
    private $referer;

    /**
     * @var integer
     */
    private $loggedUser;

    /**
     * @var string
     */
    private $email;


    /**
     * Set senderIp
     *
     * @param string $senderIp
     * @return Feedback
     */
    public function setSenderIp($senderIp)
    {
        $this->senderIp = $senderIp;

        return $this;
    }

    /**
     * Get senderIp
     *
     * @return string
     */
    public function getSenderIp()
    {
        return $this->senderIp;
    }

    /**
     * Set referer
     *
     * @param string $referer
     * @return Feedback
     */
    public function setReferer($referer)
    {
        $this->referer = $referer;

        return $this;
    }

    /**
     * Get referer
     *
     * @return string
     */
    public function getReferer()
    {
        return $this->referer;
    }

    /**
     * Set loggedUser
     *
     * @param integer $loggedUser
     * @return Feedback
     */
    public function setLoggedUser($loggedUser)
    {
        $this->loggedUser = $loggedUser;

        return $this;
    }

    /**
     * Get loggedUser
     *
     * @return integer
     */
    public function getLoggedUser()
    {
        return $this->loggedUser;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Feedback
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return Feedback
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @var integer
     */
    private $category;


    /**
     * Set category
     *
     * @param integer $category
     * @return Feedback
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return integer
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return screenshot
     */
    public function getScreenshot()
    {
        return $this->screenshot;
    }

    /**
     * @param screenshot $screenshot
     */
    public function setScreenshot($screenshot)
    {
        $this->screenshot = $screenshot;
    }
}
