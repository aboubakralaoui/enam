<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Diploma;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Diploma controller.
 *
 */
class DiplomaController extends Controller
{
    /**
     * Lists all diploma entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $diplomas = $em->getRepository('AppBundle:Diploma')->findAll();

        return $this->render('diploma/index.html.twig', array(
            'diplomas' => $diplomas,
        ));
    }

    /**
     * Creates a new diploma entity.
     *
     */
    public function newAction(Request $request)
    {
        $diploma = new Diploma();
        $form = $this->createForm('AppBundle\Form\DiplomaType', $diploma);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($diploma);
            $em->flush($diploma);
            $this->addFlash(
                'notice',
                'Le diplome a été bien enregistré'
            );

            return $this->redirectToRoute('diploma_edit', array('id' => $diploma->getId()));
        }

        return $this->render('diploma/new.html.twig', array(
            'diploma' => $diploma,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a diploma entity.
     *
     */
    public function showAction(Diploma $diploma)
    {
        $deleteForm = $this->createDeleteForm($diploma);

        return $this->render('diploma/show.html.twig', array(
            'diploma' => $diploma,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing diploma entity.
     *
     */
    public function editAction(Request $request, Diploma $diploma)
    {
        $deleteForm = $this->createDeleteForm($diploma);
        $editForm = $this->createForm('AppBundle\Form\DiplomaType', $diploma);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'notice',
                'Le diplome a été bien modifié'
            );

            return $this->redirectToRoute('diploma_edit', array('id' => $diploma->getId()));
        }

        return $this->render('diploma/edit.html.twig', array(
            'diploma' => $diploma,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a diploma entity.
     *
     */
    public function deleteAction(Request $request, Diploma $diploma)
    {
        $form = $this->createDeleteForm($diploma);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($diploma);
            $em->flush();
            $this->addFlash(
                'notice',
                'Le diplome a été bien supprimé'
            );
        }

        return $this->redirectToRoute('diploma_index');
    }

    /**
     * Creates a form to delete a diploma entity.
     *
     * @param Diploma $diploma The diploma entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Diploma $diploma)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('diploma_delete', array('id' => $diploma->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Create Sim
     *
     * @return object
     */
    public function getFieldsByDiplomaTypeAndTrainingTypeAction($diplomaTypeId,$trainingTypeId)
    {
        $em = $this->getDoctrine()->getManager();
        $trainingtype = $em->getRepository('AppBundle:TrainingType')->findOneById($trainingTypeId);
        $diplomatype = $em->getRepository('AppBundle:DiplomaType')->findOneById($diplomaTypeId);
        $diplomas = $em->getRepository('AppBundle:Diploma')->findBy(array("trainingType"=>$trainingtype,"diplomaType"=>$diplomatype));
        $fieldsAndSchool= array();
        foreach($diplomas as $diploma){
            array_push($fieldsAndSchool,array('id'=> $diploma->getId() ,'value'=> $diploma->getSchool()->getName() . " " . $diploma->getSchoolField()->getName()));
        }
        return new JsonResponse($fieldsAndSchool);
    }
}
