<?php
/**
 * This file is part of the he8us/feedback package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace He8us\FeedbackBundle\Tests\Service;


use Doctrine\Common\Persistence\ManagerRegistry;
use He8us\FeedbackBundle\Entity\Category;
use He8us\FeedbackBundle\Entity\CategoryRepository;
use He8us\FeedbackBundle\Service\CategoryService;

class CategoryServiceTest extends ServiceTestCase
{

    /**
     * @test
     */
    public function createCategory_withNameAndLabel_ReturnCategory()
    {
        $categoryRepository = $this->mockRepository(CategoryRepository::class);

        $entityManager = $this->mockEntityManager($categoryRepository, Category::class);

        $entityManager
            ->expects($this->exactly(2))
            ->method('persist');

        $entityManager
            ->expects($this->exactly(2))
            ->method('flush');

        $managerRegistry = $this->mockManagerRegistry($entityManager, Category::class);

        $categoryService = new CategoryService($managerRegistry);

        $category = new Category();
        $category
            ->setName('name')
            ->setLabel('label');

        $categoryService->createCategory('name', 'label');

        $this->assertEquals($category, $categoryService->createCategory('name', 'label'));
    }

    /**
     * @test
     */
    public function deleteCategory_withNameAndLabel_ReturnCategoryService()
    {
        $categoryRepository = $this->mockRepository(CategoryRepository::class);

        $entityManager = $this->mockEntityManager($categoryRepository, Category::class);

        $expectedCategory = new Category();
        $expectedCategory
            ->setDeleted(true)
            ->setName('name')
            ->setLabel('label');

        $entityManager
            ->expects($this->once())
            ->method('persist')
            ->with($expectedCategory);

        $entityManager
            ->expects($this->once())
            ->method('flush');

        $managerRegistry = $this->mockManagerRegistry($entityManager, Category::class);

        $categoryService = new CategoryService($managerRegistry);


        $category = new Category();
        $category
            ->setName('name')
            ->setLabel('label');

        $categoryService->deleteCategory($category);
    }

    /**
     * @test
     */
    public function getCategories_withNoParams_CallsRepositoryFunction()
    {
        $categoryRepository = $this->mockRepository(CategoryRepository::class);

        $categoryRepository
            ->expects($this->once())
            ->method("findAllNotDeleted");


        $entityManager = $this->mockEntityManager($categoryRepository, Category::class);

        $managerRegistry = $this->mockManagerRegistry($entityManager, Category::class);

        $categoryService = new CategoryService($managerRegistry);


        $categoryService->getCategories();
    }

    public function testCategoryServiceWillFindAllCategories()
    {
        $categoryTestData = [
            new Category,
            new Category,
            new Category,
        ];

        $categoryRepository = $this->mockRepository(CategoryRepository::class);
        $categoryRepository
            ->expects($this->any())
            ->method("findAll")
            ->willReturn($categoryTestData);

        $entityManager = $this->mockEntityManager($categoryRepository, Category::class);
        $managerRegistry = $this->mockManagerRegistry($entityManager, Category::class);

        $categoryService = new CategoryService($managerRegistry);
        $returnedCategoryData = $categoryService->getAllCategories();

        $this->assertSame($categoryTestData, $returnedCategoryData);
    }

}
