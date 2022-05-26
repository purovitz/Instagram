<?php

namespace App\Controller\Post;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use App\Form\CommentType;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowPostController extends AbstractController
{
    #[Route('/post/{slug}', name: 'app_show_post')]

    public function show(PostRepository $postRepository,
                         Request $request,
                         string $slug,
                         \Doctrine\Persistence\ManagerRegistry $doctrine): Response
    {
        $post = $postRepository->findOneBySlug($slug);

        $comments = $post->getComments();
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var $user User */
            $user = $this->getUser();
            $comment->setPost($post);
            $comment->setCreatedAt(new \DateTime());
            $comment->setAuthor($user);
            $comment->setContent($form->get('content')->getData());
            $post->setCommentCount($post->getCommentCount() + 1);

            $em = $doctrine->getManager();
            $em->persist($comment);
            $em->flush();

            $this->addFlash('success', 'Comment has been created successfully');

            return $this->redirectToRoute('app_show_post', ['slug' => $post->getSlug()]);
        }

        return $this->render('post/showPost.html.twig', [
            'post' => $post,
            'comments' => $comments,
            'form' => $form->createView(),

        ]);
    }
}
