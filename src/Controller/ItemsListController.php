<?php

namespace App\Controller;

use App\Entity\Items;
use App\Repository\ItemsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemsListController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/{id?0}', name: 'app_items_list')]
    public function index(int $id): Response
    {
        /** @var ItemsRepository $itemRepository */
        $itemRepository = $this->entityManager->getRepository(Items::class);
        $items = $itemRepository->findWithPaging($id ?: 0);

        $lastItemId = $items[array_key_last($items)]->getId();

        return $this->render('items_list/index.html.twig', [
            'id' => $id,
            'last_id' => $lastItemId,
            'items' => $items,
        ]);
    }
}
