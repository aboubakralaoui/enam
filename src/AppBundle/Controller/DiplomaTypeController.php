<?php

namespace AppBundle\Controller;

use AppBundle\Entity\DiplomaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Diplomatype controller.
 *
 */
class DiplomaTypeController extends Controller
{
    /**
     * Lists all diplomaType entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $diplomaTypes = $em->getRepository('AppBundle:DiplomaType')->findAll();

        return $this->render('diplomatype/index.html.twig', array(
            'diplomaTypes' => $diplomaTypes,
        ));
    }

    /**
     * Creates a new diplomaType entity.
     *
     */
    public function newAction(Request $request)
    {
        $diplomaType = new Diplomatype();
        $form = $this->createForm('AppBundle\Form\DiplomaTypeType', $diplomaType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($diplomaType);
            $em->flush($diplomaType);
            $this->addFlash(
                'notice',
                'Le type de diplome a été bien enregistré'
            );
            return $this->redirectToRoute('diplomatype_edit', array('id' => $diplomaType->getId()));
        }

        return $this->render('diplomatype/new.html.twig', array(
            'diplomaType' => $diplomaType,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a diplomaType entity.
     *
     */
    public function showAction(DiplomaType $diplomaType)
    {
        $deleteForm = $this->createDeleteForm($diplomaType);

        return $this->render('diplomatype/show.html.twig', array(
            'diplomaType' => $diplomaType,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing diplomaType entity.
     *
     */
    public function editAction(Request $request, DiplomaType $diplomaType)
    {
        $deleteForm = $this->createDeleteForm($diplomaType);
        $editForm = $this->createForm('AppBundle\Form\DiplomaTypeType', $diplomaType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'notice',
                'Le type de diplome a été bien modifié'
            );
            return $this->redirectToRoute('diplomatype_edit', array('id' => $diplomaType->getId()));
        }

        return $this->render('diplomatype/edit.html.twig', array(
            'diplomaType' => $diplomaType,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a diplomaType entity.
     *
     */
    public function deleteAction(Request $request, DiplomaType $diplomaType)
    {
        $form = $this->createDeleteForm($diplomaType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($diplomaType);
            $em->flush();
            $this->addFlash(
                'notice',
                'Le type de diplome a été bien supprimé'
            );
        }

        return $this->redirectToRoute('diplomatype_index');
    }

    /**
     * Creates a form to delete a diplomaType entity.
     *
     * @param DiplomaType $diplomaType The diplomaType entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DiplomaType $diplomaType)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('diplomatype_delete', array('id' => $diplomaType->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Create Sim
     *
     * @return object
     */
    public function getDiplomaTypeByTrainingTypeIdAction($trainingTypeId)
    {
        $em = $this->getDoctrine()->getManager();
        $trainingtype = $em->getRepository('AppBundle:TrainingType')->findOneById($trainingTypeId);
        $diplomas = $em->getRepository('AppBundle:Diploma')->findByTrainingType($trainingtype);
        $diplomaTypes= array();
        $ids=array();
        foreach($diplomas as $diploma){
            if(!in_array($diploma->getDiplomaType()->getId(),$ids)){
                array_push($diplomaTypes,array('id'=> $diploma->getDiplomaType()->getId() ,'value'=> $diploma->getDiplomaType()->getName()));
                array_push($ids,$diploma->getDiplomaType()->getId());
            }
        }
        return new JsonResponse($diplomaTypes);
    }
}
