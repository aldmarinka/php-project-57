<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;

class TaskControllerTest extends TestCase
{
    private User $user;
    private Task $task;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->task = Task::factory()->create();
    }

    #[
        Group('Task'),
        Group('Task/Index'),
    ]
    public function testIndex(): void
    {
        $response = $this->get(route('tasks.index'));
        $response->assertOk();
    }

    #[
        Group('Task'),
        Group('Task/Create'),
    ]
    public function testCreate(): void
    {
        $this->actingAs($this->user);
        $response = $this->get(route('tasks.create'));
        $response->assertOk();
    }

    #[
        Group('Task'),
        Group('Task/Store'),
    ]
    public function testStore(): void
    {
        $this->actingAs($this->user);
        $body = Task::factory()->make()->only('name', 'status_id');
        $response = $this->post(route('tasks.store', $body));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', $body);
    }

    #[
        Group('Task'),
        Group('Task/Show'),
    ]
    public function testShow(): void
    {
        $response = $this->get(route('tasks.show', ['id' => $this->task->id]));
        $response->assertOk();
    }

    #[
        Group('Task'),
        Group('Task/Edit'),
    ]
    public function testEdit(): void
    {
        $this->actingAs($this->user);
        $response = $this->get(route('tasks.edit', ['task' => $this->task]));
        $response->assertOk();
    }

    #[
        Group('Task'),
        Group('Task/Update'),
    ]
    public function testUpdate(): void
    {
        $this->actingAs($this->user);
        $body = Task::factory()->make()->only('name', 'status_id');
        $response = $this->patch(route('tasks.update', ['task' => $this->task]), $body);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', [
            'id' => $this->task->id,
            'name' => $body['name'],
            'status_id' => $body['status_id']
        ]);
    }

    #[
        Group('Task'),
        Group('Task/Destroy'),
    ]
    public function testDestroy(): void
    {
        $this->actingAs($this->user);
        $this->assertDatabaseHas('tasks', ['id' => $this->task->id]);
        $response = $this->delete(route('tasks.destroy', ['task' => $this->task]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('tasks', ['id' => $this->task->id]);
    }
}
