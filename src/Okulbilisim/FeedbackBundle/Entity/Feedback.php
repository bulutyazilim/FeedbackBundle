<?php

namespace Okulbilisim\FeedbackBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="feedback")
 */
class Feedback {

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
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $by;

    /**
     * @var text
     *
     * @Assert\NotBlank()
     */
    protected $body;

    /**
     * Get the id
     * 
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Get the name
     * 
     * @return string
     */
    public function getBy() {
        return $this->by;
    }

    /**
     * Set the by
     * 
     * @param string $by
     * @return Feedback
     */
    public function setBy($by) {
        $this->by = $by;
        return $this;
    }

    /**
     * Get the status
     * 
     * @return integer
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param  integer
     * @return Feedback
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

}
