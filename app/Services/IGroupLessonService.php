<?php


namespace App\Services;


interface IGroupLessonService
{
    public function attachLesson(int $groupId, int $lessonId): bool;

    public function attachGroup(int $lessonId, int $groupId): bool;

    public function detachLesson(int $groupId, int $lessonId): bool;

    public function detachGroup(int $lessonId, int $groupId): bool;
}