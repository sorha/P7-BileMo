<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    /**
     * @Route("/api/products", name="api_product_list", methods={"GET"})
     */
    public function listProductAction(ProductRepository $productRepository)
    {
        $products = $productRepository->findAll();
        if(!$products)
        {
            $response = new Response(json_encode(['error' => 'Product with this id don\'t exist']), Response::HTTP_NOT_FOUND);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

        $products = $this->get('serializer')->serialize($products, 'json');

        $response = new Response($product, Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
    
    /**
     * @Route("/api/products/{id}", name="api_product_get", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function getProductAction($id, ProductRepository $productRepository)
    {
        $product = $productRepository->findOneById($id);
        if(!$product)
        {
            $response = new Response(json_encode(['error' => 'Product with this id don\'t exist']), Response::HTTP_NOT_FOUND);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

        $product = $this->get('serializer')->serialize($product, 'json');

        $response = new Response($product, Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }

    /**
     * @Route("/api/products", name="api_product_post", methods={"POST"})
     */
    public function postProductAction(Request $request, ObjectManager $manager, ValidatorInterface $validator)
    {
        $data = $request->getContent();
        $product = $this->get('serializer')->deserialize($data, 'App\Entity\Product', 'json');

        $errors = $validator->validate($product);
        if(count($errors) > 0)
        {
            return new Response($errors, Response::HTTP_BAD_REQUEST);
        }

        $manager->persist($product);
        $manager->flush();
        
        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/products/{id}", name="api_product_delete", requirements={"id"="\d+"}, methods={"DELETE"})
     */
    public function deleteProductAction($id, ProductRepository $productRepository, ObjectManager $manager)
    {
        $product = $productRepository->findOneById($id);
        if(!$product)
        {
            $response = new Response(json_encode(['error' => 'Product with this id don\'t exist']), Response::HTTP_NOT_FOUND);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        
        $manager->remove($product);
        $manager->flush();
        
        return new Response(json_encode(['error' => 'Product with this id doesn\'t exist']), Response::HTTP_NO_CONTENT);;
    }

    /**
     * @Route("/api/products/{id}", name="api_product_edit", requirements={"id"="\d+"}, methods={"PUT"})
     */ 
    public function editProductAction($id, ProductRepository $productRepository, Request $request, ObjectManager $manager)
    {   
        $product = $productRepository->findOneById($id);
        if(!$product)
        {
            $response = new Response(json_encode(['error' => 'Product with this id don\'t exist']), Response::HTTP_NOT_FOUND);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

        $data = $request->getContent();
        $newProduct = $this->get('serializer')->deserialize($data, 'App\Entity\Product', 'json');

        $product->setName($newProduct->getName());
        $product->setBrand($newProduct->getBrand());
        $product->setPrice($newProduct->getPrice());
        $product->setDescription($newProduct->getDescription());

        $manager->flush();

        $response = new Response('', Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
}
