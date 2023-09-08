<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Course;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Application;
use AppBundle\Entity\ApplicationDiploma;

/**
 * Course controller.
 *
 */
class CourseController extends Controller
{
    /**
     * Lists all course entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $courses = $em->getRepository('AppBundle:Course')->findAll();

        return $this->render('course/index.html.twig', array(
            'courses' => $courses,
        ));
    }

    /**
     * Creates a new course entity.
     *
     */
    public function newAction(Request $request)
    {
        $course = new Course();
        $form = $this->createForm('AppBundle\Form\CourseType', $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($course);
            $em->flush($course);
            $this->addFlash(
                'notice',
                'La passerelle a été bien enregistré'
            );

            return $this->redirectToRoute('course_edit', array('id' => $course->getId()));
        }

        return $this->render('course/new.html.twig', array(
            'course' => $course,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a course entity.
     *
     */
    public function showAction(Course $course)
    {
        $deleteForm = $this->createDeleteForm($course);

        return $this->render('course/show.html.twig', array(
            'course' => $course,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing course entity.
     *
     */
    public function editAction(Request $request, Course $course)
    {
        $deleteForm = $this->createDeleteForm($course);
        $editForm = $this->createForm('AppBundle\Form\CourseType', $course);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'notice',
                'La passerelle a été bien modifié'
            );

            return $this->redirectToRoute('course_edit', array('id' => $course->getId()));
        }

        return $this->render('course/edit.html.twig', array(
            'course' => $course,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a course entity.
     *
     */
    public function deleteAction(Request $request, Course $course)
    {
        $form = $this->createDeleteForm($course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($course);
            $em->flush();
            $this->addFlash(
                'notice',
                'La passerelle a été bien supprimé'
            );
        }

        return $this->redirectToRoute('course_index');
    }

    /**
     * Creates a form to delete a course entity.
     *
     * @param Course $course The course entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Course $course)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('course_delete', array('id' => $course->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Create Sim
     *
     * @return object
     */
    public function getCoursesByDiplomaIdAction($diplomaId)
    {
        $em = $this->getDoctrine()->getManager();
        $diploma = $em->getRepository('AppBundle:Diploma')->findOneById($diplomaId);
        $courses = $em->getRepository('AppBundle:Course')->findByDiploma($diploma);
        $coursesArray= array();
        foreach($courses as $course){
            array_push($coursesArray,array('id'=> $course->getId() ,'value'=> $course->getName()));
        }
        return new JsonResponse($coursesArray);
    }

    /**
     * Create Sim
     *
     * @return object
     */
    public function getCoursesByDiplomaTypeAndSchoolAndTrainingTypeAction($diplomaTypeId,$schoolId,$schoolFieldId,$trainingTypeId)
    {
        $em = $this->getDoctrine()->getManager();
        $diploma = $em->getRepository('AppBundle:Diploma')->getDiplomaByDiplomaTypeIdAndBySchoolIdAndTrainingTypeId($diplomaTypeId,$schoolId,$schoolFieldId,$trainingTypeId);
        $courses = $em->getRepository('AppBundle:Course')->findByDiploma($diploma);
        $coursesArray= array();
        foreach($courses as $course){
            array_push($coursesArray,array('id'=> $course->getId() ,'value'=> $course->getName()));
        }
        return new JsonResponse($coursesArray);
    }

    /**
     * Create Sim
     *
     * @return object
     */
    public function getCourseByIdAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $course = $em->getRepository('AppBundle:Course')->findOneById($id);
        $token = $this->container->get('security.context')->getToken();
        $user = $token->getUser();
        $application = $em->getRepository('AppBundle:Application')->findOneBy(array("course"=>$course,"user"=>$user));
        $postulated = $application ? true : false;
        return new JsonResponse(array("id"=>$course->getId(),"condition"=>$course->getConditions(),"postulated"=>$postulated));
    }

    /**
     * Create Sim
     *
     * @return object
     */
    public function setFieltToUserAction(Request $request)
    {
        $params = $request->request->all();
        //var_dump($params);die;
        $token = $this->container->get('security.context')->getToken();
        $user=$token->getUser();
        $em = $this->getDoctrine()->getManager();

        $course = $em->getRepository('AppBundle:Course')->findOneById($params["courseId"]);
        $school = $em->getRepository('AppBundle:School')->findOneById($params["schoolId"]);
        $diplomaType = $em->getRepository('AppBundle:DiplomaType')->findOneById($params["diplomaTypeId"]);
        $trainingType = $em->getRepository('AppBundle:TrainingType')->findOneById($params["trainingTypeId"]);

        //$application = $em->getRepository('AppBundle:Application')->findOneBy(array("course"=>$course,"user"=>$user));
        if(false){
            $this->addFlash(
                'danger',
                'Vous avez le droit de postuler à une seule formation'
            );
        }else{
            $application = new Application();
            $application->setUser($user);
            $application->setCourse($course);
            $application->setTrainingType($trainingType);
            $application->setDiplomaType($diplomaType);
            $application->setSchool($school);

            $em->persist($application);
            $em->flush($application);

            foreach ($params["diplomas"] as $index => $dp) {
                  $applicationDiploma = new ApplicationDiploma();
                  $applicationDiploma->setOrd($index + 1);
                  $diploma = $em->getRepository('AppBundle:Diploma')->find($dp);
                  $applicationDiploma->setDiploma($diploma);
                  $applicationDiploma->setApplication($application);
                  $em->persist($applicationDiploma);
                  $em->flush($applicationDiploma);
            }

            $this->addFlash(
                'success',
                'Votre candidature a été bien enregistré'
            );
            return $this->redirectToRoute('save_files',array('applicationId'=> $application->getId()));
        }

        return $this->redirectToRoute('application');
    }

    /**
     * Create Sim
     *
     * @return object
     */
    public function updateDiplomeApplicationAction(Request $request)
    {
        $params = $request->request->all();
        //var_dump($params);die;
        $em = $this->getDoctrine()->getManager();

        $application = $em->getRepository('AppBundle:Application')->find($params["applicationId"]);

        foreach ($params["diplomas"] as $index => $dp) {
            $diploma = $em->getRepository('AppBundle:Diploma')->find($dp);
            $applicationDiploma = $em->getRepository('AppBundle:ApplicationDiploma')->findOneBy(array("application" => $application, "ord" => $index + 1));
            $applicationDiploma->setDiploma($diploma);
            $em->persist($applicationDiploma);
            $em->flush($applicationDiploma);
        }

        $this->addFlash(
            'success',
            'Le choix des filières a bien été modifié'
        );
        return $this->redirectToRoute('application');
    }
}
