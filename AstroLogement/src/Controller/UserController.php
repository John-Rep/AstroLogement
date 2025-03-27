<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/profil')]
class UserController extends AbstractController
{
    #[Route(name: 'app_profil')]
    public function profil(Request $request, EntityManagerInterface $entityManager): Response
    {


        return $this->render('user/profil.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
    
}
