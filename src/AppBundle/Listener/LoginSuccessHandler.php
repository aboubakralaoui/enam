<?php
// AcmeBundle\Security\LoginSuccessHandler.php

namespace AppBundle\Listener;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface {

    protected $router;
    protected $authorizationChecker;
    protected $container;
    protected $entityManager;

    public function __construct(Router $router, AuthorizationChecker $authorizationChecker, ContainerInterface $container, EntityManager $entityManager) {
        $this->container = $container;
        $this->router = $router;
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token) {
        $token = $this->container->get('security.context')->getToken();
        $user = $token->getUser();

        $documentType = $this->entityManager->getRepository('AppBundle:DocumentType')->findOneById(11);
        $document = $this->entityManager->getRepository('AppBundle:Document')->findOneBy(array('user' => $user, 'documentType' => $documentType));
        $response = null;
        $application = $user->getApplications()->First();
        $checkDocuments = false;
        if (is_object($application)) {
          if (count($application->getDocuments()) == 5) {
              $checkDocuments = true;
          }
        }

        if ( (count($user->getApplications()) > 0 && $checkDocuments == true)|| count($user->getOnlinePayments()) > 0) {
            $response = new RedirectResponse($this->router->generate('online_payment'));
        } elseif (count($user->getTrainings())>0) {
            $response = new RedirectResponse($this->router->generate('application'));
        } else {
            $response = new RedirectResponse($this->router->generate('training_new'));
        }
        return $response;
    }

}
