<?php

namespace App\Controller;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;

use App\Form\Type\ProductType;

class ProductController extends AbstractController
{
    // #[Route('/product', name: 'product')]
    // public function index(): Response
    // {
    //     return $this->render('product/index.html.twig', [
    //         'controller_name' => 'ProductController',
    //     ]);
    // }
    /**
     * @Route("/product", name="create_product")
     */
    public function createProduct(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $product = new Product();
        //$product->setName('Keyboard');
        //$product->setPrice(1999);
        //$product->setDescription('Ergonomic and stylish!');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $response = $this->forward('App\Controller\HomeController::index');
        return $response;

        //return new Response('Saved new product with id '.$product->getId());
    }


    /**
     * @Route("/product/delete/{id}", name="product_show")
     */
    public function deleteProduct(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();

        $product = $doctrine->getRepository(Product::class)->find($id);
        $entityManager->remove($product);
        $entityManager->flush();

        $response = $this->forward('App\Controller\HomeController::index');
        return $response;
    }

    /**
     * @Route("/product/form/new", name="product_new")
     */

    public function new(Request $request,ManagerRegistry $doctrine): Response
    {
        // creates a task object and initializes some data for this example
        $product = new Product();

      //  $form = $this->createForm(ProductType::class, $product);

        $form = $this->createFormBuilder($product)
            ->add('name', TextType::class)
            ->add('price', TextType::class)
            ->add('description', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Product'])
            ->getForm();

            $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $result = $form->getData();

            $em = $doctrine->getManager();
            $em->persist($result);
            $em->flush();

            $response = $this->forward('App\Controller\HomeController::index');
            return $response;
        }

        return $this->renderForm('product/index.html.twig', [
            'form' => $form,
        ]);

    }

    /**
     * @Route("/product/edit/{id}", name="product_edit")
     */
    public function editProduct(Request $request,ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $product = $doctrine->getRepository(Product::class)->find($id);

        if (!$product) {
            return new Response('No products found');
        }

       // $product = new Product();

        $form = $this->createFormBuilder($product)
            ->add('name', TextType::class)
            ->add('price', TextType::class)
            ->add('description', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Edit Product'])
            ->getForm();

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $result = $form->getData();
                $product->setName($result->getName());
                $product->setPrice($result->getPrice());
                $product->setDescription($result->getDescription());
                $entityManager->flush();

                $response = $this->forward('App\Controller\HomeController::index');
                return $response;
            }

        return $this->renderForm('product/index.html.twig', [
            'form' => $form,
        ]);
    }

}
