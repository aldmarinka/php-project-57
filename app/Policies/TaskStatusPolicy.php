<?php

namespace App\Policies;

use App\Models\TaskStatus;
use App\Models\User;

class TaskStatusPolicy
{
    public function view(User $user, TaskStatus $taskStatus): bool
    {
        return true; // Все пользователи могут просматривать статусы
    }

    public function create(User $user): bool
    {
        return true; // Любой аутентифицированный пользователь может создавать статусы
    }

    public function update(User $user): bool
    {
        return true; // Любой аутентифицированный пользователь может редактировать статусы
    }

    public function edit(User $user): bool
    {
        return true; // Любой аутентифицированный пользователь может редактировать статусы
    }

    public function delete(User $user, TaskStatus $taskStatus): bool
    {
        return true; // Любой аутентифицированный пользователь может удалять статусы
    }
}
