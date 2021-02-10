<?php

namespace App\Controller;

use App\Form\PostType;
use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard', name: 'dashboard_')]
class PostController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $posts = $this->getUser()->getPosts();

        return $this->render('post/index.html.twig', ['posts'=>$posts]);
    }

    #[Route('/create', name:'create')]
    public function create(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $form = $this->createForm(PostType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $post = new Post();
            $post = $form->getData();

            /** @var \App\Entity\User $user */
            $user = $this->getUser();
            
            $post->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('dashboard_index');
        }

        return $this->render('post/create.html.twig', ['form'=>$form->createView()]);

    }

    #[Route('/show/{id}', name:"show")]
    public function show(int $id, PostRepository $postRepo)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser()->getId();
        $post = $postRepo->findOneByIdAndUser($id, $user);

        if (!$post) throw $this->createNotFoundException('Post not found.');

        return $this->render('post/show.html.twig', ['post'=>$post]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(Request $request, int $id, PostRepository $postRepo)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser()->getId();
        $post = $postRepo->findOneByIdAndUser($id, $user);

        if (!$post) throw $this->createNotFoundException('Post not found :(');

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('notice', 'Post has been updated!');

            return $this->redirectToRoute('dashboard_index');
        }

        return $this->render('post/edit.html.twig', ['form'=>$form->createView()]);
    }
}
