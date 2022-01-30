<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;

class LuckyController extends AbstractController
{
   /**
    * @Route("/lucky/number/{id}", name="display_number")
    */
    public function number(ManagerRegistry $doctrine, int $id): Response
    {
        if ($id == '' || $id == 0) {
            $number = random_int(0, 100);
        } else {
            $number = $id;
        }


        return $this->render('lucky/number.html.twig', [
            'number' => $number,
        ]);
    }

    /**
    * @Route("/lucky/number", name="display_number_not_random")
    */
    public function number2(): Response
    {
        $number = random_int(0, 100);


        return $this->render('lucky/number.html.twig', [
            'number' => $number,
        ]);
    }
}
