<?php
/**
 * Date: 27.11.14
 * Time: 10:43
 */
namespace Okulbilisim\FeedbackBundle\Controller;

use Okulbilisim\FeedbackBundle\Entity\Feedback;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FeedbackAdminController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
{
    public function indexAction(Request $request, $status = 0)
    {
        if ($status < 0 || $status > 2)
            $status = 0;
        $data = [];
        $repo = $this->getDoctrine()->getManager()->getRepository('OkulbilisimFeedbackBundle:Feedback');
        $entities = $repo->findBy(['status' => $status, 'deleted' => false]);
        $data['status'] = $status;
        $data['entities'] = $entities;

        return $this->render("OkulbilisimFeedbackBundle:FeedbackAdmin:index.html.twig", $data);
    }

    public function deleteAction(Request $request, $id)
    {
        if (!$request->isXmlHttpRequest())
            throw new NotFoundHttpException("Not found!");

        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $feedback = $em->find("OkulbilisimFeedbackBundle:Feedback", $id);
        if (!$feedback)
            throw new NotFoundHttpException("Not found!");

        $feedback->setDeleted(true);
        $em->persist($feedback);
        $em->flush();

        return JsonResponse::create(['status' => true]);
    }

    public function markAsAction(Request $request, $id, $type = "read")
    {
        if (!$request->isXmlHttpRequest())
            throw new NotFoundHttpException("Not found!");

        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $feedback = $em->find("OkulbilisimFeedbackBundle:Feedback", $id);
        if (!$feedback)
            throw new NotFoundHttpException("Not found!");

        if ($type == 'read') {
            $feedback->setStatus(Feedback::STATUS_READ);
        } elseif ($type == 'done') {
            $feedback->setStatus(Feedback::STATUS_DONE);
        }

        $em->persist($feedback);

        $em->flush();

        return JsonResponse::create(['status' => true]);
    }
}