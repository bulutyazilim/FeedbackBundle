<?php
/**
 * This file is part of the he8us/feedback package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace He8us\FeedbackBundle\Service;

use He8us\FeedbackBundle\Entity\Category;


/**
 * Class Categories
 *
 * @package He8us\FeedbackBundle\Service
 * @author Cedric Michaux <cedric@he8us.be>
 */
class CategoryService extends AbstractService
{

    protected $entityClass = Category::class;

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

        $this->save($category);

        return $category;
    }

    public function save(Category $category)
    {
        $manager = $this->getManager();

        $manager->persist($category);
        $manager->flush();
    }

    /**
     * @param Category $category
     *
     * @return CategoryService
     */
    public function deleteCategory(Category $category):CategoryService
    {
        $category->setDeleted(true);

        $this->save($category);

        return $this;
    }

    /**
     * @return Category[]
     */
    public function getCategories()
    {
        return $this->getRepository()->findAllNotDeleted();
    }


    public function getAllCategories()
    {
        return $this->getRepository()->findAll();
    }

}
