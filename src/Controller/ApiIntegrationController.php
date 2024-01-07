<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CommandeRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Commande;
use App\Entity\SalesOrderLine;
use App\Entity\Article;
use App\Repository\ArticleRepository;


class ApiIntegrationController extends AbstractController
{
    /**
     * @Route("/fetch-and-store-commande", name="fetch_and_store")
     */
    public function fetchAndStore(HttpClientInterface $httpClient, EntityManagerInterface $entityManager, CommandeRepository $commandeRepository): Response
    {
        // Define headers for the API request
        $headers = [
            'headers' => [
                'x-api-key' => 'PMAK-62642462da39cd50e9ab4ea7-815e244f4fdea2d2075d8966cac3b7f10b',
            ],
        ];

        // Make API request with headers
        $response = $httpClient->request('GET', 'https://internshipapi-pylfsebcoa-ew.a.run.app/orders', $headers);

        // Decode JSON response
        $data = $response->toArray();

        foreach ($data['results'] as $apiCommande) {
            $commande = new Commande();
            $commande->setAmount($apiCommande['Amount']);
            $commande->setCurrency($apiCommande['Currency']);
            $commande->setDeliverTo($apiCommande['DeliverTo']);
            $commande->setOrderID($apiCommande['OrderID']);
            $commande->setOrderNumber($apiCommande['OrderNumber']);


            foreach ($apiCommande['SalesOrderLines']['results'] as $apiSalesOrderLine) {
                $salesOrderLine = new SalesOrderLine();
                $salesOrderLine->setAmount($apiSalesOrderLine['Amount']);
                $salesOrderLine->setDescription($apiSalesOrderLine['Description']);
                $salesOrderLine->setDiscount($apiSalesOrderLine['Discount']);
                $salesOrderLine->setItem($apiSalesOrderLine['Item']);
                $salesOrderLine->setItemDescription($apiSalesOrderLine['ItemDescription']);
                $salesOrderLine->setQuantity($apiSalesOrderLine['Quantity']);
                $salesOrderLine->setUnitCode($apiSalesOrderLine['UnitCode']);
                $salesOrderLine->setUnitDescription($apiSalesOrderLine['UnitDescription']);
                $salesOrderLine->setUnitPrice($apiSalesOrderLine['UnitPrice']);
                $salesOrderLine->setVATAmount($apiSalesOrderLine['VATAmount']);
                $salesOrderLine->setVATPercentage($apiSalesOrderLine['VATPercentage']);

                // Associate SalesOrderLine with Commande
                $commande->addSalesOrderLine($salesOrderLine);

                // Persist SalesOrderLine to the database
                $entityManager->persist($salesOrderLine);

        }

            // Persist Commande to the database
            $entityManager->persist($commande);
        }

        // Flush changes to the database
        $entityManager->flush();

        return $this->redirectToRoute('display_data');
    }

    /**
     * @Route("/display-commande", name="display_data")
     */
    public function displayData(CommandeRepository $commandeRepository): Response
    {
        $commandes = $commandeRepository->findAllWithSalesOrderLines();

        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }


///////////////////////////////////////////////////////
/// Articles:

    /**
     * @Route("/fetch-and-store-articles", name="fetch_and_store_articles")
     */
    public function fetchAndStoreArticles(HttpClientInterface $httpClient, EntityManagerInterface $entityManager): Response
    {
        $headers = [
            'headers' => [
                'x-api-key' => 'PMAK-62642462da39cd50e9ab4ea7-815e244f4fdea2d2075d8966cac3b7f10b',
            ],
        ];

        $response = $httpClient->request('GET', 'https://internshipapi-pylfsebcoa-ew.a.run.app/orders', $headers);
        $data = $response->toArray();

        foreach ($data['results'] as $apiCommande) {
                foreach ($apiCommande['SalesOrderLines']['results'] as $apiSalesOrderLine) {
                    $article = new Article();
                    $article->setItem($apiSalesOrderLine['Item']);
                    $article->setItemDescription($apiSalesOrderLine['ItemDescription']);
                    $article->setUnitCode($apiSalesOrderLine['UnitCode']);  // Correction ici
                    $article->setUnitDescription($apiSalesOrderLine['UnitDescription']);
                    $article->setUnitPrice($apiSalesOrderLine['UnitPrice']);

                    $entityManager->persist($article);
                }

            }

        $entityManager->flush();

        return $this->redirectToRoute('display_articles');
    }

    /**
     * @Route("/display-articles", name="display_articles")
     */
    public function displayArticles(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();  // Remplacez cela par votre logique de récupération des articles

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }











}
