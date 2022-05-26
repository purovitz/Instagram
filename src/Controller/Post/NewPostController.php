<?php

namespace App\Controller\Post;

use App\Entity\Post;
use App\Entity\User;
use App\Form\UploadPostType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;



class NewPostController extends AbstractController
{


    /**
     * @param Request $request
     * @param SluggerInterface $slugger
     * @param ManagerRegistry $doctrine
     * @return Response
     * @throws \Exception
     */
    #[Route('/create_post', name: 'create_post')]
    public function newPost(Request $request,
                            SluggerInterface $slugger,
                            \Doctrine\Persistence\ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(UploadPostType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $doctrine->getManager();
            if ($this->getUser()) {
                /** @var  UploadedFile $pictureFileName */
                /** @var  $user \App\Entity\User */

                $pictureFileName = $form->get('image')->getData();
                if ($pictureFileName) {
                    try {
                        $originalFileName = pathinfo($pictureFileName->getClientOriginalName(), PATHINFO_FILENAME);
                        $safeFileName = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFileName);
                        $newFileName = $safeFileName.'-'.uniqid().'.'.$pictureFileName->guessExtension();
                        $pictureFileName->move('images/hosting', $newFileName);
                    } catch(\Exception $e) {
                        $this->addFlash('error', 'Błąd!');
                    }
                        $entityPost = new Post();
                        $entityPost->setImage($newFileName);
                        $entityPost->setContent($form->get('content')->getData());
                        $random = random_bytes(20);
                        $entityPost->setSlug($slugger->slug(bin2hex($random)));
                        $entityPost->setUploadedAt(new \DateTime());
                        $user = $this->getUser();
                        $entityPost->setUser($user);

                        $em->persist($entityPost);
                        $em->flush();
                        $this->addFlash('success', 'Dodano nowy post!');


                    return $this->redirectToRoute('create_post');
                }


            }
        }
        return $this->render('post/newPost.html.twig', [
            'form' => $form->createView(),
        ]);
    }




}
