<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use App\Form\CommentFormType;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/post', name: 'app_post')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        $session = $request->getSession();
        if (!$session->isStarted()) {
            $session->start();
        }

        $name = $session->get('name') ?? null;

        $post = $doctrine->getRepository(Post::class)->getLastPosts();

        return $this->render('main/index.html.twig', [
            'controller_name' => 'PostController',
            'post' => $post,
            'user_name' => $name
        ]);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[Route('/post/{id}', name: 'post')]
    public function post(Post $post, ManagerRegistry $doctrine, Request $request): Response
    {
        $session = $request->getSession();
        if (!$session->isStarted()) {
            $session->start();
        }

        $name = $session->get('name') ?? null;

        $comments = $doctrine->getRepository(Comment::class)->getCommentsById($post->getId());

        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $comment = $form->getData();
            $comment->setAuthor($doctrine->getRepository(User::class)
                ->find($this->container->get('security.token_storage')->getToken()->getUser()->getId()));
            $comment->setDate(new \DateTime('now'));
            $comment->setNews($doctrine->getRepository(Post::class)->find($post->getId()));
            $em = $doctrine->getManager();
            $em->persist($comment);
            $em->flush();
            return $this->redirect($post->getId());
        }

        $entityManager = $doctrine->getManager();
        $entityManager->persist($post);
        $entityManager->flush();


        return $this->renderForm('main/news.html.twig', [
            'controller_name' => 'PostController',
            'post' => $post,
            'comments' => $comments,
            'user_name' => $name,
            'form' => $form
        ]);
    }
}
