<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Character;
use App\Models\User;
use App\Models\Modifier;

class ModifiersTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test **/
    public function guests_cannot_manage_modifiers() {
        $character = Character::factory()->create();

        $modifier = Modifier::factory()->raw();
        $modifier['creature_id'] = $character->id;
        $modifier['creature_type'] = 'App\Models\Character';

        $this->post(route('modifiers.store'), $modifier)->assertRedirect('login');
    }

    /** @test **/
    public function a_user_can_add_a_modifier_to_their_characters() {
        $character = Character::factory()->create();
        $modifier = Modifier::factory()->raw(['creature_id' => $character->id, 'creature_type' => 'App\Models\Character']);

        $this->actingAs($character->user)
            ->post(route('modifiers.store'), $modifier);

        $this->assertDatabaseHas('modifiers', ['name' => $modifier['name']]);

        $this->assertCount(1, $character->modifiers);
    }

    /** @test **/
    public function a_user_can_update_their_characters_modifiers() {
        $this->withoutExceptionHandling();
        $character = Character::factory()->create();
        $modifier = Modifier::factory()->create(['creature_id' => $character->id, 'creature_type' => 'App\Models\Character']);
        $attributes = Modifier::factory()->raw(['creature_id' => $character->id, 'creature_type' => 'App\Models\Character']);

        $this->actingAs($character->user)
            ->patch(route('modifiers.update', $modifier), $attributes);

        $this->assertDatabaseHas('modifiers', ['name' => $attributes['name']]);
    }


    /** @test **/
    public function unathorized_users_cannot_delete_modifiers() {
        $character = Character::factory()->create();
        $modifier = Modifier::factory()->create(['creature_id' => $character->id, 'creature_type' => 'App\Models\Character']);

        $this->delete(route('modifiers.destroy', $modifier))
            ->assertRedirect(route('login'));

        $this->signIn();
        $this->delete(route('modifiers.destroy', $modifier))->assertStatus(403);
    }

    /** @test **/
    public function a_user_can_delete_their_characters_resource() {
        $character = Character::factory()->create();
        $modifier = Modifier::factory()->create(['creature_id' => $character->id, 'creature_type' => 'App\Models\Character']);

        $this->actingAs($character->user)
            ->delete(route('modifiers.destroy', $modifier));

        $this->assertDatabaseMissing('modifiers', $modifier->only('id'));
    }

    /** @test **/
    public function an_authenticated_user_cannot_add_modifiers_to_characters_of_others() {
        $this->signIn();

        $character = Character::factory()->create();
        $modifier = Modifier::factory()->raw(['creature_id' => $character->id, 'creature_type' => 'App\Models\Character']);
        $this->post(route('modifiers.store'), $modifier)
            ->assertStatus(403);
    }

    /** @test **/
    public function an_authenticated_user_cannot_update_modifiers_belonging_to_characters_of_others() {
        $this->signIn();

        $character = Character::factory()->create();
        $modifier = Modifier::factory()->create(['creature_id' => $character->id, 'creature_type' => 'App\Models\Character']);
        $attributes = Modifier::factory()->raw(['creature_id' => $character->id, 'creature_type' => 'App\Models\Character']);

        $this->patch(route('modifiers.update', $modifier), $attributes)
            ->assertStatus(403);
    }

    /** @test **/
    public function a_resource_is_deleted_with_its_creature() {
        $user = User::factory()->create();
        $character = Character::factory()->create();
        $modifier = Modifier::factory()->create(['creature_id' => $character->id, 'creature_type' => 'App\Models\Character']);

        $this->assertCount(1, Modifier::all());
        $character->delete();
        $this->assertCount(0, Modifier::all());
    }
}
