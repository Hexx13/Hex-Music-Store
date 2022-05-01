<?php

namespace App\Controller;

use App\Entity\Teachers;
use App\Form\Teachers1Type;
use App\Repository\TeachersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/teachers')]
class TeachersController extends AbstractController
{
    #[Route('/', name: 'app_teachers_index', methods: ['GET'])]
    public function index(TeachersRepository $teachersRepository): Response
    {
        return $this->render('teachers/index.html.twig', [
            'teachers' => $teachersRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_teachers_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TeachersRepository $teachersRepository): Response
    {
        $teacher = new Teachers();
        $form = $this->createForm(Teachers1Type::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teachersRepository->add($teacher);
            return $this->redirectToRoute('app_teachers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('teachers/new.html.twig', [
            'teacher' => $teacher,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_teachers_show', methods: ['GET'])]
    public function show(Teachers $teacher): Response
    {
        return $this->render('teachers/show.html.twig', [
            'teacher' => $teacher,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_teachers_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Teachers $teacher, TeachersRepository $teachersRepository): Response
    {
        $form = $this->createForm(Teachers1Type::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teachersRepository->add($teacher);
            return $this->redirectToRoute('app_teachers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('teachers/edit.html.twig', [
            'teacher' => $teacher,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_teachers_delete', methods: ['POST'])]
    public function delete(Request $request, Teachers $teacher, TeachersRepository $teachersRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$teacher->getId(), $request->request->get('_token'))) {
            $teachersRepository->remove($teacher);
        }

        return $this->redirectToRoute('app_teachers_index', [], Response::HTTP_SEE_OTHER);
    }
}
