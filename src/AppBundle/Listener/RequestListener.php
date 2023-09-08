<?php
/**
 * Listener service File
 *
 * PHP version 7
 *
 * @category Listener
 * @package  Service
 * @author   Ouchayan Hamid <ouchayan.h@gmail.com>
 */
namespace AppBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Search service Class
 *
 * @category Class
 * @package  RequestListener
 * @author   Ouchayan Hamid <ouchayan.h@gmail.com>
 */

class RequestListener
{

    public $container;
    public $session;
    public $router;

    /**
     * Constructor function
     *
     * @param object $container ContainerInterface object
     * @param object $session   Session object
     * @param object $router    Route object
     * 
     * @return void
     */
    public function __construct(ContainerInterface $container, Session $session, $router
    ) { 
    
        $this->session = $session;
        $this->container = $container;
        $this->router = $router;
    }

    /**
     * Get the request object
     * 
     * @return object
     */
    public function getRequest() 
    {
        return $this->container->get('request');
    }

    /**
     * Check if the logged user has the permission to access to the current page
     * 
     * @param object $event GetResponseEvent object
     * 
     * @return void
     */
    public function onKernelRequest(GetResponseEvent $event) 
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
            $pathInfo = $this->container->get('request')->getPathInfo();

            $currentRoute = $this->container->get('request')->get('_route');
            //die($currentRoute);
            if ($currentRoute != "fos_user_security_login"
                && $currentRoute != "fos_user_security_login"
                && $currentRoute != "fos_user_resetting_request"
                && $currentRoute != "register"
                && $currentRoute != "fos_user_resetting_send_email"
                && $currentRoute != "fos_user_resetting_reset"
                && $currentRoute != "showMessageRegister"
                && $currentRoute != "confirme_account"
                && $currentRoute != "init_password"
                && $currentRoute != "showMessageInitPassword"
                && $currentRoute != "user_login_admin"
                && $currentRoute != "default"
                && $currentRoute != ""
            ) {
                $token = $this->container->get('security.context')->getToken();
                $user = $token->getUser();
                if ($user == "anon.") {
                    if(0 === strpos($pathInfo, "/admin") ){
                        $url = $this->router->generate("user_login_admin");
                        $event->setResponse(new RedirectResponse($url));
                    } else {
                        $url = $this->router->generate("fos_user_security_login");
                        $this->container->get('session')->getFlashBag()->add(
                            'logout',
                            'Votre session a été expiré.');
                        $event->setResponse(new RedirectResponse($url));
                    }

                }else{
                    if($user->getRole() == "candidat" && 0 === strpos($pathInfo, "/admin") ){
                        die("Access diened");
                    }
                }
            }
        }
    }

}
