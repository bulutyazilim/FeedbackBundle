<?php
/**
 * This file is part of the he8us/feedback package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace He8us\FeedbackBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Category
 *
 * @package He8us\FeedbackBundle\Entity
 * @author Cedric Michaux <cedric@he8us.be>
 * @ORM\Entity(repositoryClass="He8us\FeedbackBundle\Entity\CategoryRepository")
 */
class Category
{

    /**
     * @var string
     *
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     */
    private $label;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="He8us\FeedbackBundle\Entity\Feedback", mappedBy="category")
     */
    private $feedbacks;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $deleted;

    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->feedbacks = new ArrayCollection();
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
     * @param string $id
     *
     * @return Category
     */
    public function setId(string $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     *
     * @return Category
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getFeedbacks(): ArrayCollection
    {
        return $this->feedbacks;
    }

    /**
     * @param ArrayCollection $feedbacks
     */
    public function setFeedbacks(ArrayCollection $feedbacks)
    {
        $this->feedbacks = $feedbacks;
    }

    /**
     * @return boolean
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * @param boolean $deleted
     *
     * @return $this
     */
    public function setDeleted(bool $deleted)
    {
        $this->deleted = $deleted;
        return $this;
    }


}
