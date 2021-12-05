<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Compagny;
use App\Entity\Customer;
use App\Repository\ProductRepository;
use App\Repository\CompagnyRepository;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
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

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    // ----------------mon teste 2----------------------------------------------------------------

    /**
     * @Route("/customers", name="customer_list", methods={"GET"})
     */
    public function listCustomer(CustomerRepository $repo, SerializerInterface $serializer)
    {
        $customers = $repo->findAll();

        $data = $serializer->serialize($customers, 'json', ['groups' => 'group2']);

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/customers/{id}", name="customer_show", methods={"GET"})
     */
    public function showCustomer(Customer $customer, SerializerInterface $serializer)
    {
        $data = $serializer->serialize($customer, 'json', ['groups' => 'group2']);

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/customers", name="customer_create", methods={"POST"})
     */
    public function createCustomer(Request $request, SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $compagny = $this->getUser();
        // dd($compagny);

        $data = $request->getContent();
        // dd($data);

        $customer = $serializer->deserialize($data, Customer::class, 'json');
        $customer->setCompagny($compagny);
        // dd($customer);

        $em->persist($customer);
        $em->flush();

        // -----------------------question menteor--------------------------------
        // JE VOUDRAIS RECUPERER LE CUSTOMER CREER POUR LE RETOURNER EN JSON
        // -----------------------question menteor--------------------------------
        return new Response('ok customer is create', 201);
    }

    /**
     * @Route("/customers/{id}", name="customer_delete", methods={"DELETE"})
     */
    public function deleteCustomer(Customer $customer, EntityManagerInterface $em)
    {
        $em->remove($customer);
        $em->flush();
        return new Response('ok customer is delete', 204);
    }
}
