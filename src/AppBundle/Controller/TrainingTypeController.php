<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TrainingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Trainingtype controller.
 *
 */
class TrainingTypeController extends Controller
{
    /**
     * Lists all trainingType entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $trainingTypes = $em->getRepository('AppBundle:TrainingType')->findAll();

        return $this->render('trainingtype/index.html.twig', array(
            'trainingTypes' => $trainingTypes,
        ));
    }

    /**
     * Creates a new trainingType entity.
     *
     */
    public function newAction(Request $request)
    {
        $trainingType = new Trainingtype();
        $form = $this->createForm('AppBundle\Form\TrainingTypeType', $trainingType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trainingType);
            $em->flush($trainingType);
            $this->addFlash(
                'notice',
                'Le type de formation a été bien enregistré'
            );
            return $this->redirectToRoute('trainingtype_edit', array('id' => $trainingType->getId()));
        }

        return $this->render('trainingtype/new.html.twig', array(
            'trainingType' => $trainingType,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a trainingType entity.
     *
     */
    public function showAction(TrainingType $trainingType)
    {
        $deleteForm = $this->createDeleteForm($trainingType);

        return $this->render('trainingtype/show.html.twig', array(
            'trainingType' => $trainingType,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing trainingType entity.
     *
     */
    public function editAction(Request $request, TrainingType $trainingType)
    {
        $deleteForm = $this->createDeleteForm($trainingType);
        $editForm = $this->createForm('AppBundle\Form\TrainingTypeType', $trainingType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'notice',
                'Le type de formation a été bien modifié'
            );
            return $this->redirectToRoute('trainingtype_edit', array('id' => $trainingType->getId()));
        }

        return $this->render('trainingtype/edit.html.twig', array(
            'trainingType' => $trainingType,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a trainingType entity.
     *
     */
    public function deleteAction(Request $request, TrainingType $trainingType)
    {
        $form = $this->createDeleteForm($trainingType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($trainingType);
            $em->flush();
            $this->addFlash(
                'notice',
                'Le type de formation a été bien supprimé'
            );
        }

        return $this->redirectToRoute('trainingtype_index');
    }

    /**
     * Creates a form to delete a trainingType entity.
     *
     * @param TrainingType $trainingType The trainingType entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TrainingType $trainingType)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('trainingtype_delete', array('id' => $trainingType->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
