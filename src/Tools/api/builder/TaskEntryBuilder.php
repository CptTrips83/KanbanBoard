<?php

namespace App\Tools\api\builder;

use App\Entity\TaskComment;
use App\Entity\TaskEntry;
use App\Entity\User;
use App\Tools\api\builder\abstract\AbstractBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class TaskEntryBuilder extends AbstractBuilder
{
    private ?TaskEntry $_taskEntry = null;
    private EntityRepository $_repository;

    public function __construct(
        private EntityManagerInterface $_entityManager
    ) {
        $this->_repository = $this->_entityManager->getRepository(TaskEntry::class);
    }

    public function initialize(?int $id = null) : TaskEntryBuilder
    {
        if($id !== null) {
            $this->_taskEntry = $this->_repository->find($id);
        }
        if($this->_taskEntry === null) {
            $this->_taskEntry = new TaskEntry();
            $this->_isPersistent = false;
        }

        return $this;
    }

    public function setTitle(string $title) : TaskEntryBuilder
    {
        $this->_taskEntry->setTitle($title);
        return $this;
    }

    public function setDescription(string $description) : TaskEntryBuilder
    {
        $this->_taskEntry->setDescription($description);
        return $this;
    }

    public function setStatus(string $status) : TaskEntryBuilder
    {
        $this->_taskEntry->setStatus($status);
        return $this;
    }

    public function setPriority(int $priority) : TaskEntryBuilder
    {
        $this->_taskEntry->setPriority($priority);
        return $this;
    }

    public function setOwner(int $userId) : TaskEntryBuilder
    {
        $user = $this->_entityManager->getRepository(User::class)
            ->find($userId);

        if($user != null) {
            $this->_taskEntry->setOwner($user);
        }

        return $this;
    }

    public function setLastChange(string $date) : TaskEntryBuilder
    {
        $this->_taskEntry->setLastChange(new \DateTime($date));
        return $this;
    }

    public function addComment(TaskComment $comment) : TaskEntryBuilder
    {
        $this->_taskEntry->addTaskComment($comment);
        return $this;
    }

    public function build(): TaskEntry
    {
        if(!$this->_isPersistent) {
            $this->_entityManager->persist($this->_taskEntry);
            $this->_isPersistent = true;
        }

        return $this->_taskEntry;
    }
}