<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class ApplicationCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "app/console")
            ->setName('app:mail-relance')

            // the short description shown while running "php app/console list"
            ->setDescription('Mail de relance.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('TMail de relance ....')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $em = $this->getContainer()->get('doctrine')->getManager();
        $applications = $em->getRepository("AppBundle:Application")->getApplications();
        foreach ($applications as $application) {
            // send mail
            $message = \Swift_Message::newInstance()
                ->setSubject('Mail de relance')
                ->setFrom(array("noreply@esith.ac.ma" => "ESITH"))
                ->setTo($application->getUser()->getEmail())
                ->setCharset('UTF-8')
                ->setContentType('text/html')
                ->setBody($this->getContainer()->get('templating')->render('application/mailRelance.html.twig', array('application' => $application)));
            $result = $this->getContainer()->get('mailer')->send($message);
            $container = $this->getContainer();
            $mailer = $container->get('mailer');
            $spool = $mailer->getTransport()->getSpool();
            $transport = $container->get('swiftmailer.transport.real');
            $spool->flushQueue($transport);
            if(count($result)>0){
                $application->setMailRelance(1);
                $em->persist($application);
                $em->flush($application);
            }
        }


    }
}
