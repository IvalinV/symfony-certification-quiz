<?php

namespace App\Controller;

use Exception;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('topic/symfony', name: 'symfony')]
    public function index(EntityManagerInterface $entityManager)
    {
        return $this->render('home.html.twig', [
            'categories' => $this->serialize($entityManager->getRepository(Category::class)->findAll())
        ]);
    }

    #[Route('/api/questions/topic/symfony/category/{name}', name: 'get_topic_question')]
    public function getQuestions($name, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $category = $entityManager->getRepository(Category::class)->findOneBy(['slug' => $name]);
        } catch (Exception $e) {
            return new JsonResponse([]);
        }

        return new JsonResponse(json_decode($this->serialize($category)));
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
