<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Feature;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Feature controller.
 *
 */
class FeatureController extends Controller
{
    /**
     * Lists all feature entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $features = $em->getRepository('AppBundle:Feature')->findAll();

        return $this->render('feature/index.html.twig', array(
            'features' => $features,
        ));
    }

    /**
     * Creates a new feature entity.
     *
     */
    public function newAction(Request $request)
    {
        $feature = new Feature();
        $form = $this->createForm('AppBundle\Form\FeatureType', $feature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($feature);
            $em->flush($feature);
            $this->addFlash(
                'notice',
                'La fonctionnalité a été bien enregistré'
            );

            return $this->redirectToRoute('feature_edit', array('id' => $feature->getId()));
        }

        return $this->render('feature/new.html.twig', array(
            'feature' => $feature,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a feature entity.
     *
     */
    public function showAction(Feature $feature)
    {
        $deleteForm = $this->createDeleteForm($feature);

        return $this->render('feature/show.html.twig', array(
            'feature' => $feature,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing feature entity.
     *
     */
    public function editAction(Request $request, Feature $feature)
    {
        $deleteForm = $this->createDeleteForm($feature);
        $editForm = $this->createForm('AppBundle\Form\FeatureType', $feature);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'notice',
                'La fonctionnalité a été bien modifié'
            );

            return $this->redirectToRoute('feature_edit', array('id' => $feature->getId()));
        }

        return $this->render('feature/edit.html.twig', array(
            'feature' => $feature,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a feature entity.
     *
     */
    public function deleteAction(Request $request, Feature $feature)
    {
        $form = $this->createDeleteForm($feature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($feature);
            $em->flush();
            $this->addFlash(
                'notice',
                'La fonctionnalité a été bien supprimé'
            );
        }

        return $this->redirectToRoute('feature_index');
    }

    /**
     * Creates a form to delete a feature entity.
     *
     * @param Feature $feature The feature entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Feature $feature)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('feature_delete', array('id' => $feature->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
