<?php

namespace App\Controller\Post;

use App\Controller\Service\PostLikeService;
use App\Entity\Post;
use App\Repository\PostLikeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PostLikeController extends AbstractController
{

    #[Route(path: '/post/like/{id}', name: 'app_like_post' )]
    public function like(Post $post, PostLikeService $likeService, PostLikeRepository $likeRepository): Response
    {
        $likeService->likePost($post);

        return $this->redirectToRoute('app_show_post', ['slug' => $post->getSlug()]);
    }


}
