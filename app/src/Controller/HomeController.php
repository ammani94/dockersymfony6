<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Product::class);

        $products = $repository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'products' => $products,
        ]);
    }
}
