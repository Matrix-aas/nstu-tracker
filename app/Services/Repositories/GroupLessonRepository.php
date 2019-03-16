<?php

namespace App\Services\Repositories;

use App\Models\Group;
use App\Models\Lesson;

class GroupLessonRepository implements IGroupLessonRepository
{
    public function attachLesson(int $groupId, int $lessonId): bool
    {
        /** @var Group $group */
        $group = Group::query()->find($groupId);
        if (!$group)
            return false;
        try {
            $group->lessons()->attach($lessonId);
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }

    public function attachGroup(int $lessonId, int $groupId): bool
    {
        /** @var Lesson $lesson */
        $lesson = Lesson::query()->find($lessonId);
        if (!$lesson)
            return false;
        try {
            $lesson->groups()->attach($groupId);
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }

    public function detachLesson(int $groupId, int $lessonId): bool
    {
        /** @var Group $group */
        $group = Group::query()->find($groupId);
        if (!$group)
            return false;
        try {
            $group->lessons()->detach($lessonId);
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }

    public function detachGroup(int $lessonId, int $groupId): bool
    {
        /** @var Lesson $lesson */
        $lesson = Lesson::query()->find($lessonId);
        if (!$lesson)
            return false;
        try {
            $lesson->groups()->detach($groupId);
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }
}