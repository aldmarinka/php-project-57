<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;
use App\Models\User;
use App\Models\Label;

class LabelControllerTest extends TestCase
{
    private User $user;
    private Label $label;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->label = Label::factory()->create();
    }

    #[
        Group('Label'),
        Group('Label/Index'),
    ]
    public function testIndex(): void
    {
        $response = $this->get(route('labels.index'));
        $response->assertOk();
    }

    #[
        Group('Label'),
        Group('Label/Create'),
    ]
    public function testCreate(): void
    {
        $this->actingAs($this->user);
        $response = $this->get(route('labels.create'));
        $response->assertOk();
    }

    #[
        Group('Label'),
        Group('Label/Store'),
    ]
    public function testStore(): void
    {
        $this->actingAs($this->user);
        $body = Label::factory()->make()->only('name');
        $response = $this->post(route('labels.store', $body));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('labels', $body);
    }

    #[
        Group('Label'),
        Group('Label/Edit'),
    ]
    public function testEdit(): void
    {
        $this->actingAs($this->user);
        $response = $this->get(route('labels.edit', ['label' => $this->label]));
        $response->assertOk();
    }

    #[
        Group('Label'),
        Group('Label/Update'),
    ]
    public function testUpdate(): void
    {
        $this->actingAs($this->user);
        $body = Label::factory()->make()->only('name');
        $response = $this->patch(route('labels.update', ['label' => $this->label]), $body);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('labels', [
            'id' => $this->label->id,
            'name' => $body['name']
        ]);
    }

    #[
        Group('Label'),
        Group('Label/Destroy'),
    ]
    public function testDestroy(): void
    {
        $this->actingAs($this->user);
        $response = $this->delete(route('labels.destroy', ['label' => $this->label]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('labels', ['id' => $this->label->id]);
    }
}
