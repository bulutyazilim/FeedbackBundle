<?php

namespace OkulBilisim\FeedbackBundle\Controller;

use Okulbilisim\FeedbackBundle\Entity\Feedback;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
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
        $categories = $this->container->getParameter('feedback_categories');
        $data['categories'] = $categories;
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

    public function replyAction(Request $request, Feedback $id)
    {
        $data = [];
        $data['message'] = $id;
        $data['toemail'] = $this->container->getParameter('system_email');

        if ($request->isMethod('POST')) {
            $this->sendMessage($request, $id);
        }
        return $this->render('OkulbilisimFeedbackBundle:FeedbackAdmin:reply.html.twig', $data);
    }

    public function sendMessage(Request $request, Feedback $feedback)
    {
        $form = $request->get('message');
        $mailer = $this->container->get('mailer');
        $message = $mailer->createMessage()
            ->setSubject($form['subject'])
            ->setFrom($this->container->getParameter('system_email'))
            ->setTo($feedback->getEmail())
            ->setBody(
                $this->container->get('twig')->render($this->container->getParameter('feedback_reply_mail_layout'), ['form' => $form, 'feedback' => $feedback])
            )
            ->setContentType('text/html');
        $mailer->send($message);

        /** @var Session $session */
        $session = $this->container->get('session');
        $session->getFlashBag()->add('success',$this->get('translator')->trans("Message send successfully."));
    }
}