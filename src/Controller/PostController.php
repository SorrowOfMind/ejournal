<?php

namespace App\Controller;

use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard', name: 'dashboard_')]
class PostController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('post/index.html.twig');
    }

    #[Route('/create', name:'create')]
    public function create()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $id = $this->getUser();
        dump($id);

        $form = $this->createForm(PostType::class);

        return $this->render('post/create.html.twig', ['form'=>$form->createView()]);

    }
}
