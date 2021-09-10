<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Character;
use App\Models\User;
// use Facades\Tests\Setup\CreatureFactory;

class CharactersTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test **/
    public function guests_cannot_manage_characters() {
        $character = Character::factory()->create();

        $this->get(route('characters.index'))->assertRedirect('login');
        $this->get(route('characters.create'))->assertRedirect('login');
        $this->get(route('characters.show', $character->id))->assertRedirect('login');
        $this->post(route('characters.store'), $character->toArray())->assertRedirect('login');
    }

    /** @test **/
    public function a_user_can_create_a_character() {
        $this->signIn();

        $this->get(route('characters.create'))->assertStatus(200);

        $attributes = Character::factory()->raw();

        $attributes['user_id'] = auth()->user()->id;

        $response = $this->post(route('characters.store'), $attributes);

        $character = Character::where('name', $attributes['name'])->first();

        $response->assertRedirect($character->path());

        $this->get($character->path())
            ->assertSee($attributes['name'])
            ->assertSee($attributes['class']);
    }

    /** @test **/
    public function a_user_can_update_their_character() {

        $character = Character::factory()->create();

        $attributes = Character::factory()->raw();
        $attributes['user_id'] = $character->user_id;
        $attributes['name'] = 'changed';

        $this->actingAs($character->user)
            ->patch($character->path(), $attributes)
            ->assertRedirect($character->path());

        $this->assertDatabaseHas('characters', ['name' => 'changed']);
    }

    /** @test **/
    public function a_user_can_view_their_character() {
        $character = Character::factory()->create();

        $this->actingAs($character->user)
            ->get($character->path())
            ->assertSee($character->name);
    }

    /** @test **/
    public function unathorized_users_cannot_delete_characters() {
        $character = Character::factory()->create();

        $this->delete($character->path())
            ->assertRedirect(route('login'));

        $this->signIn();

        $this->delete($character->path())->assertStatus(403);
    }

    /** @test **/
    public function a_user_can_delete_their_character() {
        // $this->withoutExceptionHandling();
        $character = Character::factory()->create();

        $this->actingAs($character->user)
            ->delete($character->path())
            ->assertRedirect(route('characters.index'));

        $this->assertDatabaseMissing('characters', $character->only('id'));
    }

    /** @test **/
    public function an_authenticated_user_cannot_view_the_characters_of_others() {
        $this->signIn();

        $character = Character::factory()->create();

        $this->get($character->path())->assertStatus(403);
    }

    /** @test **/
    public function an_authenticated_user_cannot_update_the_characters_of_others() {
        $this->signIn();

        $character = Character::factory()->create();

        $this->patch($character->path(), Character::factory()->raw())->assertStatus(403);
    }

    /** @test **/
    public function an_authenticated_user_cannot_delete_the_characters_of_others() {
        $this->signIn();

        $character = Character::factory()->create();

        $this->delete($character->path())->assertStatus(403);
    }

    /** @test **/
    public function a_character_requires_a_name() {
        $this->signIn();

        $attributes = Character::factory()->raw(['name' => '']);

        $this->post(route('characters.store'), $attributes)->assertSessionHasErrors('name');
    }
}
