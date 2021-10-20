<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Character;
use App\Models\User;
use App\Models\Action;

class ActionsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test **/
    public function guests_cannot_manage_actions() {
        $character = Character::factory()->create();

        $action = Action::factory()->raw();
        $action['creature_id'] = $character->id;
        $action['creature_type'] = 'App\Models\Character';

        $this->post(route('actions.store'), $action)->assertRedirect('login');
    }

    /** @test **/
    public function a_user_can_add_a_action_to_their_characters() {
        $character = Character::factory()->create();
        $action = Action::factory()->raw(['creature_id' => $character->id, 'creature_type' => 'App\Models\Character']);

        $this->actingAs($character->user)
            ->post(route('actions.store'), $action);

        $this->assertDatabaseHas('actions', ['name' => $action['name']]);

        $this->assertCount(1, $character->actions);
    }

    /** @test **/
    public function a_user_can_update_their_characters_actions() {
        $character = Character::factory()->create();
        $action = Action::factory()->create(['creature_id' => $character->id, 'creature_type' => 'App\Models\Character']);
        $attributes = Action::factory()->raw(['creature_id' => $character->id, 'creature_type' => 'App\Models\Character']);

        $this->actingAs($character->user)
            ->patch(route('actions.update', $action), $attributes);

        $this->assertDatabaseHas('actions', ['name' => $attributes['name']]);
    }


    /** @test **/
    public function unathorized_users_cannot_delete_actions() {
        $character = Character::factory()->create();
        $action = Action::factory()->create(['creature_id' => $character->id, 'creature_type' => 'App\Models\Character']);

        $this->delete(route('actions.destroy', $action))
            ->assertRedirect(route('login'));

        $this->signIn();
        $this->delete(route('actions.destroy', $action))->assertStatus(403);
    }

    /** @test **/
    public function a_user_can_delete_their_characters_resource() {
        $character = Character::factory()->create();
        $action = Action::factory()->create(['creature_id' => $character->id, 'creature_type' => 'App\Models\Character']);

        $this->actingAs($character->user)
            ->delete(route('actions.destroy', $action));

        $this->assertDatabaseMissing('actions', $action->only('id'));
    }

    /** @test **/
    public function an_authenticated_user_cannot_add_actions_to_characters_of_others() {
        $this->signIn();

        $character = Character::factory()->create();
        $action = Action::factory()->raw(['creature_id' => $character->id, 'creature_type' => 'App\Models\Character']);
        $this->post(route('actions.store'), $action)
            ->assertStatus(403);
    }

    /** @test **/
    public function an_authenticated_user_cannot_update_actions_belonging_to_characters_of_others() {
        $this->signIn();

        $character = Character::factory()->create();
        $action = Action::factory()->create(['creature_id' => $character->id, 'creature_type' => 'App\Models\Character']);
        $attributes = Action::factory()->raw(['creature_id' => $character->id, 'creature_type' => 'App\Models\Character']);

        $this->patch(route('actions.update', $action), $attributes)
            ->assertStatus(403);
    }

    /** @test **/
    public function a_resource_is_deleted_with_its_creature() {
        $user = User::factory()->create();
        $character = Character::factory()->create();
        $action = Action::factory()->create(['creature_id' => $character->id, 'creature_type' => 'App\Models\Character']);

        $this->assertCount(1, Action::all());
        $character->delete();
        $this->assertCount(0, Action::all());
    }
}
