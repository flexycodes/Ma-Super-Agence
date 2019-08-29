<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Knp\Component\Pager\PaginatorInterface;

class PropertyController extends AbstractController
{
    private $repository;
    private $objectManager;

    public function __construct(PropertyRepository $repository, ObjectManager $objectManager)
    {
        $this->repository   = $repository;
        $this->objectManager   = $objectManager;
    }

    /**
     * @Route("/biens", name="property.index")
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $properties = $paginator->paginate(
            $this->repository->findAllVisibleQuery(),
            $request->query->getInt('page', 1),
            9
        );

        //dump($properties);

        return $this->render('property/index.html.twig', [
            'controller_name' => 'PropertyController',
            'properties' => $properties,
        ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show(Property $property, String $slug )
    {
        $getSlug = $property->getSlug();
        if( $getSlug !== $slug ):
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $getSlug
            ]);
        endif;

        return $this->render('property/show.html.twig', [
            'controller_name' => 'PropertyController',
            'property' => $property,
        ]);
    }

    // public function index()
    // {
    //     // $property = new Property();

    //     // $property->setTitle("A must see Villa on Chicago Ave")
    //     //          ->setDescription("Beautiful, updated, ground level Co-op apartment in the desirable Bay Terrace neighborhood. This home features hardwood floors throughout, brand new bathrooms, newer EIK, modern front-load washer/dryer, full dining room, large living area, 3 spacious bedrooms and plenty of storage. Master bedroom includes both a standard closet and custom closet wall unit. Large windows face many directions for tons of natural light.")
    //     //          ->setSurface(260)
    //     //          ->setRooms(5)
    //     //          ->setBedrooms(2)
    //     //          ->setFloor(1)
    //     //          ->setPrice(650000)
    //     //          ->setHeat(1)
    //     //          ->setCity("Chicago")
    //     //          ->setAddress("53 W 88th St, Chicago, Ranch Triangle")
    //     //          ->setPostalCode("28000")
    //     //          ->setSold(1)
    //     // ;

    //     // $entityManager = $this->getDoctrine()->getManager();
    //     // $entityManager->persist($property);
    //     // $entityManager->flush();

    //     // $repository = $this->getDoctrine()->getRepository(Property::class);
     

    //     // $properties = $repository->findAll();
    //     // dump($properties);

    //     //$properties = $this->repository->findAll();
    //     //$properties = $this->repository->findOneBy(['rooms' => 5]);
    //     $properties = $this->repository->findAllVisible();
    //     //dump($properties);

    //     //$properties[0]->setSold(true);
    //     //$this->objectManager->flush();

    //     return $this->render('property/index.html.twig', [
    //         'controller_name' => 'PropertyController',
    //         'properties' => $properties,
    //     ]);
    // }

}
