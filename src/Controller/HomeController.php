<?php

namespace App\Controller;

use App\Repository\PropertyRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Knp\Component\Pager\PaginatorInterface;

class HomeController extends AbstractController
{

    private $repository;

    public function __construct(PropertyRepository $repository)
    {
        $this->repository   = $repository;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        //$properties = $repository->findLatest();
        //dump($properties);

        $properties = $paginator->paginate(
            $this->repository->findAllVisibleQuery(),
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('pages/index.html.twig', [
            'controller_name' => 'HomeController',
            'properties' => $properties,
        ]);
    }
}
