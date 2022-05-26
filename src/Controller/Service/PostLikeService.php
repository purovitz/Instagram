<?php

namespace App\Controller\Service;

use App\Entity\Post;
use App\Entity\PostLike;
use App\Entity\User;
use App\Repository\PostLikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class PostLikeService
{
    public function __construct(private Security $security, private EntityManagerInterface $em, private PostLikeRepository $likeRepository )
    {
    }

    public function likePost(Post $post): void
    {
        /** @var User $user */
        $user = $this->security->getUser();

        if ($like = $this->likeRepository->findPostLikeByUser($post, $user)) {
            $this->em->remove($like);
        } else {
            $postLike = (new PostLike())
                ->setPost($post)
                ->setUser($user)
            ;

            $this->em->persist($postLike);
        }

        $this->em->flush();
    }
}
