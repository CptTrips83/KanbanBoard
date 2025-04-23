<?php

namespace App\Tools\api\builder;

use App\Entity\TaskComment;
use App\Entity\User;
use App\Tools\api\builder\abstract\AbstractBuilder;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Exception;

/**
 * Class TaskCommentBuilder
 *
 * This class is responsible for building TaskComment objects.
 */
class TaskCommentBuilder extends AbstractBuilder
{
    private ?TaskComment $_taskComment = null;
    private EntityRepository $_repository;

    /**
     * Class constructor.
     *
     * @param EntityManagerInterface $_entityManager The entity manager interface.
     */
    public function __construct(
        private EntityManagerInterface $_entityManager
    ) {
        $this->_repository = $this->_entityManager->getRepository(TaskComment::class);
    }


    /**
     * Initializes the TaskCommentBuilder with a specified ID or creates a new TaskComment instance.
     *
     * @param int|null $id The ID of the TaskComment to initialize with. Defaults to null.
     * @return TaskCommentBuilder Returns the initialized TaskCommentBuilder.
     */
    public function initialize(?int $id = null) : TaskCommentBuilder
    {
        if($id !== null) {
            $this->_taskComment = $this->_repository->find($id);
        }
        if($this->_taskComment === null) {
            $this->_taskComment = new TaskComment();
            $this->_isPersistent = false;
        }

        return $this;
    }

    /**
     * Sets the text of the TaskComment in the TaskCommentBuilder.
     *
     * @param string $text The text to set for the TaskComment.
     * @return TaskCommentBuilder Returns the TaskCommentBuilder with the updated TaskComment.
     */
    public function setText(string $text) : TaskCommentBuilder
    {
        $this->_taskComment->setText($text);

        return $this;
    }

    /**
     * Sets the author of the TaskComment.
     *
     * @param int $userId The ID of the User to set as the author of the TaskComment.
     * @return TaskCommentBuilder Returns the TaskCommentBuilder.
     */
    public function setAuthor(int $userId) : TaskCommentBuilder
    {
        $user = $this->_entityManager->getRepository(User::class)
            ->find($userId);

        if($user != null) {
            $this->_taskComment->setAuthor($user);
        }

        return $this;
    }

    /**
     * Sets the date of the TaskComment.
     *
     * @param string $date The date to set in string format.
     * @return TaskCommentBuilder Returns the task comment builder with the updated date.
     * @throws Exception
     */
    public function setDate(string $date) : TaskCommentBuilder
    {
        $this->_taskComment->setDate(new DateTime($date));

        return $this;
    }

    /**
     * Retrieves the result TaskComment.
     *
     * If the TaskComment is not persistent, persist it before returning.
     *
     * @return TaskComment Returns the result TaskComment.
     */
    public function build() : TaskComment
    {
        if(!$this->_isPersistent) {
            $this->_entityManager->persist($this->_taskComment);
            $this->_isPersistent = true;
        }

        return $this->_taskComment;
    }
}