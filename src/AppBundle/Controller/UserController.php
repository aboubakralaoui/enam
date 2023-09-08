<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Document;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Event\GetResponseNullableUserEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


/**
 * User controller.
 *
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     */
    public function indexAction()
    {
        $token = $this->container->get('security.context')->getToken();
        //var_dump($token->getUser()->getId());die;
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Lists all user entities.
     *
     */
    public function indexAdminAction()
    {
        $token = $this->container->get('security.context')->getToken();
        //var_dump($token->getUser()->getId());die;
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findBy(array('role' => array("responsable","administrator")));

        return $this->render('user/admin/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Creates a new user entity.
     *
     */
    public function newAction(Request $request)
    {
        $user = $this->createUser();
        $form = $this->createForm('AppBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush($user);

            return $this->redirectToRoute('user_show', array('id' => $user->getId()));
        }

        return $this->render('user/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new user entity.
     *
     */
    public function newAdminAction(Request $request)
    {
        $user = $this->createUser();
        $form = $this->createForm('AppBundle\Form\UserAdminType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush($user);

            return $this->redirectToRoute('user_edit_admin', array('id' => $user->getId()));
        }

        return $this->render('user/admin/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new user entity.
     *
     */
    public function registerAction(Request $request)
    {
        $user = $this->createUser();
        $form = $this->createForm('AppBundle\Form\UserType', $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $tokenGenerator = $this->container->get('fos_user.util.token_generator');
            $token = $tokenGenerator->generateToken();
            $diplomaType = $em->getRepository('AppBundle:DiplomaType')->find(9);
            $user->addDiplomaType($diplomaType);
            $user->setConfirmationToken($token);
            $em->persist($user);
            $em->flush($user);

            $message = \Swift_Message::newInstance()
                ->setSubject('Votre candidature à l’ENAM – Validation de votre compte')
                ->setFrom(array("m.alaoui@linkommunity.com" => "ENAM"))
                ->setTo($user->getEmail())
                ->setCharset('UTF-8')
                ->setContentType('text/html')
                ->setBody($this->container->get('templating')->render('user/confirmationAccount.html.twig', array('token' => $token,'user' => $user)));
            $this->container->get('mailer')->send($message);

            return $this->redirectToRoute('showMessageRegister');
        }

        return $this->render('user/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     */
    public function showMessageRegisterAction()
    {
        return $this->render('user/showMessageRegister.html.twig', array(
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('user/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     */
    public function confirmeAccountAction($token)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneByConfirmationToken($token);
        if ($user) {
            return $this->render('user/initPassword.html.twig', array(
                'token' => $token
            ));
        } else {
            die("ni");
        }

    }

    /**
     * Finds and displays a user entity.
     *
     */
    public function initPasswordAction(Request $request)
    {
        $params = $request->request->all();
        $token = $params['token'];
        $password = $params['password'];
        $confirmation = $params['confirmation'];
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneByConfirmationToken($token);
        //var_dump($params);die;
        if ($password == $confirmation) {
            if ($user) {
                $user->setEnabled(true);
                $user->setConfirmationToken(null);
                $user->setPlainPassword($password);
                $this->updateUser($user);
                $message = \Swift_Message::newInstance()
                    ->setSubject('Votre candidature à l’ENAM – Validation de votre compte')
                    ->setFrom(array("m.alaoui@linkommunity.com" => "ENAM"))
                    ->setTo($user->getEmail())
                    ->setCharset('UTF-8')
                    ->setContentType('text/html')
                    ->setBody($this->container->get('templating')->render('user/confirmationMail.html.twig', array('user' => $user)));
                $this->container->get('mailer')->send($message);
                $response = new RedirectResponse($this->getRedirectionUrl($user));
                $this->authenticateUser($user, $response);
                return $response;
                /*return $this->redirect(
                    $this->generateUrl(
                        "showMessageInitPassword"
                    )
                );*/

            } else {
                $this->addFlash(
                    'notice',
                    'token error'
                );
                return $this->render('user/initPassword.html.twig', array(
                    'token' => $token
                ));
            }
        } else {
            $this->addFlash(
                'notice',
                'Les deux mots de passe ne sont pas identiques'
            );
            return $this->render('user/initPassword.html.twig', array(
                'token' => $token
            ));
        }

    }

    /**
     * Authenticate a user with Symfony Security
     *
     * @param \FOS\UserBundle\Model\UserInterface        $user
     * @param \Symfony\Component\HttpFoundation\Response $response
     */
    protected function authenticateUser(UserInterface $user, Response $response)
    {
        try {
            $this->container->get('fos_user.security.login_manager')->loginUser(
                $this->container->getParameter('fos_user.firewall_name'),
                $user,
                $response);
        } catch (AccountStatusException $ex) {
            // We simply do not authenticate users which do not pass the user
            // checker (not enabled, expired, etc.).
        }
    }

    /**
     * Generate the redirection url when the resetting is completed.
     *
     * @param \FOS\UserBundle\Model\UserInterface $user
     *
     * @return string
     */
    protected function getRedirectionUrl(UserInterface $user)
    {
        return $this->container->get('router')->generate('profile');
    }

    /**
     * Finds and displays a user entity.
     *
     */
    public function showMessageInitPasswordAction()
    {
        return $this->render('user/showMessageInitPassword.html.twig', array(
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('AppBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
        }

        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     */
    public function editAdminAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('AppBundle\Form\UserAdminEditType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_edit_admin', array('id' => $user->getId()));
        }

        return $this->render('user/admin/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * @return UserInterface
     */
    protected function createUser()
    {
        return $this->container->get('fos_user.user_manager')->createUser();
    }

    /**
     * @return UserInterface
     */
    protected function updateUser(User $user)
    {
        return $this->container->get('fos_user.user_manager')->updateUser($user);
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     */
    public function profileAction(Request $request)
    {
        $token = $this->container->get('security.context')->getToken();
        $user = $token->getUser();
        //$deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('AppBundle\Form\UserType', $user);
        $editForm->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        $diplomaTypes = $em->getRepository('AppBundle:DiplomaType')->findBy([], ['order' => 'ASC']);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success',
                "Votre profil a été modifié"
            );

            return $this->redirectToRoute('training_new');
        }

        return $this->render('user/profile.html.twig', array(
            'user' => $user,
            'diplomaTypes' => $diplomaTypes,
            'edit_form' => $editForm->createView()
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     */
    public function applicationAction(Request $request)
    {
        $token = $this->container->get('security.context')->getToken();
        $user = $token->getUser();
        if(count($user->getTrainings()) < 1 ){
            $this->addFlash('success',
                "La saisie d'un dipôme est obligatoire!."
            );
            return $this->redirectToRoute('training_new');
        }
        $em = $this->getDoctrine()->getManager();
        $diplomaTypeArray = array();
        $diplomaTypesUser = $em->getRepository('AppBundle:DiplomaType')->findAll();
        foreach ($diplomaTypesUser as $key => $diplomaType) {
            $diplomaTypeArray[$key] = array("id" => $diplomaType->getId(), "name" => $diplomaType->getName());
            $schools = $em->getRepository('AppBundle:School')->getSchoolByDiplomaType($diplomaType->getId());
            foreach ($schools as $k => $school) {
                   $diplomaTypeArray[$key]['schools'][$k] = array("id" => $school->getId(), "name" => $school->getName());
                   $courses = $em->getRepository('AppBundle:Course')->getCourseByDiplomaTypeAndShool($diplomaType, $school);
                   $coursesArray = array();
                   foreach ($courses as $c => $course) {
                           $trainingTypes = $em->getRepository('AppBundle:TrainingType')->findAll();
                           $trainingTypeArray = array();
                           foreach ($trainingTypes as $tt => $trainingType) {
                              $diplomasArray = array();
                              foreach ($course->getDiplomas() as $tt => $diploma) {
                                  if($diploma->getTrainingType() == $trainingType && $diploma->getDiplomaType() == $diplomaType && $diploma->getSchool() == $school  ) {
                                      array_push($diplomasArray, array( "id" => $diploma->getId() , "name" => $diploma->getSchoolField()->getName()));
                                  }
                              }
                              $postulated = $em->getRepository('AppBundle:Application')->findOneBy([
                                  'user' => $user,
                                  'course' => $course,
                                  'trainingType' => $trainingType,
                                  'diplomaType' => $diplomaType,
                                  'school' => $school
                               ]);
                              array_push($trainingTypeArray, array( "id" => $trainingType->getId(), "postulated" => $postulated ? true : false , "name" => $trainingType->getName(), "diplomas" => $diplomasArray));
                           }
                           array_push($coursesArray, array(
                             "id" => $course->getId() ,
                             "name" => $course->getName(),
                             "applicationDeadline" => $course->getApplicationDeadline(),
                             "paymentReceiptDeadline" => $course->getPaymentReceiptDeadline(),
                             "filesDeadline" => $course->getFilesDeadline(),
                             "conditions" => $course->getConditions(),
                             "trainingTypes" => $trainingTypeArray
                           ));
                   }
                   $diplomaTypeArray[$key]['schools'][$k]['courses'] = $coursesArray;
            }
        }

        //dump($diplomaTypeArray);die;

        return $this->render('user/application.html.twig', array(
            'user' => $user,
            'diplomaTypeArray' => $diplomaTypeArray
        ));
    }

    public function saveFilesAction($applicationId)
    {
        $acceptedExtensions = array("png", "jpg", "jpeg","pdf");
        $filesErrors = array();
        $request = $this->get("request");
        $token = $this->container->get('security.context')->getToken();
        $user = $token->getUser();
        $em = $this->getDoctrine()->getManager();
        $application = $em->getRepository('AppBundle:Application')->find($applicationId);

        if(!$user->getApplications()->contains($application)){
            $this->addFlash('danger',
                "Vous n'avez pas les droits suffisants pour accéder à cette page"
            );
            return $this->redirectToRoute('application');
        }

        $countUploadedDocument = 0;
        if ($request->getMethod() == 'POST') {
            $uploadPath = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/' . $user->getId() . '/' . $application->getId();
            $files = $request->files->all();
            foreach ($files as $key => $file) {
                if ($file != null) {
                    if(is_array($file)){
                        foreach ($file as $index => $f) {
                            if ($f != null) {
                                $today = date("d-m-Y");
                                $rand = rand(1, 10000);
                                $uploadedAvatarFile = $f;
                                $extension = $uploadedAvatarFile->guessExtension();
                                if (in_array($extension, $acceptedExtensions)) {
                                    if ($uploadedAvatarFile->getClientSize() < 2000000) {
                                        $new_file_name = $key . '_' . $today . '_' . time() . '_' . uniqid() . '_' . $rand . '.' . $extension;
                                        $documentInstance = $em->getRepository('AppBundle:Document')->findOneBy(array('application' => $application, 'user' => $user, 'documentType' => $em->getRepository('AppBundle:DocumentType')->findOneByCode($key)));
                                        if ($documentInstance != null) {
                                            $fileToDeleted = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/' . $user->getId() . '/' . $application->getId() . '/' . $documentInstance->getFileName();
                                            if (file_exists($fileToDeleted)) {
                                                //unlink($fileToDeleted);
                                            }
                                            //$em->remove($documentInstance);
                                            //$em->flush($documentInstance);
                                        }
                                        $avatarFile = $uploadedAvatarFile->move($uploadPath, $new_file_name);
                                        $document = new Document();
                                        $document->setFileName($new_file_name);
                                        $document->setExtension($extension);
                                        $document->setUser($user);
                                        $document->setApplication($application);
                                        $document->setDocumentType($em->getRepository('AppBundle:DocumentType')->findOneByCode($key));
                                        $em->persist($document);
                                        $em->flush($document);
                                        $countUploadedDocument++;
                                        //dump($document->getId());
                                        unset($uploadedAvatarFile);
                                        $this->addFlash('success',
                                            "Le document ".$f->getClientOriginalName()." a été enregistré"
                                        );
                                    } else {
                                        $this->addFlash('danger',
                                            "La taille du document ".$f->getClientOriginalName() ." est trop grande"
                                        );
                                        $filesErrors[$key][] = "size non valide";
                                    }
                                } else {
                                    $this->addFlash('danger',
                                        "L'extension du document ".$f->getClientOriginalName()." n'est pas accéptée"
                                    );
                                    $filesErrors[$key][] = "L'extension du document ".$f->getClientOriginalName()." n'est pas accéptée";
                                }
                            }
                        }
                    }else{
                        $today = date("d-m-Y");
                        $rand = rand(1, 10000);
                        $uploadedAvatarFile = $file;
                        //dump($file);
                        $extension = $uploadedAvatarFile->guessExtension();
                        if (in_array($extension, $acceptedExtensions)) {
                            if ($file->getClientSize() < 2000000) {
                                $new_file_name = $key . '_' . $today . '_' . time() . '_' . uniqid() . '_' . $rand . '.' . $extension;
                                $documentInstance = $em->getRepository('AppBundle:Document')->findOneBy(array('application' => $application, 'user' => $user, 'documentType' => $em->getRepository('AppBundle:DocumentType')->findOneByCode($key)));
                                if ($documentInstance != null) {
                                    $fileToDeleted = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/' . $user->getId() . '/' . $application->getId() . '/' . $documentInstance->getFileName();
                                    if (file_exists($fileToDeleted)) {
                                        unlink($fileToDeleted);
                                    }
                                    $em->remove($documentInstance);
                                    $em->flush($documentInstance);
                                }
                                $avatarFile = $uploadedAvatarFile->move($uploadPath, $new_file_name);
                                $document = new Document();
                                $document->setFileName($new_file_name);
                                $document->setExtension($extension);
                                $document->setUser($user);
                                $document->setApplication($application);
                                $document->setDocumentType($em->getRepository('AppBundle:DocumentType')->findOneByCode($key));
                                $em->persist($document);
                                $em->flush($document);
                                $countUploadedDocument++;
                                //dump($document->getId());
                                unset($uploadedAvatarFile);
                                $this->addFlash('success',
                                    "Le document ".$file->getClientOriginalName()." a été enregistré"
                                );
                            } else {
                                $this->addFlash('danger',
                                    "La taille du document ".$file->getClientOriginalName() ." est trop grande"
                                );
                                $filesErrors[$key][] = " size non valide";
                            }
                        } else {
                            $this->addFlash('danger',
                                "L'extension du document ".$file->getClientOriginalName()." n'est pas accéptée"
                            );
                            $filesErrors[$key][] = " Extension non valide";
                        }
                    }
                    //try {


                    //} catch (\Exception $e) {
                    //}
                }
            }
            if($countUploadedDocument == 0 && count($filesErrors) == 0){
                $this->addFlash('success',
                    "Aucun document n'a été uploadé"
                );
            }
            if(count($filesErrors) == 0 && $countUploadedDocument != 0){
                //return $this->redirectToRoute('payment_receipt',array('applicationId'=> $application->getId()));
            }
            $allFilesAreUploaded = true;
            foreach ($application->getCourse()->getDocumentTypes() as $documentType) {
                $documents = $em->getRepository('AppBundle:Document')->findBy(array("application" => $application,"documentType" => $documentType));
                if(count($documents) == 0){
                    $allFilesAreUploaded = false;
                }
            }
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
            if($allFilesAreUploaded && $payment_receipt){
                if(!$application->getMailConfirmation()){
                    $message = \Swift_Message::newInstance()
                        ->setSubject('Confirmation de réception de dossier  ')
                        ->setFrom(array("m.alaoui@linkommunity.com" => "ENAM"))
                        ->setTo($user->getEmail())
                        ->setCharset('UTF-8')
                        ->setContentType('text/html')
                        ->setBody($this->container->get('templating')->render('user/applicationMail.html.twig', array('application' => $application)));
                    $this->container->get('mailer')->send($message);
                    $application->setMailConfirmation(1);
                    $em->persist($application);
                    $em->flush($application);
                }
            }
            if($allFilesAreUploaded){
                $application->setDocumentsUploaded(1);
                $em->persist($application);
                $em->flush($application);
            }else{
                $application->setDocumentsUploaded(0);
                $em->persist($application);
                $em->flush($application);
            }
            if($allFilesAreUploaded && count($filesErrors) == 0 && $countUploadedDocument != 0){
                return $this->redirectToRoute('online_payment');
            }
            /*if($allFilesAreUploaded && count($filesErrors) == 0 && $countUploadedDocument != 0 && !$payment_receipt){
                return $this->redirectToRoute('application');
            }*/
        }

        $filesUploaded = array();
        foreach ($application->getDocuments() as $document) {
            $filesUploaded[$document->getDocumentType()->getCode()][] = array("id" => $document->getId(),"fileName" => $document->getFileName(), "extension" => $document->getExtension(), "status" => $document->getStatus());
        }
        return $this->render('user/saveFiles.html.twig', array(
            'user' => $user,
            'application' => $application,
            'filesUploaded' => $filesUploaded,
            'filesErrors' => $filesErrors
        ));
    }

    public function paymentReceiptAction($applicationId)
    {
        $acceptedExtensions = array("png", "jpg", "jpeg", "pdf");
        $filesErrors = array();
        $request = $this->get("request");
        $token = $this->container->get('security.context')->getToken();
        $user = $token->getUser();
        $em = $this->getDoctrine()->getManager();
        $application = $em->getRepository('AppBundle:Application')->find($applicationId);

        if(!$user->getApplications()->contains($application)){
            $this->addFlash('danger',
                "Vous n'avez pas les droits suffisants pour accéder à cette page"
            );
            return $this->redirectToRoute('application');
        }

        if ($request->getMethod() == 'POST') {
            $uploadPath = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/' . $user->getId() . '/' . $application->getId();
            $files = $request->files->all();
            foreach ($files as $key => $file) {
                if ($file != null) {
                    //try {
                    $today = date("d-m-Y");
                    $rand = rand(1, 10000);
                    $uploadedAvatarFile = $request->files->get($key);
                    $extension = $uploadedAvatarFile->guessExtension();
                    if (in_array($extension, $acceptedExtensions)) {
                        if ($file->getClientSize() < 2000000) {
                            $new_file_name = $key . '_' . $today . '_' . time() . '_' . uniqid() . '_' . $rand . '.' . $extension;
                            $documentInstance = $em->getRepository('AppBundle:Document')->findOneBy(array('application' => $application, 'user' => $user, 'documentType' => $em->getRepository('AppBundle:DocumentType')->findOneByCode($key)));
                            if ($documentInstance != null) {
                                $fileToDeleted = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/' . $user->getId() . '/' . $application->getId() . '/' . $documentInstance->getFileName();
                                if (file_exists($fileToDeleted)) {
                                    unlink($fileToDeleted);
                                }
                                $em->remove($documentInstance);
                                $em->flush($documentInstance);
                            }
                            $avatarFile = $uploadedAvatarFile->move($uploadPath, $new_file_name);
                            $document = new Document();
                            $document->setFileName($new_file_name);
                            $document->setExtension($extension);
                            $document->setUser($user);
                            $document->setApplication($application);
                            $document->setDocumentType($em->getRepository('AppBundle:DocumentType')->findOneByCode($key));
                            $em->persist($document);
                            $em->flush($document);
                            //dump($document->getId());
                            unset($uploadedAvatarFile);
                            $this->addFlash('success',
                                "Le document ".$file->getClientOriginalName()." a été enregistré"
                            );
                        } else {
                            $this->addFlash('danger',
                                "La taille du document ".$file->getClientOriginalName() ." est trop grande"
                            );
                            $filesErrors[$key][] = " size non valide";
                        }
                    } else {
                        $this->addFlash('danger',
                            "L'extension du document ".$file->getClientOriginalName()." n'est pas accéptée"
                        );
                        $filesErrors[$key][] = " Extension non valide";
                    }

                    //} catch (\Exception $e) {
                    //}
                }
            }

            $allFilesAreUploaded = true;
            foreach ($application->getCourse()->getDocumentTypes() as $documentType) {
                $documents = $em->getRepository('AppBundle:Document')->findBy(array("application" => $application,"documentType" => $documentType));
                if(count($documents) == 0){
                    $allFilesAreUploaded = false;
                }
            }
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
            if($allFilesAreUploaded && $payment_receipt){
                if(!$application->getMailConfirmation()){
                    $message = \Swift_Message::newInstance()
                        ->setSubject('Confirmation de réception de dossier  ')
                        ->setFrom(array("m.alaoui@linkommunity.com" => "ENAM"))
                        ->setTo($user->getEmail())
                        ->setCharset('UTF-8')
                        ->setContentType('text/html')
                        ->setBody($this->container->get('templating')->render('user/applicationMail.html.twig', array('application' => $application)));
                    $this->container->get('mailer')->send($message);
                    $application->setMailConfirmation(1);
                    $em->persist($application);
                    $em->flush($application);
                }
            }

            if($payment_receipt){
                $application->setPaymentReceiptUploaded(1);
                $em->persist($application);
                $em->flush($application);
            }
            return $this->redirectToRoute('application');
        }

        $filesUploaded = array();
        foreach ($application->getDocuments() as $document) {
            $filesUploaded[$document->getDocumentType()->getCode()] = array("fileName" => $document->getFileName(), "extension" => $document->getExtension(), "status" => $document->getStatus());
        }
        return $this->render('user/paymentReceipt.html.twig', array(
            'user' => $user,
            'application' => $application,
            'filesUploaded' => $filesUploaded,
            'filesErrors' => $filesErrors
        ));
    }

    /**
     * Lists all user entities.
     *
     */
    public function loginAdminAction()
    {
        $request = $this->get("request");
        if ($request->getMethod() == 'POST') {
            $email = $request->request->get('username');
            $password = $request->request->get('password');
            if(is_null($email) || is_null($password)) {
                $this->addFlash(
                    'notice',
                    'Nom d\'utilisateur ou mot de passe incorrect.'
                );
            }
            $user_manager = $this->get('fos_user.user_manager');
            $factory = $this->get('security.encoder_factory');

            $user = $user_manager->findUserByEmail($email);
            if($user){
                $encoder = $factory->getEncoder($user);
                $salt = $user->getSalt();

                if($encoder->isPasswordValid($user->getPassword(), $password, $salt)) {
                    if($user->getRole() == "responsable" || $user->getRole() == "administrator"){
                        $response = new RedirectResponse($this->getRedirectionUrl($user));
                        $this->authenticateUser($user, $response);
                        return $this->redirectToRoute('application_index');
                    }else{
                        $this->addFlash(
                            'notice',
                            "Vous n’êtes pas autorisé à accéder à ce compte"
                        );
                    }
                } else {
                    $this->addFlash(
                        'notice',
                        "Nom d'utilisateur ou mot de passe incorrect."
                    );
                }
            } else {
                $this->addFlash(
                    'notice',
                    "Nom d'utilisateur ou mot de passe incorrect."
                );
            }
        }
        return $this->render('user/admin/login.html.twig', array(
        ));
    }

    public function logoutAction(){
        $token = $this->container->get('security.context')->getToken();
        $user = $token->getUser();
        if($user->getRole() == "student"){
            $route = "fos_user_security_login";
        }else{
            $route = "user_login_admin";
        }
        $this->get('security.context')->setToken(null);
        $this->get('request')->getSession()->invalidate();
        return $this->redirect($this->generateUrl($route));
    }

    public function exportCandidatsAction(){
        $em = $this->getDoctrine()->getManager();
        $token = $this->container->get('security.context')->getToken();
        $user = $token->getUser();
        $schoolId = null;
        if($user->getSchool()){
            $schoolId =$user->getSchool()->getId();
        }
        $params = $this->get('session')->get('params');
        $users = $em->getRepository('AppBundle:User')->findAllPublished($params);
        $filename = "export_candidats_".date("Y_m_d_His").".csv";

        $response = $this->render('user/admin/csvCandidats.html.twig', array('users' => $users));
        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');

        $response->headers->set('Content-Disposition', 'attachment; filename='.$filename);
        return $response;
    }

    /**
     * Send mail to user in order to init the password.
     */
    public function initializePasswordAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);

        $tokenGenerator = $this->container->get('fos_user.util.token_generator');
        $token = $tokenGenerator->generateToken();
        $user->setConfirmationToken($token);
        $em->persist($user);
        $em->flush($user);

        $message = \Swift_Message::newInstance()
            ->setSubject('Réinitialisation de votre mot de passe')
            ->setFrom(array("m.alaoui@linkommunity.com" => "ENAM"))
            ->setTo($user->getEmail())
            ->setCharset('UTF-8')
            ->setContentType('text/html')
            ->setBody($this->container->get('templating')->render('user/initPassowordMail.html.twig', array('token' => $token,'user' => $user)));
        $this->container->get('mailer')->send($message);

        $this->addFlash(
            'notice',
            "Le mail d'initialisation de mot de passe a bien été envoyé à l'utilisateur."
        );

        return $this->redirectToRoute('candidate', array('id' => $user->getId()));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     */
    public function onlinePaymentAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $token = $this->container->get('security.context')->getToken();
        $user = $token->getUser();

        if (!($token->getUser() instanceof User)) {
            $route = "fos_user_security_login";
            $this->get('security.context')->setToken(null);
            $this->get('request')->getSession()->invalidate();

            return $this->redirect($this->generateUrl($route));
        }



        $acceptedExtensions = array("png", "jpg", "jpeg","pdf");
        $filesErrors = array();
        $request = $this->get("request");

        $application = $user->getApplications()->First();

        $countUploadedDocument = 0;
        if ($request->getMethod() == 'POST') {
            $uploadPath = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/' . $user->getId() . '/' . $application->getId();
            $files = $request->files->all();
            foreach ($files as $key => $file) {
                if ($file != null) {
                    if(is_array($file)){
                        foreach ($file as $index => $f) {
                            if ($f != null) {
                                $today = date("d-m-Y");
                                $rand = rand(1, 10000);
                                $uploadedAvatarFile = $f;
                                $extension = $uploadedAvatarFile->guessExtension();
                                if (in_array($extension, $acceptedExtensions)) {
                                    if ($uploadedAvatarFile->getClientSize() < 2000000) {
                                        $new_file_name = $key . '_' . $today . '_' . time() . '_' . uniqid() . '_' . $rand . '.' . $extension;
                                        $documentInstance = $em->getRepository('AppBundle:Document')->findOneBy(array('application' => $application, 'user' => $user, 'documentType' => $em->getRepository('AppBundle:DocumentType')->findOneByCode($key)));
                                        if ($documentInstance != null) {
                                            $fileToDeleted = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/' . $user->getId() . '/' . $application->getId() . '/' . $documentInstance->getFileName();
                                            if (file_exists($fileToDeleted)) {
                                                //unlink($fileToDeleted);
                                            }
                                            //$em->remove($documentInstance);
                                            //$em->flush($documentInstance);
                                        }
                                        $avatarFile = $uploadedAvatarFile->move($uploadPath, $new_file_name);
                                        $document = new Document();
                                        $document->setFileName($new_file_name);
                                        $document->setExtension($extension);
                                        $document->setUser($user);
                                        $document->setApplication($application);
                                        $document->setDocumentType($em->getRepository('AppBundle:DocumentType')->findOneByCode($key));
                                        $em->persist($document);
                                        $em->flush($document);
                                        $countUploadedDocument++;
                                        //dump($document->getId());
                                        unset($uploadedAvatarFile);
                                        $this->addFlash('success',
                                            "Le document ".$f->getClientOriginalName()." a été enregistré"
                                        );
                                    } else {
                                        $this->addFlash('danger',
                                            "La taille du document ".$f->getClientOriginalName() ." est trop grande"
                                        );
                                        $filesErrors[$key][] = "size non valide";
                                    }
                                } else {
                                    $this->addFlash('danger',
                                        "L'extension du document ".$f->getClientOriginalName()." n'est pas accéptée"
                                    );
                                    $filesErrors[$key][] = "L'extension du document ".$f->getClientOriginalName()." n'est pas accéptée";
                                }
                            }
                        }
                    }else{
                        $today = date("d-m-Y");
                        $rand = rand(1, 10000);
                        $uploadedAvatarFile = $file;
                        //dump($file);
                        $extension = $uploadedAvatarFile->guessExtension();
                        if (in_array($extension, $acceptedExtensions)) {
                            if ($file->getClientSize() < 2000000) {
                                $new_file_name = $key . '_' . $today . '_' . time() . '_' . uniqid() . '_' . $rand . '.' . $extension;
                                $documentInstance = $em->getRepository('AppBundle:Document')->findOneBy(array('application' => $application, 'user' => $user, 'documentType' => $em->getRepository('AppBundle:DocumentType')->findOneByCode($key)));
                                if ($documentInstance != null) {
                                    $fileToDeleted = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/' . $user->getId() . '/' . $application->getId() . '/' . $documentInstance->getFileName();
                                    if (file_exists($fileToDeleted)) {
                                        unlink($fileToDeleted);
                                    }
                                    $em->remove($documentInstance);
                                    $em->flush($documentInstance);
                                }
                                $avatarFile = $uploadedAvatarFile->move($uploadPath, $new_file_name);
                                $document = new Document();
                                $document->setFileName($new_file_name);
                                $document->setExtension($extension);
                                $document->setUser($user);
                                $document->setApplication($application);
                                $document->setDocumentType($em->getRepository('AppBundle:DocumentType')->findOneByCode($key));
                                $em->persist($document);
                                $em->flush($document);
                                $countUploadedDocument++;
                                //dump($document->getId());
                                unset($uploadedAvatarFile);
                                $this->addFlash('success',
                                    "Le document ".$file->getClientOriginalName()." a été enregistré"
                                );
                            } else {
                                $this->addFlash('danger',
                                    "La taille du document ".$file->getClientOriginalName() ." est trop grande"
                                );
                                $filesErrors[$key][] = " size non valide";
                            }
                        } else {
                            $this->addFlash('danger',
                                "L'extension du document ".$file->getClientOriginalName()." n'est pas accéptée"
                            );
                            $filesErrors[$key][] = " Extension non valide";
                        }
                    }
                }
            }
            if($countUploadedDocument == 0 && count($filesErrors) == 0){
                $this->addFlash('success',
                    "Aucun document n'a été uploadé"
                );
            }

            $allFilesAreUploaded = true;
            foreach ($application->getCourse()->getDocumentTypes() as $documentType) {
                $documents = $em->getRepository('AppBundle:Document')->findBy(array("application" => $application,"documentType" => $documentType));
                if(count($documents) == 0){
                    $allFilesAreUploaded = false;
                }
            }
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
            if($allFilesAreUploaded && $payment_receipt){
                if(!$application->getMailConfirmation()){
                    $message = \Swift_Message::newInstance()
                        ->setSubject('Confirmation de réception de dossier  ')
                        ->setFrom(array("m.alaoui@linkommunity.com" => "APESA ENAM"))
                        ->setTo($user->getEmail())
                        ->setCharset('UTF-8')
                        ->setContentType('text/html')
                        ->setBody($this->container->get('templating')->render('user/applicationMail.html.twig', array('application' => $application)));
                    $this->container->get('mailer')->send($message);
                    $application->setMailConfirmation(1);
                    $em->persist($application);
                    $em->flush($application);
                }
            }
            if($allFilesAreUploaded){
                $application->setDocumentsUploaded(1);
            }else{
                $application->setDocumentsUploaded(0);
            }
            if($payment_receipt){
                $application->setPaymentReceiptUploaded(1);
            }else{
                $application->setPaymentReceiptUploaded(0);
            }
            $em->persist($application);
            $em->flush($application);

            if($allFilesAreUploaded && count($filesErrors) == 0 && $countUploadedDocument != 0 && $payment_receipt){
                return $this->redirectToRoute('online_payment');
            }
            if($allFilesAreUploaded && count($filesErrors) == 0 && $countUploadedDocument != 0 && !$payment_receipt){
                return $this->redirectToRoute('online_payment');
            }
        }


        $documentType = $em->getRepository('AppBundle:DocumentType')->findOneById(11);
        $document = $em->getRepository('AppBundle:Document')->findOneBy(array('user' => $user, 'documentType' => $documentType));
        $onlinePayment = $em->getRepository('AppBundle:OnlinePayment')->findOneBy(array('candidate' => $user));

        return $this->render('user/onlinePayment.html.twig', array(
            'user' => $user,
            'documentType' => $documentType,
            'document' => $document,
            'application' => $application,
            'onlinePayment' => $onlinePayment,
        ));
    }
}
