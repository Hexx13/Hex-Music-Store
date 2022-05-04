<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\Product2Type;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use http\Client\Curl\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/', name: 'app_product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     */
    #[Route('/new/', name: 'app_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProductRepository $productRepository, UserRepository $userRepository): Response
    {
        $product = new Product();
        $form = $this->createForm(Product2Type::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$form['imageFile']->getData()==null){
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
            }

            $username =  $this->getUser()->getUserIdentifier();
            $product->setUser($userRepository->findOneBySomeField($username));


            $productRepository->add($product);
            if ($this->isGranted('ROLE_ADMIN')){
                return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
            } else{
                return $this->redirectToRoute('catalog', [], Response::HTTP_SEE_OTHER);
            }
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
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(Product2Type::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$form['imageFile']->getData()==null){
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
            }

            $username =  $this->getUser()->getUserIdentifier();

            $productRepository->add($product);
            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_product_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product);
        }

        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }
}
