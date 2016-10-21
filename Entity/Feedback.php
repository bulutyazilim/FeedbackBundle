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

    const STATUS_NONE = 'none';
    const STATUS_READ = 'read';
    const STATUS_DONE = 'done';
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
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getStatus():string
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return Feedback
     */
    public function setStatus(string $status): Feedback
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * @param bool $deleted
     *
     * @return Feedback
     */
    public function setDeleted(bool $deleted): Feedback
    {
        $this->deleted = $deleted;
        return $this;
    }

    /**
     * @return string
     */
    public function getSenderIp(): string
    {
        return $this->senderIp;
    }

    /**
     * @param string $senderIp
     *
     * @return Feedback
     */
    public function setSenderIp(string $senderIp): Feedback
    {
        $this->senderIp = $senderIp;
        return $this;
    }

    /**
     * @return string
     */
    public function getReferrer(): string
    {
        return $this->referrer;
    }

    /**
     * @param string $referrer
     *
     * @return Feedback
     */
    public function setReferrer(string $referrer): Feedback
    {
        $this->referrer = $referrer;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Feedback
     */
    public function setEmail(string $email): Feedback
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return int
     */
    public function getCategory(): int
    {
        return $this->category;
    }

    /**
     * @param $category
     *
     * @return Feedback
     */
    public function setCategory($category): Feedback
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return string
     */
    public function getScreenshot(): string
    {
        return $this->screenshot;
    }

    /**
     * @param string $screenshot
     *
     * @return Feedback
     */
    public function setScreenshot(string $screenshot): Feedback
    {
        $this->screenshot = $screenshot;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getBody();
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     *
     * @return Feedback
     */
    public function setBody(string $body): Feedback
    {
        $this->body = $body;
        return $this;
    }
}
