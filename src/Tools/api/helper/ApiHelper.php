<?php

namespace App\Tools\api\helper;

use App\Entity\TaskComment;
use App\Entity\TaskEntry;

/**
 * Class ApiHelper
 *
 * Helper class for API operations.
 */
class ApiHelper
{
    /**
     * Convert a TaskEntry object to an array representation.
     *
     * @param TaskEntry $taskEntry The TaskEntry object to convert.
     * @return array The array representation of the TaskEntry object.
     */
    public static function convertToArray(TaskEntry $taskEntry) : array
    {
        $comments = array();

        foreach ($taskEntry->getTaskComments() as $comment) {
            $comments[] = [
                "id" => $comment->getId(),
                "text" => $comment->getText(),
                "authorId" => $comment->getAuthor()->getId(),
                "authorName" => $comment->getAuthor()->getUserIdentifier(),
                "date" => $comment->getDate()->format('Y-m-d H:i:s'),
                "synchron" => true,
            ];
        }

        return [
            "id" => $taskEntry->getId(),
            "title" => $taskEntry->getTitle(),
            "description" => $taskEntry->getDescription(),
            "status" => $taskEntry->getStatus(),
            "ownerId" => $taskEntry->getOwner()->getId(),
            "ownerName" => $taskEntry->getOwner()->getUserIdentifier(),
            "lastChange" => $taskEntry->getLastChange()->format('Y-m-d H:i:s'),
            "priority" => $taskEntry->getPriority(),
            "synchron" => true,
            "comments" => $comments,
        ];
    }

    /**
     * Converts a TaskEntry object to JSON format.
     *
     * @param TaskEntry $taskEntry The TaskEntry object to convert.
     * @return string The JSON-encoded TaskEntry.
     */
    public static function convertToJson(TaskEntry $taskEntry) : string
    {
        return json_encode(self::convertToArray($taskEntry));
    }

    public static function convertFromJson(string $json) : array
    {
        return json_decode($json, true);
    }
}