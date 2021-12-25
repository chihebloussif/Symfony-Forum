<?php

namespace App\Controller;


use App\Entity\Problem;
use App\Entity\Answer;
use App\Form\ProblemType;
use App\Form\AnswerType;
use App\Repository\ProblemRepository;
use App\Repository\AnswerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class HomeController extends AbstractController
{

    /**
     * @Route("/home", name="home")
     */

    public function index( ManagerRegistry $doctrine): Response
    
    {
        
        $problems = $doctrine->getRepository(Problem::class)->findAll();
        $answers = $doctrine->getRepository(Answer::class)->findAll();
      

        //return new Response('Check out this great product: '.$product->getName());

        // or render a template
        // in the template, print things with {{ product.name }}
        return $this->render('home/index.html.twig', [
            'problems' => $problems,
            'answers' => $answers,
        ]);
    
    }
}






    
   /** */ // public function index(QuestionRepository $questionRepository ,AnswerRepository $answerRepository ): Response
   // {
        //return $this->render('home/index.html.twig', [
        //    'questions' => $questionRepository->findAll(),
           // 'answers' => $answerRepository->findAll(),
     //   ]);
  //  }

