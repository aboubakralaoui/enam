<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\RegistrationType;
/**
 * Controller managing the registration
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class RegistrationController extends BaseController
{
    public function registerAction()
    {
        $request = $this->container->get('request');
        $user = $this->createUser();
        $form = $this->container->get('fos_user.registration.form');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->container->get('doctrine')->getManager();
            $user->setUsername("kdlkf");
            $em->persist($user);
            $em->flush($user);

            return $this->redirectToRoute('diplomatype_show', array('id' => $user->getId()));
        }

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Registration:register.html.'.$this->getEngine(), array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @return UserInterface
     */
    protected function createUser()
    {
        return $this->container->get('fos_user.user_manager')->createUser();
    }
}
