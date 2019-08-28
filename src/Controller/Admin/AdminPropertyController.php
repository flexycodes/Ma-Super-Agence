<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use App\Form\PropertyType;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminPropertyController extends AbstractController
{
    private $repository;
    private $entityManager;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->repository      = $repository;
        $this->entityManager   = $entityManager;
    }

    /**
     * @Route("/admin/properties", name="admin.property.index")
     */
    public function index()
    {
        $properties = $this->repository->findAll();

        return $this->render('admin/admin_property/index.html.twig', [
            'controller_name' => 'AdminPropertyController',
            'properties' => $properties,
        ]);
    }

    /**
     * @Route("/admin/property/new", name="admin.property.new")
     */
    public function new(Request $request)
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($property);
            $this->entityManager->flush();
            $this->addFlash('success', 'Article Created! Knowledge is power!');

            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/admin_property/new.html.twig', [
            'controller_name' => 'AdminPropertyController',
            'property' => $property,
            'form_property' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id}/edit", name="admin.property.edit", methods="GET|POST")
     */
    public function edit(Property $property, Request $request)
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Article Updated! Inaccuracies squashed!');

            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/admin_property/edit.html.twig', [
            'controller_name' => 'AdminPropertyController',
            'property' => $property,
            'form_property' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id}/delete", name="admin.property.delete", methods="DELETE")
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(Property $property, Request $request)
    {

        $submittedToken = $request->get('_token');

        if ($this->isCsrfTokenValid('delete' . $property->getId() , $submittedToken)) {
            $this->entityManager->remove($property);
            $this->entityManager->flush();
            $this->addFlash('success', 'Article Deleted! Inaccuracies squashed!');
        }

        return $this->redirectToRoute('admin.property.index');
    }
}
