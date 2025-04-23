<?php

namespace api;

use App\Entity\TaskComment;
use App\Entity\TaskEntry;
use App\Entity\User;
use App\Tools\AbstractKernelTestCase;
use App\Tools\api\builder\TaskCommentBuilder;
use App\Tools\api\builder\TaskEntryBuilder;
use App\Tools\api\helper\ApiHelper;
use DateTime;

class ApiTest extends AbstractKernelTestCase
{

    private User $userComment1;
    private User $userComment2;
    private User $userTask;

    private TaskEntry $taskEntry;

    private function createUser() : void
    {
        $this->userComment1 = new User();
        $this->userComment2 = new User();
        $this->userTask = new User();

        $this->userComment1->setUsername("Test1");
        $this->userComment1->setPassword("Test1");

        $this->userComment2->setUsername("Test2");
        $this->userComment2->setPassword("Test2");

        $this->userTask->setUsername("Test3");
        $this->userTask->setPassword("Test3");

        $this->entityManager->persist($this->userComment1);
        $this->entityManager->persist($this->userComment2);
        $this->entityManager->persist($this->userTask);

        $this->entityManager->flush();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->createUser();

        $dateTimeComment1 = new DateTime();
        $dateTimeComment2 = new DateTime("2024-06-12 05:00:00");
        $dateTimeTask = new DateTime("2024-06-11 05:00:00");

        $taskComment1 = new TaskComment();
        $taskComment2 = new TaskComment();

        $taskComment1->setText("Test1");
        $taskComment2->setText("Test2");
        $taskComment1->setDate($dateTimeComment1);
        $taskComment2->setDate($dateTimeComment2);
        $taskComment1->setAuthor($this->userComment1);
        $taskComment2->setAuthor($this->userComment2);

        $this->entityManager->persist($taskComment1);
        $this->entityManager->persist($taskComment2);

        $this->taskEntry = new TaskEntry();
        $this->taskEntry->setTitle("Test3");
        $this->taskEntry->setDescription("Test");
        $this->taskEntry->setOwner($this->userTask);
        $this->taskEntry->setLastChange($dateTimeTask);
        $this->taskEntry->setPriority(0);
        $this->taskEntry->setStatus(0);

        $this->taskEntry->addTaskComment($taskComment1);
        $this->taskEntry->addTaskComment($taskComment2);

        $this->entityManager->persist($this->taskEntry);
        $this->entityManager->flush();
    }

    public function testHelperCreateArrayFromTaskEntry() : void
    {
        $array = ApiHelper::convertToArray($this->taskEntry);

        $this->assertIsArray($array);
        $this->assertIsArray($array["comments"]);

        // Check Content TaskEntry
        $this->assertEquals($this->taskEntry->getId(), $array["id"]);
        $this->assertEquals($this->taskEntry->getTitle(), $array["title"]);
        $this->assertEquals($this->taskEntry->getDescription(), $array["description"]);
        $this->assertEquals($this->taskEntry->getLastChange()->format("Y-m-d H:i:s"), $array["lastChange"]);
        $this->assertEquals($this->taskEntry->getPriority(), $array["priority"]);
        $this->assertEquals($this->taskEntry->getStatus(), $array["status"]);
        $this->assertEquals($this->taskEntry->getOwner()->getId(), $array["ownerId"]);
        $this->assertEquals($this->taskEntry->getOwner()->getUserIdentifier(), $array["ownerName"]);
        $this->assertTrue($array["synchron"]);

        // Check Content TaskComments
        for ($i = 0; $i < count($array["comments"]); $i++) {
            $comment = $array["comments"][$i];
            /** @var TaskComment $expectedComment */
            $expectedComment = $this->taskEntry->getTaskComments()[$i];

            $this->assertEquals($expectedComment->getId(), $comment["id"]);
            $this->assertEquals($expectedComment->getText(), $comment["text"]);
            $this->assertEquals($expectedComment->getAuthor()->getId(), $comment["authorId"]);
            $this->assertEquals($expectedComment->getAuthor()->getUserIdentifier(), $comment["authorName"]);
            $this->assertEquals($expectedComment->getDate()->format("Y-m-d H:i:s"), $comment["date"]);
            $this->assertTrue($comment["synchron"]);
        }
    }

    public function testHelperCreateJSONFromTaskEntry() : void
    {
        $json = ApiHelper::convertToJSON($this->taskEntry);
        $this->assertJson($json);
    }

    public function testBuilderTaskCommentNew() : void
    {
        $builder = new TaskCommentBuilder($this->entityManager);

        $taskComment = $builder->initialize()
            ->setText($this->taskEntry->getTaskComments()[0]->getText())
            ->setAuthor($this->userComment1->getId())
            ->setDate($this->taskEntry->getTaskComments()[0]->getDate()->format("Y-m-d H:i:s"))
            ->build();

        $this->assertInstanceOf(TaskComment::class, $taskComment);
        $this->assertEquals($this->taskEntry->getTaskComments()[0]->getText(), $taskComment->getText());
        $this->assertEquals($this->taskEntry->getTaskComments()[0]->getAuthor(), $taskComment->getAuthor());
        $this->assertEquals(
            $this->taskEntry->getTaskComments()[0]->getDate()->format("Y-m-d H:i:s"),
            $taskComment->getDate()->format("Y-m-d H:i:s")
        );
    }

    public function testBuilderTaskCommentExisting() : void
    {
        $builder = new TaskCommentBuilder($this->entityManager);

        /** @var TaskComment $expectedComment */
        $expectedComment = $this->taskEntry->getTaskComments()[0];

        $taskComment = $builder->initialize($expectedComment->getId())
            ->build();

        $this->assertEquals($expectedComment->getText(), $taskComment->getText());
        $this->assertEquals($expectedComment->getAuthor(), $taskComment->getAuthor());
        $this->assertEquals(
            $expectedComment->getDate()->format("Y-m-d H:i:s"),
            $taskComment->getDate()->format("Y-m-d H:i:s")
        );
    }

    public function testBuilderTaskCommentExistingAndChange() : void
    {
        $builder = new TaskCommentBuilder($this->entityManager);

        $expectedText = "TestChange";
        $expectedDate = new DateTime("2024-06-17 00:00:00");
        $expectedUser = $this->userComment2;

        /** @var TaskComment $expectedComment */
        $expectedComment = $this->taskEntry->getTaskComments()[0];

        $taskComment = $builder->initialize($expectedComment->getId())
            ->setAuthor($expectedUser->getId())
            ->setText($expectedText)
            ->setDate($expectedDate->format("Y-m-d H:i:s"))
            ->build();

        $this->assertEquals($expectedText, $taskComment->getText());
        $this->assertEquals($expectedUser, $taskComment->getAuthor());
        $this->assertEquals(
            $expectedDate->format("Y-m-d H:i:s"),
            $taskComment->getDate()->format("Y-m-d H:i:s")
        );
    }

    public function testBuilderTaskEntryNewWithoutComments() : void
    {
        $builder = new TaskEntryBuilder($this->entityManager);

        $taskEntry = $builder->initialize()
            ->setTitle($this->taskEntry->getTitle())
            ->setDescription($this->taskEntry->getDescription())
            ->setOwner($this->taskEntry->getOwner()->getId())
            ->setPriority($this->taskEntry->getPriority())
            ->setStatus($this->taskEntry->getStatus())
            ->setLastChange($this->taskEntry->getLastChange()->format("Y-m-d H:i:s"))
            ->build();

        $this->assertInstanceOf(TaskEntry::class, $taskEntry);
        $this->assertEquals($this->taskEntry->getTitle(), $taskEntry->getTitle());
        $this->assertEquals($this->taskEntry->getDescription(), $taskEntry->getDescription());
        $this->assertEquals($this->taskEntry->getOwner(), $taskEntry->getOwner());
        $this->assertEquals($this->taskEntry->getPriority(), $taskEntry->getPriority());
        $this->assertEquals($this->taskEntry->getStatus(), $taskEntry->getStatus());
        $this->assertEquals(
            $this->taskEntry->getLastChange()->format("Y-m-d H:i:s"),
            $taskEntry->getLastChange()->format("Y-m-d H:i:s")
        );
    }

    public function testBuilderTaskEntryNewWithComments() : void
    {
        $builder = new TaskEntryBuilder($this->entityManager);

        $taskEntry = $builder->initialize()
            ->setTitle($this->taskEntry->getTitle())
            ->setDescription($this->taskEntry->getDescription())
            ->setOwner($this->taskEntry->getOwner()->getId())
            ->setPriority($this->taskEntry->getPriority())
            ->setStatus($this->taskEntry->getStatus())
            ->setLastChange($this->taskEntry->getLastChange()->format("Y-m-d H:i:s"))
            ->addComment($this->taskEntry->getTaskComments()[0])
            ->build();

        $this->assertInstanceOf(TaskEntry::class, $taskEntry);
        $this->assertEquals($this->taskEntry->getTitle(), $taskEntry->getTitle());
        $this->assertEquals($this->taskEntry->getDescription(), $taskEntry->getDescription());
        $this->assertEquals($this->taskEntry->getOwner(), $taskEntry->getOwner());
        $this->assertEquals($this->taskEntry->getPriority(), $taskEntry->getPriority());
        $this->assertEquals($this->taskEntry->getStatus(), $taskEntry->getStatus());
        $this->assertEquals($this->taskEntry->getTaskComments()[0], $taskEntry->getTaskComments()[0]);
        $this->assertEquals(
            $this->taskEntry->getLastChange()->format("Y-m-d H:i:s"),
            $taskEntry->getLastChange()->format("Y-m-d H:i:s")
        );
    }

    public function testBuilderTaskEntryExisting() : void
    {
        $builder = new TaskEntryBuilder($this->entityManager);

        $expectedEntry = $this->taskEntry;

        $taskEntry = $builder->initialize($expectedEntry->getId())
            ->build();

        $this->assertEquals($expectedEntry->getTitle(), $taskEntry->getTitle());
        $this->assertEquals($expectedEntry->getDescription(), $taskEntry->getDescription());
        $this->assertEquals($this->taskEntry->getOwner(), $taskEntry->getOwner());
        $this->assertEquals($this->taskEntry->getPriority(), $taskEntry->getPriority());
        $this->assertEquals($this->taskEntry->getStatus(), $taskEntry->getStatus());
        $this->assertEquals(
            $expectedEntry->getLastChange()->format("Y-m-d H:i:s"),
            $taskEntry->getLastChange()->format("Y-m-d H:i:s")
        );
    }

    public function testBuilderTaskEntryExistingChanges() : void
    {
        $builder = new TaskEntryBuilder($this->entityManager);

        $expectedEntry = $this->taskEntry;

        $expectedTitle = "TestChange";
        $expectedDate = new DateTime("2024-06-17 00:00:00");
        $expectedUser = $this->userComment2;

        $taskEntry = $builder->initialize($expectedEntry->getId())
            ->setTitle($expectedTitle)
            ->setDescription($expectedDate->format("Y-m-d H:i:s"))
            ->setOwner($expectedUser->getId())
            ->setLastChange($expectedDate->format("Y-m-d H:i:s"))
            ->build();

        $this->assertEquals($expectedTitle, $taskEntry->getTitle());
        $this->assertEquals($expectedEntry->getDescription(), $taskEntry->getDescription());
        $this->assertEquals($expectedUser, $taskEntry->getOwner());
        $this->assertEquals($this->taskEntry->getPriority(), $taskEntry->getPriority());
        $this->assertEquals($this->taskEntry->getStatus(), $taskEntry->getStatus());
        $this->assertEquals(
            $expectedDate->format("Y-m-d H:i:s"),
            $taskEntry->getLastChange()->format("Y-m-d H:i:s")
        );
    }
}