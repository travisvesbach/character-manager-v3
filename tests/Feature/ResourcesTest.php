<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Character;
use App\Models\User;
use App\Models\Resource;
// use Facades\Tests\Setup\CreatureFactory;

class ResourcesTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test **/
    public function guests_cannot_manage_resources() {
        $character = Character::factory()->create();

        $resource = Resource::factory()->raw();
        $resource['creature_id'] = $character->id;
        $resource['creature_type'] = 'App\Models\Character';

        $this->post(route('resources.store'), $resource)->assertRedirect('login');
    }

    /** @test **/
    public function a_user_can_add_a_resource_to_their_characters() {
        $character = Character::factory()->create();
        $resource = Resource::factory()->raw(['creature_id' => $character->id, 'creature_type' => 'App\Models\Character']);

        $response = $this->actingAs($character->user)
            ->post(route('resources.store'), $resource);

        $this->assertDatabaseHas('resources', ['name' => $resource['name']]);
        $this->assertCount(1, $character->resources);
    }

    /** @test **/
    public function a_user_can_update_their_characters_resources() {
        $character = Character::factory()->create();
        $resource = Resource::factory()->create(['creature_id' => $character->id, 'creature_type' => 'App\Models\Character']);
        $attributes = Resource::factory()->raw(['creature_id' => $character->id, 'creature_type' => 'App\Models\Character']);

        $this->actingAs($character->user)
            ->patch(route('resources.update', $resource), $attributes);

        $this->assertDatabaseHas('resources', ['name' => $attributes['name']]);
    }


    /** @test **/
    public function unathorized_users_cannot_delete_resources() {
        $character = Character::factory()->create();
        $resource = Resource::factory()->create(['creature_id' => $character->id, 'creature_type' => 'App\Models\Character']);

        $this->delete(route('resources.destroy', $resource))
            ->assertRedirect(route('login'));

        $this->signIn();
        $this->delete(route('resources.destroy', $resource))->assertStatus(403);
    }

    /** @test **/
    public function a_user_can_delete_their_characters_resource() {
        $character = Character::factory()->create();
        $resource = Resource::factory()->create(['creature_id' => $character->id, 'creature_type' => 'App\Models\Character']);

        $this->actingAs($character->user)
            ->delete(route('resources.destroy', $resource));

        $this->assertDatabaseMissing('resources', $resource->only('id'));
    }

    /** @test **/
    public function an_authenticated_user_cannot_add_resources_to_characters_of_others() {
        $this->signIn();

        $character = Character::factory()->create();
        $resource = Resource::factory()->raw(['creature_id' => $character->id, 'creature_type' => 'App\Models\Character']);
        $this->post(route('resources.store'), $resource)
            ->assertStatus(403);
    }

    /** @test **/
    public function an_authenticated_user_cannot_update_resources_belonging_to_characters_of_others() {
        $this->signIn();

        $character = Character::factory()->create();
        $resource = Resource::factory()->create(['creature_id' => $character->id, 'creature_type' => 'App\Models\Character']);
        $attributes = Resource::factory()->raw(['creature_id' => $character->id, 'creature_type' => 'App\Models\Character']);

        $this->patch(route('resources.update', $resource), $attributes)
            ->assertStatus(403);
    }

    /** @test **/
    public function a_resource_is_deleted_with_its_creature() {
        $user = User::factory()->create();
        $character = Character::factory()->create();
        $resource = Resource::factory()->create(['creature_id' => $character->id, 'creature_type' => 'App\Models\Character']);

        $this->assertCount(1, Resource::all());
        $character->delete();
        $this->assertCount(0, Resource::all());
    }
}
