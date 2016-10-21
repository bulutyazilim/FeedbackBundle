<?php

namespace He8us\FeedbackBundle\Service;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use He8us\FeedbackBundle\Entity\Category;
use He8us\FeedbackBundle\Entity\CategoryRepository;


/**
 * Class Categories
 *
 * @package He8us\FeedbackBundle\Service
 * @author Cedric Michaux <cedric@he8us.be>
 */
class CategoryService
{

    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    /**
     * CategoryService constructor.
     *
     * @param ManagerRegistry $managerRegistry
     *
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }


    /**
     * @param string $name
     * @param string $label
     *
     * @return Category
     */
    public function createCategory(string $name, string $label = ""):Category
    {

        $category = new Category();
        $category->setName($name);
        $category->setLabel(empty($label) ? $name : $label);

        $manager = $this->getManager();
        $manager->persist($category);
        $manager->flush();

        return $category;
    }

    /**
     * @return EntityManager|null
     */
    private function getManager():EntityManager
    {
        return $this->managerRegistry->getManagerForClass(Category::class);
    }

    /**
     * @param Category $category
     *
     * @return CategoryService
     */
    public function deleteCategory(Category $category):CategoryService
    {
        $category->setDeleted(true);
        return $this;
    }

    /**
     * @return Category[]
     */
    public function getCategories()
    {
        return $this->getRepository()->findAllNotDeleted();
    }

    /**
     * @return CategoryRepository
     */
    private function getRepository():CategoryRepository
    {
        return $this->getManager()->getRepository(Category::class);
    }
}
