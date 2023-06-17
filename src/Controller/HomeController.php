<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

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

        return new JsonResponse(json_decode($data));
    }
}
