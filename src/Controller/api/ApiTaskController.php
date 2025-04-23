<?php

namespace App\Controller\api;

use App\Entity\TaskEntry;
use App\Tools\api\builder\TaskCommentBuilder;
use App\Tools\api\builder\TaskEntryBuilder;
use App\Tools\api\helper\ApiHelper;
use App\Traits\ValidationTrait;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ApiTaskController extends AbstractController
{
    use ValidationTrait;

    #[Route('/api/taskEntry/save', name: 'app_api_taskEntry_save', methods: ['POST'])]
    public function save(
        Request $request,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger,
        UserInterface $user = null,
    ): Response {
        if (!$this->validateRequest($request, "POST", $user)) {
            return new Response("", Response::HTTP_BAD_REQUEST);
        }

        $taskEntryBuilder = new TaskEntryBuilder($entityManager);
        $taskCommentBuilder = new TaskCommentBuilder($entityManager);


        $data = ApiHelper::convertFromJson($request->getContent());
        try {
            foreach ($data as $taskData) {
                try {
                    $entityManager->beginTransaction();

                    $taskEntry = $taskEntryBuilder->initialize($taskData["id"])
                        ->setTitle($taskData["title"])
                        ->setDescription($taskData["description"])
                        ->setStatus($taskData["status"])
                        ->setOwner($taskData["ownerId"])
                        ->setLastChange($taskData["lastChange"])
                        ->setPriority($taskData["priority"])
                        ->build();

                    foreach ($taskData["comments"] as $commentData) {
                        $taskComment = $taskCommentBuilder->initialize($commentData["id"])
                            ->setText($commentData["text"])
                            ->setDate($commentData["date"])
                            ->setAuthor($commentData["authorId"])
                            ->build();

                        $taskEntry->addTaskComment($taskComment);
                    }
                    $entityManager->commit();

                } catch (\Exception $e) {
                    $logger->error($e->getMessage());
                    $entityManager->rollback();
                }
                $entityManager->flush();
                $entityManager->clear();
            }
        } catch (\Exception $e) {
            $logger->error($e->getMessage().$data["ownerId"]);
            return new Response("", Response::HTTP_BAD_REQUEST);
        }
        return new Response("", Response::HTTP_OK);
    }

    #[Route('/api/taskEntry/load', name: 'app_api_taskEntry_load', methods: ['GET'])]
    public function load(
        Request $request,
        EntityManagerInterface $entityManager,
        UserInterface $user = null
    ): Response
    {
        if(!$this->validateRequest($request, "GET", $user)) {
            return new Response("", Response::HTTP_BAD_REQUEST);
        }

        $jsonResult = [];

        $taskRepo = $entityManager->getRepository(TaskEntry::class);

        $taskEntries = $taskRepo->findAll();

        foreach ($taskEntries as $taskEntry) {
            $jsonResult[] = ApiHelper::convertToArray($taskEntry);
        }

        return new JsonResponse($jsonResult, Response::HTTP_OK);
    }
}
