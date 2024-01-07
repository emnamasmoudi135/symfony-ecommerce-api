<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CommandeRepository;
use Symfony\Component\HttpFoundation\Response;


class CommandeController extends AbstractController
{
    /**
     * @Route("/commandes", name="commandes_index")
     */
    public function index(CommandeRepository $commandeRepository): Response
    {
        $commandes = $commandeRepository->findAllWithSalesOrderLines();

        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }
}
