<?php

namespace AppBundle\Controller;

use AppBundle\Entity\DocumentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Documenttype controller.
 *
 */
class DocumentTypeController extends Controller
{
    /**
     * Lists all documentType entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $documentTypes = $em->getRepository('AppBundle:DocumentType')->findAll();

        return $this->render('documenttype/index.html.twig', array(
            'documentTypes' => $documentTypes,
        ));
    }

    /**
     * Creates a new documentType entity.
     *
     */
    public function newAction(Request $request)
    {
        $documentType = new Documenttype();
        $form = $this->createForm('AppBundle\Form\DocumentTypeType', $documentType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($documentType);
            $em->flush($documentType);
            $this->addFlash(
                'notice',
                'Le type de document a été bien enregistré'
            );
            return $this->redirectToRoute('documenttype_edit', array('id' => $documentType->getId()));
        }

        return $this->render('documenttype/new.html.twig', array(
            'documentType' => $documentType,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a documentType entity.
     *
     */
    public function showAction(DocumentType $documentType)
    {
        $deleteForm = $this->createDeleteForm($documentType);

        return $this->render('documenttype/show.html.twig', array(
            'documentType' => $documentType,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing documentType entity.
     *
     */
    public function editAction(Request $request, DocumentType $documentType)
    {
        $deleteForm = $this->createDeleteForm($documentType);
        $editForm = $this->createForm('AppBundle\Form\DocumentTypeType', $documentType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'notice',
                'Le type de document a été bien modifié'
            );
            return $this->redirectToRoute('documenttype_edit', array('id' => $documentType->getId()));
        }

        return $this->render('documenttype/edit.html.twig', array(
            'documentType' => $documentType,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a documentType entity.
     *
     */
    public function deleteAction(Request $request, DocumentType $documentType)
    {
        $form = $this->createDeleteForm($documentType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($documentType);
            $em->flush();
            $this->addFlash(
                'notice',
                'Le type de document a été bien supprimé'
            );
        }


        return $this->redirectToRoute('documenttype_index');
    }

    /**
     * Creates a form to delete a documentType entity.
     *
     * @param DocumentType $documentType The documentType entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DocumentType $documentType)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('documenttype_delete', array('id' => $documentType->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
