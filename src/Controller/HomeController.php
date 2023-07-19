<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Question;
use Exception;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Yaml\Yaml;

class HomeController extends AbstractController
{
    #[Route('topic/symfony', name: 'symfony')]
    public function index(EntityManagerInterface $entityManager)
    {
        return $this->render('home.html.twig', [
            'categories' => $this->serialize($entityManager->getRepository(Category::class)->findAll())
        ]);
    }

    #[Route('/api/questions/topic/{name}', name: 'get_topic_question')]
    public function getQuestions($name, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $category = $entityManager->getRepository(Category::class)->findOneBy(['slug' => $name]);
        } catch (Exception $e) {
            return new JsonResponse([]);
        }

        return new JsonResponse(json_decode($this->serialize($category)));
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

    /**
     * Serialize entitties
     *
     * Entities should be serialize in order to be passed to the Vue 3 component.
     *
     * @param Array $data Doctrine Entities
     * @return Serializer
     **/
    public function serialize($data)
    {
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer(array($normalizer), array($encoder));

        return $serializer->serialize($data, 'json', [
             'circular_reference_handler' => function ($object) {
                 return $object->getId();
             }
        ]);
    }
}
