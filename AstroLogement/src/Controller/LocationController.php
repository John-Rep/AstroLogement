<?php

namespace App\Controller;

use App\Entity\Location;
use App\Form\LocationType;
use App\Form\PhotoType;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/location')]
final class LocationController extends AbstractController{
    #[Route(name: 'app_location_index', methods: ['GET'])]
    public function index(LocationRepository $locationRepository): Response
    {
        return $this->render('location/index.html.twig', [
            'locations' => $locationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_location_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $location = new Location();
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $location->setUser($this->getUser());
            $entityManager->persist($location);
            $entityManager->flush();

            return $this->redirectToRoute('app_location_photo_edit', [ "id" => $location->getId() ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('location/new.html.twig', [
            'location' => $location,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/photo', name: 'app_location_photo_add', methods: ['GET', 'POST'])]
    public function addPhoto(Request $request, Location $location, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PhotoType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get("photo")->getData();

            if ($imageFile) {

                $fileInfo = pathinfo($imageFile->getClientOriginalName());
                $newFilename = $slugger->slug($fileInfo['filename']) . "-" . uniqid() . "." . $fileInfo['extension'];

                $imageFile->move($this->getParameter("photos_directory"), $newFilename);
                $location->addPhoto("photos/" . $newFilename);

                $entityManager->flush();
            }
            

            return $this->redirectToRoute('app_location_photo_edit', [ "id" => $location->getId() ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('location/new_photo.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/photo/edit', name: 'app_location_photo_edit', methods: ['GET', 'POST'])]
    public function editPhoto(Request $request, Location $location, EntityManagerInterface $entityManager): Response
    {
        return $this->render('location/edit_photo.html.twig', [
            'location' => $location,
        ]);
    }

    #[Route('/{id}/photo/{photo}', name: 'app_location_photo_remove', methods: ['POST'])]
    public function removePhoto(Request $request, Location $location, int $photo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('remove'.$location->getId(), $request->getPayload()->getString('_token'))) {
            $photoPath = $this->getParameter('kernel.project_dir') . "/public/" . $location->getPhotos()[$photo];
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
            $location->removePhoto($photo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_location_photo_edit', [
            'id' => $location->getId()
        ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_location_show', methods: ['GET'])]
    public function show(Location $location): Response
    {
        if ($location->getUser() == $this->getUser()) {
            return $this->render('location/show_proprietaire.html.twig', [
                'location' => $location,
            ]);
        } else {
            return $this->render('location/show.html.twig', [
                'location' => $location,
            ]);
        }
    }

    #[Route('/{id}/edit', name: 'app_location_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Location $location, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_location_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('location/edit.html.twig', [
            'location' => $location,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_location_delete', methods: ['POST'])]
    public function delete(Request $request, Location $location, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$location->getId(), $request->getPayload()->getString('_token'))) {
            if($location->getPhotos()){    
                foreach ($location->getPhotos() as $photo) {
                    $photoPath = $this->getParameter('kernel.project_dir') . "/public/" . $photo;
                    if (file_exists($photoPath)) {
                        unlink($photoPath);
                    }
                }
            } 
            $entityManager->remove($location);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_location_index', [], Response::HTTP_SEE_OTHER);
    }
}
