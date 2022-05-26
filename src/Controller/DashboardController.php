<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(PaginatorInterface $paginator, Request $request, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $latestPost = $em->getRepository(Post::class)->findAllPublishedOrderedByNewest();


        return $this->render('dashboard/index.html.twig', [
            'pagination' => $paginator->paginate(
                $latestPost, $request->query->getInt('page', 1), 5)
        ]);
    }


    #[Route('/user/{id}', name: 'profile')]
    public function profile(Request $request, User $user, PostRepository $postRepository, int $id, ManagerRegistry $doctrine, UserRepository $userRepository) :Response
    {
        $em = $doctrine->getManager();
        $entityUser = $em->getRepository(User::class)->find($id);



        return $this->render('dashboard/profile.html.twig', [
            'id' => $entityUser->getId(),
            'user' => $user,
            'counter' => $postRepository->countUserPostsss($entityUser),
            'posts' => $postRepository->findUserPostsss($entityUser)
            ]);
    }

}
