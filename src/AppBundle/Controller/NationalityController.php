<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Nationality;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Nationality controller.
 *
 */
class NationalityController extends Controller
{
    /**
     * Lists all nationality entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $nationalities = $em->getRepository('AppBundle:Nationality')->findAll();

        return $this->render('nationality/index.html.twig', array(
            'nationalities' => $nationalities,
        ));
    }

    /**
     * Creates a new nationality entity.
     *
     */
    public function newAction(Request $request)
    {
        $nationality = new Nationality();
        $form = $this->createForm('AppBundle\Form\NationalityType', $nationality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($nationality);
            $em->flush($nationality);
            $this->addFlash(
                'notice',
                'La nationalité a été bien enregistré'
            );
            return $this->redirectToRoute('nationality_edit', array('id' => $nationality->getId()));
        }

        return $this->render('nationality/new.html.twig', array(
            'nationality' => $nationality,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a nationality entity.
     *
     */
    public function showAction(Nationality $nationality)
    {
        $deleteForm = $this->createDeleteForm($nationality);

        return $this->render('nationality/show.html.twig', array(
            'nationality' => $nationality,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing nationality entity.
     *
     */
    public function editAction(Request $request, Nationality $nationality)
    {
        $deleteForm = $this->createDeleteForm($nationality);
        $editForm = $this->createForm('AppBundle\Form\NationalityType', $nationality);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'notice',
                'La nationalité a été bien modifié'
            );
            return $this->redirectToRoute('nationality_edit', array('id' => $nationality->getId()));
        }

        return $this->render('nationality/edit.html.twig', array(
            'nationality' => $nationality,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a nationality entity.
     *
     */
    public function deleteAction(Request $request, Nationality $nationality)
    {
        $form = $this->createDeleteForm($nationality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($nationality);
            $em->flush();
            $this->addFlash(
                'notice',
                'La nationalité a été bien supprimé'
            );
        }

        return $this->redirectToRoute('nationality_index');
    }

    /**
     * Creates a form to delete a nationality entity.
     *
     * @param Nationality $nationality The nationality entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Nationality $nationality)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('nationality_delete', array('id' => $nationality->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
