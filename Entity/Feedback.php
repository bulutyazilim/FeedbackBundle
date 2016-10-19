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
     * @ORM\Column(type="text", nullable=true)
     */
    protected $screenshot;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(type="text")
     */
    protected $body;


    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $deleted;

    /**
     * @var string
     * @ORM\Column(type="string", length=10)
     */
    protected $status;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $senderIp;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $referrer;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\Email()
     */
    protected $email;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="id")
     */
    protected $category;

    /**
     * Feedback constructor.
     */
    public function __construct()
    {
        $this->deleted = false;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return $this
     */
    public function setStatus(string $status)
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
     * @param bool $deleted
     *
     * @return $this
     */
    public function setDeleted(bool $deleted)
    {
        $this->deleted = $deleted;
        return $this;
    }

    public function delete()
    {
        $this->deleted = true;
    }

    /**
     * @return string
     */
    public function getSenderIp()
    {
        return $this->senderIp;
    }

    /**
     * @param string $senderIp
     *
     * @return $this
     */
    public function setSenderIp(string $senderIp)
    {
        $this->senderIp = $senderIp;

        return $this;
    }

    /**
     * @return string
     */
    public function getReferrer()
    {
        return $this->referrer;
    }

    /**
     * @param string $referrer
     *
     * @return $this
     */
    public function setReferrer(string $referrer)
    {
        $this->referrer = $referrer;

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
     * @return $this
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     *
     * @return $this
     */
    public function setCategory(Category $category)
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
    public function setScreenshot(string $screenshot)
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
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param $body
     *
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }
}
