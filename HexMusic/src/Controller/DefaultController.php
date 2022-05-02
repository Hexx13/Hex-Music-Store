<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

    #[Route('/calendar', name: 'booking_calendar', methods: ['GET'])]
    public function calendar(): Response
    {
        return $this->render('booking/calendar.html.twig');
    }
    #[Route('/adminpanel', name: 'admin_panel', methods: ['GET'])]
    public function adminPanel(): Response
    {
        if ($this->getUser()->getRoles() != "ROLE_ADMIN") {
            return $this->redirectToRoute('home');
        }
        return $this->render('default/adminPanel.html.twig');
    }
}
