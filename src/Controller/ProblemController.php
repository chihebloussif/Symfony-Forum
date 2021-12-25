<?php

namespace App\Controller;

use App\Entity\Problem;
use App\Form\Problem1Type;
use App\Repository\ProblemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/problem")
 */
class ProblemController extends AbstractController
{
    /**
     * @Route("/", name="problem_index", methods={"GET"})
     */
    public function index(ProblemRepository $problemRepository): Response
    {
        return $this->render('problem/index.html.twig', [
            'problems' => $problemRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="problem_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $problem = new Problem();
        $form = $this->createForm(Problem1Type::class, $problem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($problem);
            $entityManager->flush();

            return $this->redirectToRoute('problem_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('problem/new.html.twig', [
            'problem' => $problem,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="problem_show", methods={"GET"})
     */
    public function show(Problem $problem): Response
    {
        return $this->render('problem/show.html.twig', [
            'problem' => $problem,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="problem_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Problem $problem, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Problem1Type::class, $problem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('problem_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('problem/edit.html.twig', [
            'problem' => $problem,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="problem_delete", methods={"POST"})
     */
    public function delete(Request $request, Problem $problem, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$problem->getId(), $request->request->get('_token'))) {
            $entityManager->remove($problem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('problem_index', [], Response::HTTP_SEE_OTHER);
    }
}
