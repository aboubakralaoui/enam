<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SchoolField;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Schoolfield controller.
 *
 */
class SchoolFieldController extends Controller
{
    /**
     * Lists all schoolField entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $schoolFields = $em->getRepository('AppBundle:SchoolField')->findAll();

        return $this->render('schoolfield/index.html.twig', array(
            'schoolFields' => $schoolFields,
        ));
    }

    /**
     * Creates a new schoolField entity.
     *
     */
    public function newAction(Request $request)
    {
        $schoolField = new Schoolfield();
        $form = $this->createForm('AppBundle\Form\SchoolFieldType', $schoolField);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($schoolField);
            $em->flush($schoolField);
            $this->addFlash(
                'notice',
                'La filiére a été bien enregistré'
            );

            return $this->redirectToRoute('schoolfield_edit', array('id' => $schoolField->getId()));
        }

        return $this->render('schoolfield/new.html.twig', array(
            'schoolField' => $schoolField,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a schoolField entity.
     *
     */
    public function showAction(SchoolField $schoolField)
    {
        $deleteForm = $this->createDeleteForm($schoolField);

        return $this->render('schoolfield/show.html.twig', array(
            'schoolField' => $schoolField,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing schoolField entity.
     *
     */
    public function editAction(Request $request, SchoolField $schoolField)
    {
        $deleteForm = $this->createDeleteForm($schoolField);
        $editForm = $this->createForm('AppBundle\Form\SchoolFieldType', $schoolField);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'notice',
                'La filiére a été bien modifié'
            );

            return $this->redirectToRoute('schoolfield_edit', array('id' => $schoolField->getId()));
        }

        return $this->render('schoolfield/edit.html.twig', array(
            'schoolField' => $schoolField,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a schoolField entity.
     *
     */
    public function deleteAction(Request $request, SchoolField $schoolField)
    {
        $form = $this->createDeleteForm($schoolField);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($schoolField);
            $em->flush();
            $this->addFlash(
                'notice',
                'La filiére a été bien supprimé'
            );
        }

        return $this->redirectToRoute('schoolfield_index');
    }

    /**
     * Creates a form to delete a schoolField entity.
     *
     * @param SchoolField $schoolField The schoolField entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SchoolField $schoolField)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('schoolfield_delete', array('id' => $schoolField->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
