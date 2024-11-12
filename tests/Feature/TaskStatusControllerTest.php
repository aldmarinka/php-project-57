<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;
use App\Models\User;
use App\Models\TaskStatus;

class TaskStatusControllerTest extends TestCase
{
    private User $user;
    private TaskStatus $taskStatus;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->taskStatus = TaskStatus::factory()->create();
    }

    #[
        Group('TaskStatus'),
        Group('TaskStatus/Index'),
    ]
    public function testIndex(): void
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertOk();
    }

    #[
        Group('TaskStatus'),
        Group('TaskStatus/Create'),
    ]
    public function testCreate(): void
    {
        $this->actingAs($this->user);
        $response = $this->get(route('task_statuses.create'));
        $response->assertOk();
    }

    #[
        Group('TaskStatus'),
        Group('TaskStatus/Store'),
    ]
    public function testStore(): void
    {
        $this->actingAs($this->user);
        $body = TaskStatus::factory()->make()->only('name');
        $response = $this->post(route('task_statuses.store', $body));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('task_statuses', $body);
    }

    #[
        Group('TaskStatus'),
        Group('TaskStatus/Edit'),
    ]
    public function testEdit(): void
    {
        $this->actingAs($this->user);
        $response = $this->get(route('task_statuses.edit', ['task_status' => $this->taskStatus]));
        $response->assertOk();
    }


    #[
        Group('TaskStatus'),
        Group('TaskStatus/Update'),
    ]
    public function testUpdate(): void
    {
        $this->actingAs($this->user);
        $body = TaskStatus::factory()->make()->only('name');
        $response = $this->patch(route('task_statuses.update', ['task_status' => $this->taskStatus]), $body);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('task_statuses', [
            'id' => $this->taskStatus->id,
            'name' => $body['name']
        ]);
    }

    #[
        Group('TaskStatus'),
        Group('TaskStatus/Destroy'),
    ]
    public function testDestroy(): void
    {
        $this->actingAs($this->user);
        $this->assertDatabaseHas('task_statuses', ['id' => $this->taskStatus->id]);
        $response = $this->delete(route('task_statuses.destroy', ['task_status' => $this->taskStatus]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('task_statuses', ['id' => $this->taskStatus->id]);
    }

}
