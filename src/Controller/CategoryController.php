<?php

namespace He8us\FeedbackBundle\Controller;

use He8us\FeedbackBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Category controller.
 *
 */
class CategoryController extends Controller
{
    /**
     * Lists all category entities.
     *
     * @return Response
     */
    public function indexAction()
    {
        $categories = $this->getCategoryService()->getAllCategories();

        return $this->render('He8usFeedbackBundle:Category:index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * Creates a new category entity.
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm('He8us\FeedbackBundle\Form\CategoryType', $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getCategoryService()->save($category);
            return $this->redirectToRoute('he8us_category_admin_show', ['id' => $category->getId()]);
        }

        return $this->render('He8usFeedbackBundle:Category:new.html.twig', [
            'category' => $category,
            'form'     => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a category entity.
     *
     * @param Category $category
     *
     * @return Response
     */
    public function showAction(Category $category)
    {
        $deleteForm = $this->createDeleteForm($category);

        return $this->render('He8usFeedbackBundle:Category:show.html.twig', [
            'category'    => $category,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Creates a form to delete a category entity.
     *
     * @param Category $category The category entity
     *
     * @return Form The form
     */
    private function createDeleteForm(Category $category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('he8us_category_admin_delete', ['id' => $category->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Displays a form to edit an existing category entity.
     *
     * @param Request  $request
     * @param Category $category
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Category $category)
    {
        $deleteForm = $this->createDeleteForm($category);
        $editForm = $this->createForm('He8us\FeedbackBundle\Form\CategoryType', $category);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('he8us_category_admin_edit', ['id' => $category->getId()]);
        }

        return $this->render('He8usFeedbackBundle:Category:edit.html.twig', [
            'category'    => $category,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a category entity.
     *
     * @param Request  $request
     * @param Category $category
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Category $category)
    {
        $form = $this->createDeleteForm($category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush($category);
        }

        return $this->redirectToRoute('he8us_category_admin_homepage');
    }

    /**
     * @return \He8us\FeedbackBundle\Service\CategoryService
     */
    private function getCategoryService():\He8us\FeedbackBundle\Service\CategoryService
    {
        return $this->get('he8us_feedback.category_service');
    }
}
