<?php

namespace App\Controller;

use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function index(): Response
    {
        $form = $this->createForm(RegistrationType::class);
        return $this->render('security/register.html.twig', ['form'=>$form->createView()]);
    }
}
