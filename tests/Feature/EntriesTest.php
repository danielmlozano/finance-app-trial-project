<?php

namespace Tests\Feature;

use App\Models\Entry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EntriesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that an entry can be created
     *
     * @return void
     */
    public function testEntriesCanBeCreated()
    {
        $this->actingAs(User::factory()->create(), 'sanctum');

        $entry = Entry::factory()->make()->toArray();

        $response = $this->postJson('/api/entries', $entry);

        $response->assertStatus(201);
        $this->assertDatabaseHas('entries', $entry);
    }

    public function testEntriesCanBeUpdatedByOwner()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum');

        $entry = Entry::factory()->for($user)->create();

        $data = [
            'label' => 'Groceries',
            'amount' => 10.0,
            'date' => date('Y-m-d'),
        ];

        $response = $this->putJson("/api/entries/{$entry->id}", $data);

        $entry->refresh();

        $response->assertStatus(200);
        $this->assertEquals('Groceries', $entry->label);
    }

    public function testEntriesCannotBeUpdatedByOtherUser()
    {
        $users = User::factory()->count(2)->create();

        $owner = $users->first();
        $other_user = $users->last();

        $entry = Entry::factory()->for($owner)->create(['label' => 'Gas']);

        $data = [
            'label' => 'Groceries',
            'amount' => 10.0,
            'date' => date('Y-m-d'),
        ];

        $response = $this->actingAs($other_user, 'sanctum')->putJson("/api/entries/{$entry->id}", $data);

        $response->assertStatus(403);
        $this->assertEquals('Gas', $entry->label);
    }

    public function testEntriesCanBeDeleted()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum');

        $entry = Entry::factory()->for($user)->create();

        $response = $this->deleteJson("/api/entries/{$entry->id}");

        $response->assertStatus(204);

        $this->assertDatabaseCount('entries', 0);
    }

    public function testEntriesCannotBeDeletedByOtherUser()
    {
        $users = User::factory()->count(2)->create();

        $owner = $users->first();
        $other_user = $users->last();

        $entry = Entry::factory()->for($owner)->create(['label' => 'Gas']);

        $response = $this->actingAs($other_user, 'sanctum')->deleteJson("/api/entries/{$entry->id}");
        $response->assertStatus(403);

        $this->assertDatabaseCount('entries', 1);
    }
}
