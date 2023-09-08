<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Document;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Document controller.
 *
 */
class DocumentController extends Controller
{
    /**
     * Lists all document entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $documents = $em->getRepository('AppBundle:Document')->findAll();

        return $this->render('document/index.html.twig', array(
            'documents' => $documents,
        ));
    }

    /**
     * Creates a new document entity.
     *
     */
    public function newAction(Request $request)
    {
        $document = new Document();
        $form = $this->createForm('AppBundle\Form\DocumentType', $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($document);
            $em->flush($document);

            return $this->redirectToRoute('document_show', array('id' => $document->getId()));
        }

        return $this->render('document/new.html.twig', array(
            'document' => $document,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a document entity.
     *
     */
    public function showAction(Document $document)
    {
        $deleteForm = $this->createDeleteForm($document);

        return $this->render('document/show.html.twig', array(
            'document' => $document,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing document entity.
     *
     */
    public function editAction(Request $request, Document $document)
    {
        $deleteForm = $this->createDeleteForm($document);
        $editForm = $this->createForm('AppBundle\Form\DocumentType', $document);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('document_edit', array('id' => $document->getId()));
        }

        return $this->render('document/edit.html.twig', array(
            'document' => $document,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a document entity.
     *
     */
    public function deleteAction(Request $request, Document $document)
    {
        $form = $this->createDeleteForm($document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($document);
            $em->flush();
        }

        return $this->redirectToRoute('document_index');
    }

    /**
     * Deletes a document entity.
     *
     */
    public function documentApplicationDeleteAction($documentId,$applicationId)
    {

        $em = $this->getDoctrine()->getManager();
        $document = $em->getRepository('AppBundle:Document')->find($documentId);
        if($document){
            $application = $document->getApplication();
            //var_dump(count($application->getDocuments()));die;
            $fileToDeleted = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/' . $document->getUser()->getId() . '/' . $document->getApplication()->getId() . '/' . $document->getFileName();
            if (file_exists($fileToDeleted)) {
                unlink($fileToDeleted);
            }
            $em->remove($document);
            $em->flush();
            $this->addFlash('success',
                "Le Document a été supprimé"
            );
            $payment_receipt = false;
            foreach ($application->getDocuments() as $document) {
                if($document->getDocumentType()->getCode() == "payment_receipt"){
                    $payment_receipt = true;
                }
            }
            $count_doc_app = count($application->getDocuments());
            $count_doc_course = count($application->getCourse()->getDocumentTypes());
            if($payment_receipt){
                $count_doc_app = $count_doc_app - 1;
            }
            if($count_doc_app >= $count_doc_course){
                $application->setDocumentsUploaded(1);
                $em->persist($application);
                $em->flush($application);
            }else{
                $application->setDocumentsUploaded(0);
                $em->persist($application);
                $em->flush($application);
            }

        }

        return $this->redirectToRoute('save_files',array("applicationId"=>$applicationId));
    }

    /**
     * Creates a form to delete a document entity.
     *
     * @param Document $document The document entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Document $document)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('document_delete', array('id' => $document->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function changeStatusAction($documentId,$statusId)
    {
        $em = $this->getDoctrine()->getManager();
        $document = $em->getRepository('AppBundle:Document')->find($documentId);
        $document->setStatus($statusId);
        $em->persist($document);
        $em->flush($document);
        if($statusId == 4){
            $this->addFlash(
                'notice',
                'Le document est validé'
            );
            /*$message = \Swift_Message::newInstance()
                ->setSubject('Votre document a été validé')
                ->setFrom(array("ouchayan.h@gmail.com" => "Université EuroMed de Fès"))
                ->setTo($document->getApplication()->getUser()->getEmail())
                ->setCharset('UTF-8')
                ->setContentType('text/html')
                ->setBody($this->container->get('templating')->render('document/validateMail.html.twig', array('document' => $document)));
            $this->container->get('mailer')->send($message);*/
        }else if($statusId == -1){
            $this->addFlash(
                'notice',
                'Le document est rejeté'
            );
            $message = \Swift_Message::newInstance()
                ->setSubject('Documents non valide')
                ->setFrom(array("m.alaoui@linkommunity.com" => "ENAM"))
                ->setTo($document->getApplication()->getUser()->getEmail())
                ->setCharset('UTF-8')
                ->setContentType('text/html')
                ->setBody($this->container->get('templating')->render('document/refuseMail.html.twig', array('document' => $document)));
            $this->container->get('mailer')->send($message);

        } else{
            $this->addFlash(
                'notice',
                'Le statut du document est restauré'
            );
        }
        return $this->redirectToRoute('candidate',array('id' => $document->getApplication()->getUser()->getId(),"openDocumentApp" => $document->getApplication()->getId()));
    }
}
