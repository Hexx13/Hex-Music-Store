<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\User;
use App\Form\LessonType;
use App\Form\RegistrationFormType;
use App\Repository\ProductRepository;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $template = 'default/index.html.twig';
        $argsArray = [];

        return $this->render($template, $argsArray);
    }

    #[Route('/catalog', name: 'catalog')]
    public function catalog(ProductRepository $productRepository): Response
    {
        $template = 'catalog/catalog.html.twig';
        $argsArray = ['products'=>$productRepository->findAll()];

        return $this->render($template, $argsArray);
    }
    #[Route('/booklesson', name: 'bookLesson')]
    public function bookLesson(Request $request, EntityManagerInterface $entityManager): Response
    {
        $lesson = new Lesson();
        $form = $this->createForm(LessonType::class, $lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password


            $entityManager->persist($lesson);
            $entityManager->flush();


            return $this->redirectToRoute('home');
        }

        return $this->render('default/bookLesson.html.twig', [
            'bookForm' => $form->createView(),
        ]);
    }



}
