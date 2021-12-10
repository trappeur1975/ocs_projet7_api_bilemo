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
     * @Route("/products/{page}", name="product_list", methods={"GET"})
     */
    public function listProduct(ProductRepository $repo, SerializerInterface $serializer, int $page = 1)
    {
        $numerProductsDisplay = 5;
        $offset = ($page - 1) * $numerProductsDisplay;

        // $products = $repo->findAll();
        $products = $repo->findBy(
            [],
            ['id' => 'ASC'],
            $numerProductsDisplay, //la limite
            $offset
        );

        $data = $serializer->serialize($products, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/product/{id}", name="product_show", methods={"GET"})
     */
    public function showProduct(Product $product, SerializerInterface $serializer)
    {
        $data = $serializer->serialize($product, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/customers", name="customer_list", methods={"GET"})
     */
    public function listCustomer(SerializerInterface $serializer)
    {
        $customers = $this->getUser()->getCustomers();

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
        $customers = $this->getUser()->getCustomers();
        if ($customers->contains($customer)) {
            $data = $serializer->serialize($customer, 'json', ['groups' => 'group2']);

            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        } else {
            return new Response('this customer does not belong to you', 403);
        }
    }

    /**
     * @Route("/customers", name="customer_create", methods={"POST"})
     */
    public function createCustomer(CustomerRepository $repo, Request $request, SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $compagny = $this->getUser();

        $data = $request->getContent();
        $customer = $serializer->deserialize($data, Customer::class, 'json');
        $emailCustomer = $customer->getEmail();

        $customers = $this->getUser()->getCustomers();

        //  we check if the customer already exists (via his email) in the list of customers of the company. if email is already present this is the customer has already been created 
        $exists = $customers->exists(function ($key, $value) use ($emailCustomer) {
            $result = ($value->getEmail() === $emailCustomer);
            return $result;
        });

        if (!$exists) {
            $customer->setCompagny($compagny);

            $em->persist($customer);
            $em->flush();

            // we return the last customer create
            $lastCustomerCreate = ($repo->findBy([], ['id' => 'DESC'], 1, 0))[0];
            // $lastCustomerCreate = $this->getUser()->getCustomers()->last();
            // dd($lastCustomerCreate);
            // dd($this->getUser()->getCustomers());

            $data = $serializer->serialize($lastCustomerCreate, 'json', ['groups' => 'group2']);

            $response = new Response($data, 201);
            $response->headers->set('Content-Type', 'application/json');

            return $response;
            // return new Response('ok customer is create', 201);
        } else {
            return new Response('customer not created because it already exists ', 403);
        }
    }

    /**
     * @Route("/customers/{id}", name="customer_delete", methods={"DELETE"})
     */
    public function deleteCustomer(Customer $customer, EntityManagerInterface $em)
    {
        $customers = $this->getUser()->getCustomers();
        // dd($customers->contains($customer));
        if ($customers->contains($customer)) {
            $em->remove($customer);
            $em->flush();
            return new Response('ok customer is delete', 204);
        } else {
            return new Response('this customer does not belong to you', 403);
        }
    }
}
