<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Application controller.
 *
 */
class ApplicationController extends Controller
{
    /**
     * Lists all application entities.
     *
     */
    public function indexAction(Request $request)
    {
        $token = $this->container->get('security.context')->getToken();
        $user = $token->getUser();
        $params = array();
        if($user->getRole()== "responsable"){
            $params["schoolId"] = $user->getSchool()->getId();
        }else{
            $params["schoolId"] = $request->query->get('school');
        }
        $params["schoolFieldId"] = $request->query->get('schoolField');
        $params["diplomaTypeId"] = $request->query->get('diplomaType');
        $params["trainingTypeId"] = $request->query->get('trainingType');
        $params["passerelleId"] = $request->query->get('passerelle');
        $params["status"] = $request->query->get('status');
        $params["search"] = $request->query->get('search');

        $em = $this->getDoctrine()->getManager();

        $schools = $em->getRepository('AppBundle:School')->findAll();
        if($params["schoolId"] != "" && $params["schoolId"] != null){
            if($params["diplomaTypeId"] != "" && $params["diplomaTypeId"] != null){
                $schoolFields = $em->getRepository('AppBundle:schoolField')->getFieldsBySchoolIdAndDiplomaTypeId($params["schoolId"],$params["diplomaTypeId"]);
            }else{
                $schoolFields = $em->getRepository('AppBundle:schoolField')->getFieldsBySchoolId($params["schoolId"]);
            }
            $diplomaTypes = $em->getRepository('AppBundle:DiplomaType')->getDiplomaTypeBySchoolId($params["schoolId"]);
        }else{
            $schoolFields = $em->getRepository('AppBundle:schoolField')->findAll();
            $diplomaTypes = $em->getRepository('AppBundle:DiplomaType')->findAll();
        }
        $trainingTypes = $em->getRepository('AppBundle:TrainingType')->findAll();
        $diploma = $em->getRepository('AppBundle:Diploma')->getDiplomaByDiplomaTypeIdAndBySchoolIdAndTrainingTypeId($params["diplomaTypeId"],$params["schoolId"],$params["schoolFieldId"],$params["trainingTypeId"]);
        $courses = array();
        $courses = $em->getRepository('AppBundle:Course')->findByCriteria($params);
        $this->get('session')->set('params', $params);
        $query = $em->getRepository('AppBundle:User')->findAllPublished($params);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('application/index.html.twig', array(
            'pagination' => $pagination,
            'schools' => $schools,
            'schoolFields' => $schoolFields,
            'diplomaTypes' => $diplomaTypes,
            'trainingTypes' => $trainingTypes,
            'diploma' => $diploma,
            'courses' => $courses,
            'params' => $params,
            'user' => $user,
        ));
    }

    /**
     * Creates a new application entity.
     *
     */
    public function newAction(Request $request)
    {
        $application = new Application();
        $form = $this->createForm('AppBundle\Form\ApplicationType', $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($application);
            $em->flush($application);

            return $this->redirectToRoute('application_show', array('id' => $application->getId()));
        }

        return $this->render('application/new.html.twig', array(
            'application' => $application,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a application entity.
     *
     */
    public function showAction(Application $application)
    {
        $deleteForm = $this->createDeleteForm($application);

        return $this->render('application/show.html.twig', array(
            'application' => $application,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing application entity.
     *
     */
    public function editAction(Request $request, Application $application)
    {
        $deleteForm = $this->createDeleteForm($application);
        $editForm = $this->createForm('AppBundle\Form\ApplicationType', $application);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('application_edit', array('id' => $application->getId()));
        }

        return $this->render('application/edit.html.twig', array(
            'application' => $application,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a application entity.
     *
     */
    public function deleteAction(Request $request, Application $application)
    {
        $form = $this->createDeleteForm($application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($application);
            $em->flush();
        }

        return $this->redirectToRoute('application_index');
    }

    /**
     * Creates a form to delete a application entity.
     *
     * @param Application $application The application entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Application $application)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('application_delete', array('id' => $application->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    public function candidateAction($id,$openDocumentApp = null,Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);

        $editForm = $this->createForm('AppBundle\Form\CandidateAdminType', $user);
        $editForm->handleRequest($request);
        if ($request->isMethod('post')) {
          if ($editForm->isSubmitted() && $editForm->isValid()) {
              $this->getDoctrine()->getManager()->flush();
              $this->addFlash(
                  'notice',
                  'La modification a bien été éfectuée'
              );
          }
        }

        return $this->render('application/candidate.html.twig', array(
            'user' => $user,
            'openDocumentApp' => $openDocumentApp,
            'edit_form' => $editForm->createView(),
        ));
    }

    public function getDocumentsByApplicationIdAction($applicationId)
    {
        $em = $this->getDoctrine()->getManager();
        $application = $em->getRepository('AppBundle:Application')->find($applicationId);
        $filesUploaded = array();
        $documentTypeRP = $em->getRepository('AppBundle:DocumentType')->findByCode("payment_receipt");
        $filesUploaded["REÇU DE PAIEMENT"] = $em->getRepository('AppBundle:Document')->findBy(array("application" => $application,"documentType" => $documentTypeRP));
        foreach ($application->getCourse()->getDocumentTypes() as $documentType) {
            $documents = $em->getRepository('AppBundle:Document')->findBy(array("application" => $application,"documentType" => $documentType));
            $filesUploaded[$documentType->getName()] = $documents;
        }
        $template = $this->renderView("application/documents.html.twig",
            array(
                "application" => $application,
                "filesUploaded" => $filesUploaded
            )
        );
        return new Response($template);
    }

    public function changeStatusAction($applicationId,$statusId)
    {
        $em = $this->getDoctrine()->getManager();
        $application = $em->getRepository('AppBundle:Application')->find($applicationId);
        $application->setStatus($statusId);
        $em->persist($application);
        $em->flush($application);
        if($statusId == 4){
            $this->addFlash(
                'notice',
                'Le candidat est convoqué'
            );
            $message = \Swift_Message::newInstance()
                ->setSubject('Mail de convocation  ')
                ->setFrom(array("m.alaoui@linkommunity.com" => "ENAM"))
                ->setTo($application->getUser()->getEmail())
                ->setCharset('UTF-8')
                ->setContentType('text/html')
                ->setBody($this->container->get('templating')->render('application/validateMail.html.twig', array('application' => $application)));
            $this->container->get('mailer')->send($message);
        }else if($statusId == -1){
            $this->addFlash(
                'notice',
                'La candidature a été rejeté'
            );
            $message = \Swift_Message::newInstance()
                ->setSubject('Mail de refus')
                ->setFrom(array("m.alaoui@linkommunity.com" => "ENAM"))
                ->setTo($application->getUser()->getEmail())
                ->setCharset('UTF-8')
                ->setContentType('text/html')
                ->setBody($this->container->get('templating')->render('application/refuseMail.html.twig', array('application' => $application)));
            $this->container->get('mailer')->send($message);
        } else{
            $this->addFlash(
                'notice',
                'La candidature a été restauré'
            );
        }
        return $this->redirectToRoute('candidate',array('id' => $application->getUser()->getId()));
    }

    /**
     * Creates a new application entity.
     *
     */
    public function sendMailAction(Request $request)
    {
        $params = $request->request->all();
        //var_dump($params);
        //die;
        $ids = $params["ids"];
        $mailBody = $params["mailBody"];
        $mailSubject = $params["mailSubject"];
        $ids = $array = explode(',', $ids);
        $em = $this->getDoctrine()->getManager();
        foreach($ids  as $id){
            $user = $em->getRepository('AppBundle:User')->find($id);
            if($user){
                $message = \Swift_Message::newInstance()
                    ->setSubject($mailSubject)
                    ->setFrom(array("m.alaoui@linkommunity.com" => "ENAM"))
                    ->setTo($user->getEmail())
                    ->setCharset('UTF-8')
                    ->setContentType('text/html')
                    ->setBody($this->container->get('templating')->render('application/customMail.html.twig', array('user' => $user,"mailBody" => $mailBody)));
                $this->container->get('mailer')->send($message);
            }
        }
        $this->addFlash(
            'notice',
            'Le mail a été envoyé'
        );
        return $this->redirectToRoute('application_index');
    }
}
