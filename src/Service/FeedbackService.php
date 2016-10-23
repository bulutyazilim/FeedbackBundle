<?php


namespace He8us\FeedbackBundle\Service;

use He8us\FeedbackBundle\Entity\Feedback;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class FeedbackService
 *
 * @package He8us\FeedbackBundle\Service
 * @author Cedric Michaux <cedric@he8us.be>
 */
class FeedbackService extends AbstractService
{

    protected $entityClass = Feedback::class;

    /**
     * @param Feedback $feedback
     * @param Request  $request
     *
     * @return $this
     */
    public function createFeedback(Feedback $feedback, Request $request)
    {
        $entityManager = $this->getManager();

        $feedback
            ->setReferrer($request->headers->get('referer'))
            ->setSenderIp($request->getClientIp())
            ->setStatus(Feedback::STATUS_NONE);

        $entityManager->persist($feedback);
        $entityManager->flush();

        return $this;
    }

    /**
     * @param $id
     *
     * @return Feedback|null
     */
    public function findById($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * @param string $status
     *
     * @return Feedback[]
     */
    public function findByStatus(string $status)
    {
        return $this->getRepository()->findBy(['status' => $status, 'deleted' => false]);
    }


    /**
     * @param Feedback $feedback
     *
     * @return $this
     */
    public function delete(Feedback $feedback)
    {
        $feedback->setDeleted(true);
        $this->save($feedback);

        return $this;
    }

    /**
     * @param Feedback $feedback
     *
     * @return Feedback
     */
    public function save(Feedback $feedback)
    {
        $entityManager = $this->getManager();
        $entityManager->persist($feedback);
        $entityManager->flush();

        return $feedback;
    }
}
