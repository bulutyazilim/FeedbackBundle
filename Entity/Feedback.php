<?php

namespace He8us\FeedbackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="feedback")
 */
class Feedback
{
    use TimestampableEntity;

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
     * @var string
     *
     */
    protected $screenshot;
    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    protected $body;

    /**
     * @var bool
     */
    protected $deleted;

    /**
     * @var integer
     */
    private $status;
    /**
     * @var string
     */
    private $senderIp;
    /**
     * @var string
     */
    private $referrer;
    /**
     * @var integer
     */
    private $loggedUser;
    /**
     * @var string
     */
    private $email;
    /**
     * @var integer
     */
    private $category;

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
     *
     * @return Feedback
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param $deleted
     *
     * @return $this
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
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
     * Set senderIp
     *
     * @param string $senderIp
     *
     * @return Feedback
     */
    public function setSenderIp($senderIp)
    {
        $this->senderIp = $senderIp;

        return $this;
    }

    /**
     * Get referrer
     *
     * @return string
     */
    public function getReferrer()
    {
        return $this->referrer;
    }

    /**
     * Set referrer
     *
     * @param string $referrer
     *
     * @return Feedback
     */
    public function setReferrer($referrer)
    {
        $this->referrer = $referrer;

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
     * Set loggedUser
     *
     * @param integer $loggedUser
     *
     * @return Feedback
     */
    public function setLoggedUser($loggedUser)
    {
        $this->loggedUser = $loggedUser;

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
     * Set email
     *
     * @param string $email
     *
     * @return Feedback
     */
    public function setEmail($email)
    {
        $this->email = $email;

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
     * Set category
     *
     * @param integer $category
     *
     * @return Feedback
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return string
     */
    public function getScreenshot()
    {
        return $this->screenshot;
    }

    /**
     * @param string $screenshot
     */
    public function setScreenshot($screenshot)
    {
        $this->screenshot = $screenshot;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getBody();
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
     * Set body
     *
     * @param string $body
     *
     * @return Feedback
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }
}
