<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\Product1Type;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGenerator;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'app_product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        if ($this->getUser()->getRoles() != "ROLE_ADMIN") {
            return $this->redirectToRoute('home');
        }
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProductRepository $productRepository): Response
    {
        if ($this->getUser()->getRoles() != "ROLE_ADMIN") {
            return $this->redirectToRoute('home');
        }

        $product = new Product();
        $form = $this->createForm(Product1Type::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $upload = $form['imageFile']->getData();
                                                                             //the path modified
            $targetLocation = $this->getParameter('kernel.project_dir').'/public';

            $fileNameString = pathinfo($upload->getClientOriginalName(), PATHINFO_FILENAME);

                            
            $uniqueName = $fileNameString.'-'.uniqid().'.'.$upload->guessExtension();
            $upload->move(
                $targetLocation,
                $uniqueName
            );

            $product->setImage($uniqueName);

            $productRepository->add($product);
            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        if ($this->getUser()->getRoles() != "ROLE_ADMIN") {
            return $this->redirectToRoute('home');
        }
        $form = $this->createForm(Product1Type::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $upload = $form['imageFile']->getData();
            //the path modified
            $targetLocation = $this->getParameter('kernel.project_dir').'/public';

            $fileNameString = pathinfo($upload->getClientOriginalName(), PATHINFO_FILENAME);

            //remove urlizer
            $uniqueName = $fileNameString.'-'.uniqid().'.'.$upload->guessExtension();
            $upload->move(
                $targetLocation,
                $uniqueName
            );
            //this modified
            $product->setImage($uniqueName);

            $productRepository->add($product);
            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        if ($this->getUser()->getRoles() != "ROLE_ADMIN") {
            return $this->redirectToRoute('home');
        }
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product);
        }

        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }
}
