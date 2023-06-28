<?php

namespace App\Controller;

use Exception;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index()
    {
        return $this->render('home.html.twig', [
            'fullName' => 'Ivalin Venkov',
        ]);
    }

    #[Route('/api/questions/topic/{name}', name: 'get_topic_question')]
    public function getQuestions($name): JsonResponse
    {
        try {
            $data = file_get_contents("../src/storage/{$name}.json");
        } catch (Exception $e) {
            return new JsonResponse([]);
        }

        $json_data = $this->addStyles(json_decode($data));
        $json_data = $this->markMultiple($json_data);
        $json_data = $this->addMarked($json_data);
        
        return new JsonResponse($json_data);
    }

    public function addStyles($data)
    {
        foreach ($data->questions as $question) {
            foreach ($question->answers as $answer) {
                $answer->style = $answer->correct ? 'color:green' : 'color:red';
            }
            $question->answered = false;
        }

        return $data;
    }

    public function markMultiple($data)
    {
        foreach ($data->questions as $item) {
            $col = new ArrayCollection($item->answers);
            $sorted = $col->filter(function ($answer) {
                return $answer->correct;
            });

            if($sorted->count() > 1) {
                $item->has_multiple_correct = true;
            }

            $item->has_multiple_correct = false;
        }

        return $data;
    }

    public function addMarked($data)
    {
        foreach ($data->questions as $question) {
            foreach ($question->answers as $answer) {
                $answer->marked = false;
            }
        }

        return $data;
    }
}
