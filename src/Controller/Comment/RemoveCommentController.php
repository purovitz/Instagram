<?php

namespace App\Controller\Comment;

use App\Entity\Comment;
use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RemoveCommentController extends AbstractController
{
    #[Route('/remove/comment/{id}', name: 'app_remove_comment')]
    public function commentRemove(int $id,
                                  \Doctrine\Persistence\ManagerRegistry $doctrine,
                                  Request $request ): Response
    {
        $em = $doctrine->getManager();
        $comment = $em->getRepository(Comment::class)->find($id);



        if ($this->getUser() == $comment->getAuthor())
        {
            $em->remove($comment);
            $em->flush();
            $this->addFlash('success', "Usunięto komentarz!");
        } else {
            $this->addFlash('error', 'Nie udało się usunąć komentarza.');
        }

        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }
}
