<?php


namespace OkulBilisim\FeedbackBundle\Twig;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Class FeedbackExtension
 * @package Okulbilisim\FeedbackBundle\Twig
 */
class FeedbackExtension extends \Twig_Extension
{
    /** @var EntityManager */
    private $em;

    /** @var  ContainerInterface */
    private $container;
    public function __construct(ContainerInterface $container, SecurityContext $context)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('feedback_widget',[$this,'widget'])
        ];
    }
    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('loggedUser', [$this, 'loggedUser']),
            new \Twig_SimpleFilter("feedback_category",[$this,'categories'])
        ];
    }

    /**
     * @param $category
     * @return string
     */
    public function categories($category)
    {
        $categories = $this->container->getParameter('feedback_categories');
        foreach ($categories as $cat) {
            if($cat['id']==$category){
                return $cat['name'];
            }
        }
        return "null";
    }

    /**
     * @param $user
     * @return mixed
     */
    public function loggedUser($user)
    {
        if(!is_int($user) || empty($user)){
            return $user;
        }
        //@todo user entity ???
    }

    public function widget()
    {
        $data = [];
        $data['categories'] = $this->container->getParameter('feedback_categories');
        $twig = $this->container->get('twig');
        $content= $twig->render('OkulbilisimFeedbackBundle:Feedback:index.html.twig',$data);
        return $content;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'feedback_extension';
    }
} 