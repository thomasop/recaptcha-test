<?php

namespace App\Controller;

use App\Form\HomeType;
use ReCaptcha\ReCaptcha;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(HomeType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();
            $captcha = $_POST['g-recaptcha-response'];
            $secret = '6LcZPf4eAAAAABtSPbNFcyzSaqYhEnEhk3Fb_gwX';
            $url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR'];
            $response = file_get_contents($url);
            $response = json_decode($response);
            if ($response->success == true && $response->score >= 0.5) {
                $message = (new Email())
                        ->from(htmlspecialchars($contactFormData['email']))
                        ->to('tdss33@hotmail.com')
                        ->subject(htmlspecialchars($contactFormData['objet']))
                        ->text('Expéditeur : '.htmlspecialchars($contactFormData['email']).\PHP_EOL.
                        htmlspecialchars($contactFormData['message']),
                            'text/plain');
                    $mailer->send($message);
                    $this->addFlash('success', 'Vous n\'êtes pas un robot, mail envoyé');
                    return $this->redirectToRoute('app_home');
            } else {
                $this->addFlash('success', 'Vous êtes un robot, mail pas envoyé');
                return $this->redirectToRoute('app_home');
            }
            
        }
        return $this->render('home/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
