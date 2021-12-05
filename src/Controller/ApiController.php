<?php

namespace App\Controller;

use App\Entity\Compagny;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\CompagnyRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api", name="api")
 */
class ApiController extends AbstractController
{

    /**
     * @Route("/", name="apiIndex")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiController.php',
        ]);
    }

    /**
     * @Route("/compagnies", name="compagny_list", methods={"GET"})
     */
    public function listCompagny(CompagnyRepository $repo, SerializerInterface $serializer)
    {
        $compagnies = $repo->findAll();

        $data = $serializer->serialize($compagnies, 'json', ['groups' => 'group1']);

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/products", name="product_list", methods={"GET"})
     */
    public function listProduct(ProductRepository $repo, SerializerInterface $serializer)
    {
        $products = $repo->findAll();

        $data = $serializer->serialize($products, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/products/{id}", name="product_show", methods={"GET"})
     */
    public function showProduct(Product $product, SerializerInterface $serializer)
    {
        $data = $serializer->serialize($product, 'json');
        // $data = $serializer->serialize($article, 'json', ['groups' => 'list']);

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
