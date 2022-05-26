<?php

namespace App\Controller\Comment;

use App\Entity\Comment;
use App\Entity\User;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditCommentController extends AbstractController
{
    #[Route('/edit/comment/{id}', name: 'app_edit_comment')]
    public function edit(\Doctrine\Persistence\ManagerRegistry $doctrine,
                         int $id,
                         Request $request,
                        Comment $comment): Response
    {

        $this->denyAccessUnlessGranted('EDIT', $comment);

        $em = $doctrine->getManager();
        $entityComment = $em->getRepository(Comment::class)->find($id);
        $form = $this->createForm(CommentType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->getUser()) {
                try {
                    /** @var $user User */
                    $user = $this->getUser();
                    $entityComment->setContent($form->get('content')->getData());
                    $entityComment->setCreatedAt(new \DateTime());
                    $entityComment->setAuthor($user);

                    $em->persist($entityComment);
                    $em->flush();
                } catch (\Exception $e) {
                    $this->addFlash('error', 'Błąd!');
                }
            }


            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('edit_comment/index.html.twig', [
            'form' => $form->createView(),
            'comment' => $entityComment,
            'commentt' => $comment,
        ]);
    }
}
