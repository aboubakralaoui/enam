<?php

namespace AppBundle\Controller;

use AppBundle\Entity\School;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * School controller.
 *
 */
class SchoolController extends Controller
{
    /**
     * Lists all school entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $schools = $em->getRepository('AppBundle:School')->findAll();

        return $this->render('school/index.html.twig', array(
            'schools' => $schools,
        ));
    }

    /**
     * Creates a new school entity.
     *
     */
    public function newAction(Request $request)
    {
        $school = new School();
        $form = $this->createForm('AppBundle\Form\SchoolType', $school);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $school->setCreatedAt(new \DateTime());
            $em->persist($school);
            $em->flush($school);
            $this->addFlash(
                'notice',
                "L'établissements a été bien enregistré"
            );
            return $this->redirectToRoute('school_show', array('id' => $school->getId()));
        }

        return $this->render('school/new.html.twig', array(
            'school' => $school,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a school entity.
     *
     */
    public function showAction(School $school)
    {
        $deleteForm = $this->createDeleteForm($school);

        return $this->render('school/show.html.twig', array(
            'school' => $school,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing school entity.
     *
     */
    public function editAction(Request $request, School $school)
    {
        $deleteForm = $this->createDeleteForm($school);
        $editForm = $this->createForm('AppBundle\Form\SchoolType', $school);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $school->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'notice',
                "L'établissements a été bien modifié"
            );
            return $this->redirectToRoute('school_edit', array('id' => $school->getId()));
        }

        return $this->render('school/edit.html.twig', array(
            'school' => $school,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a school entity.
     *
     */
    public function deleteAction(Request $request, School $school)
    {
        $form = $this->createDeleteForm($school);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($school);
            $em->flush();
            $this->addFlash(
                'notice',
                "L'établissements a été bien supprimé"
            );
        }

        return $this->redirectToRoute('school_index');
    }

    /**
     * Creates a form to delete a school entity.
     *
     * @param School $school The school entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(School $school)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('school_delete', array('id' => $school->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
