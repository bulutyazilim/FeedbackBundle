<?php
/**
 * Date: 27.11.14
 * Time: 11:23
 */

namespace Okulbilisim\FeedbackBundle\Twig;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\SecurityContext;

class FeedbackExtension extends \Twig_Extension
{
    /** @var EntityManager */
    private $em;

    public function __construct(ContainerInterface $container, SecurityContext $context)
    {
        $this->em = $container->get('doctrine.orm.entity_manager');
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('loggedUser', [$this, 'loggedUser'])
        ];
    }

    public function loggedUser($user)
    {
        if(!is_int($user) || empty($user)){
            return $user;
        }
        //@todo user entity ???
    }

    public function getName()
    {
        return 'feedback_extension';
    }
} 