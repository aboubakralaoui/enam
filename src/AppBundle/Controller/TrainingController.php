<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Training;
use AppBundle\Form\TrainingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Training controller.
 *
 */
class TrainingController extends Controller
{
    /**
     * Lists all training entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $trainings = $em->getRepository('AppBundle:Training')->findAll();

        return $this->render('training/index.html.twig', array(
            'trainings' => $trainings,
        ));
    }

    /**
     * Creates a new training entity.
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $training = new Training();
        $token = $this->container->get('security.context')->getToken();
        $user=$token->getUser();
        $trainings = $em->getRepository('AppBundle:Training')->findBy(array("user" => $user),array("yearGraduation" => "desc"));
        $lastTraining = $em->getRepository('AppBundle:Training')->findBy(array("user" => $user),array("yearGraduation" => "desc"));
        $lastTraining = count($lastTraining) > 0 ? $lastTraining[0] : null;
        $training->setUser($user);
        $years = array();
        $levels = array();
        foreach ($user->getTrainings() as $value){
                if(!in_array($value->getYearGraduation(),$years)){
                    array_push($years,$value->getYearGraduation());
                }
            if(!in_array($value->getLevel(),$levels)){
                array_push($levels,$value->getLevel());
            }
        }
        /** @var TrainingType $form */
        $form = $this->createForm('AppBundle\Form\TrainingType', $training, array(
            'years' => $years,
            'levels' => $levels,
            'lastTraining' => $lastTraining
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($training);
            $em->flush($training);
            $this->addFlash('success',
                "La formation a été créée"
            );
            return $this->redirectToRoute('training_new', array('id' => $training->getId()));
        }
        dump(array_diff(array_values(TrainingType::MANDATORY_LEVELS), $levels));
        return $this->render('training/new.html.twig', array(
            'training' => $training,
            'form' => $form->createView(),
            'trainings' => $trainings,
            'remainingLevels' => array_diff(array_values(TrainingType::MANDATORY_LEVELS), $levels),
        ));
    }

    /**
     * Finds and displays a training entity.
     *
     */
    public function showAction(Training $training)
    {
        $deleteForm = $this->createDeleteForm($training);

        return $this->render('training/show.html.twig', array(
            'training' => $training,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing training entity.
     *
     */
    public function editAction(Request $request, Training $training)
    {
        $deleteForm = $this->createDeleteForm($training);
        $editForm = $this->createForm('AppBundle\Form\TrainingType', $training);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('training_edit', array('id' => $training->getId()));
        }

        return $this->render('training/edit.html.twig', array(
            'training' => $training,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a training entity.
     *
     */
    public function deleteAction(Request $request, Training $training)
    {
        $form = $this->createDeleteForm($training);
        //$form->handleRequest($request);

        //if ($form->isSubmitted() && $form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($training);
        $em->flush();

        $this->addFlash('success',
            "La formation a été supprimée"
        );
        //}

        return $this->redirectToRoute('training_new');
    }

    /**
     * Creates a form to delete a training entity.
     *
     * @param Training $training The training entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Training $training)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('training_delete', array('id' => $training->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
