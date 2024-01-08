<?php

namespace App\Controller;

use App\Entity\Contacte;
use App\Repository\ContacteRepository;
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
use App\Entity\LigneCommande;

class ApiIntegrationController extends AbstractController
{

    ///////////////////////////////////////////Commande/////////////////////////////////////////////////
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




///////////////////////////////Articles///////////////////////////////////////

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
                    $article->setUnitCode($apiSalesOrderLine['UnitCode']);
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


/////////////////////////////////////Contacts////////////////////////////////////








    /**
     * @Route("/fetch-and-store-contacts", name="fetch_and_store_contacts")
     */
    public function fetchAndStoreContacts(HttpClientInterface $httpClient, EntityManagerInterface $entityManager): Response
    {
        $headers = [
            'headers' => [
                'x-api-key' => 'PMAK-62642462da39cd50e9ab4ea7-815e244f4fdea2d2075d8966cac3b7f10b',
            ],
        ];

        $response = $httpClient->request('GET', 'https://internshipapi-pylfsebcoa-ew.a.run.app/contacts', $headers);
        $data = $response->toArray();

        foreach ($data['results'] as $apiContact) {
            $contact = new Contacte();
            $contact->setAccountName($apiContact['AccountName']);
            $contact->setAddressLine1($apiContact['AddressLine1']);
            $contact->setAddressLine2($apiContact['AddressLine2']);
            $contact->setCity($apiContact['City']);
            $contact->setContactName($apiContact['ContactName']);
            $contact->setCountry($apiContact['Country']);
            $contact->setZipCode($apiContact['ZipCode']);

            $entityManager->persist($contact);
        }

        $entityManager->flush();

        return $this->redirectToRoute('display_contacts');
    }

    /**
     * @Route("/display-contacts", name="display_contacts")
     */
    public function displayContacts(ContacteRepository $contactRepository): Response
    {
        $contacts = $contactRepository->findAll();

        return $this->render('contact/index.html.twig', [
            'contacts' => $contacts,
        ]);
    }




////////////////////////////////////lignes commandes/////////////////////////////


    /**
     * @Route("/fetch-and-store-lignes-commande", name="fetch_and_store_lignes_commande")
     */
    public function fetchAndStoreLignesCommande(HttpClientInterface $httpClient, EntityManagerInterface $entityManager): Response
    {
        $headers = [
            'headers' => [
                'x-api-key' => 'PMAK-62642462da39cd50e9ab4ea7-815e244f4fdea2d2075d8966cac3b7f10b',
            ],
        ];

        $response = $httpClient->request('GET', 'https://internshipapi-pylfsebcoa-ew.a.run.app/orders', $headers);
        $data = $response->toArray();

        foreach ($data['results'] as $apiCommande) {
            // Récupérer la commande correspondante depuis la base de données
            $commande = $entityManager->getRepository(Commande::class)->findOneBy(['OrderID' => $apiCommande['OrderID']]);

            foreach ($apiCommande['SalesOrderLines']['results'] as $apiSalesOrderLine) {
                // Créer une nouvelle entité LigneCommande
                $ligneCommande = new LigneCommande();

                // Associer la ligne de commande à la commande
                $ligneCommande->setCommande($commande);

                // Récupérer l'article correspondant depuis la base de données
                $article = $entityManager->getRepository(Article::class)->findOneBy(['item' => $apiSalesOrderLine['Item']]);

                // Si l'article n'existe pas, vous pouvez le créer ici

                // Associer la ligne de commande à l'article
                $ligneCommande->setArticle($article);

                // Définir les autres attributs de la ligne de commande
                $ligneCommande->setAmount($apiSalesOrderLine['Amount']);
                $ligneCommande->setQuantite($apiSalesOrderLine['Quantity']);

                // Persist the LigneCommande entity
                $entityManager->persist($ligneCommande);
            }
        }

        // Flush changes to the database
        $entityManager->flush();

        // Exemple d'affichage dans la console
        dump('Lignes de commande enregistrées avec succès.');

        // Ou renvoyer une réponse JSON
        return new JsonResponse(['message' => 'Lignes de commande enregistrées avec succès.']);
    }












}
