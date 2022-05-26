<?php

namespace App\Controller\User;


use App\Entity\User;
use App\Form\SearchUserType;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchUserController extends AbstractController
{

    private $finder;

    public function __construct(PaginatedFinderInterface $finder)
    {
        $this->finder = $finder;
    }

    #[Route('search', name: 'search')]
    public function userAction(Request $request,)
    {

        $form = $this->createForm(SearchUserType::class);
        $form->handleRequest($request);
        $userr = [];
        $results = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $userr = strval($form->get('nickname')->getData());
            $results = $this->finder->find($userr);
        }


        return $this->render('admin/search_user.html.twig', [
            'form' => $form->createView(),
            'results' => $results,
        ]);


    }

}
