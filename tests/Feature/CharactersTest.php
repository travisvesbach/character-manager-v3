<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Character;
use App\Models\User;

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

    /** @test **/
    public function a_character_is_deleted_with_its_user() {
        $user = User::factory()->create();
        Character::factory()->create(['user_id' => $user->id]);

        $this->assertCount(1, Character::all());
        $user->delete();
        $this->assertCount(0, Character::all());
    }

    /** @test **/
    public function a_character_can_take_a_rest() {
        $character = Character::factory()->create(['hp_max' => 15, 'hp_current' => 15]);

        $this->assertEquals($character->hp_max, $character->hp_current);

        $character->hp_current = 0;
        $character->save();
        $this->assertEquals(0, $character->hp_current);

        $this->withoutExceptionHandling();

        $this->actingAs($character->user)
            ->patch(route('characters.rest', ['character' => $character, 'length' => 'long']))
            ->assertRedirect($character->path());

        $character->refresh();

        $this->assertEquals($character->hp_max, $character->hp_current);
    }

    /** @test **/
    public function a_character_can_be_archived() {
        $character = Character::factory()->create();

        $this->assertNull($character->archive_date);

        $this->withoutExceptionHandling();

        $this->actingAs($character->user)
            ->patch(route('characters.archive', ['character' => $character]))
            ->assertRedirect(route('characters.index'));

        $character->refresh();

        $this->assertNotNull($character->archive_date);
    }

    /** @test **/
    public function a_character_can_be_unarchived() {
        $character = Character::factory()->create();

        $this->assertNull($character->archive_date);

        $this->withoutExceptionHandling();

        $this->actingAs($character->user)
            ->patch(route('characters.archive', ['character' => $character]))
            ->assertRedirect(route('characters.index'));

        $character->refresh();

        $this->assertNotNull($character->archive_date);

        $this->actingAs($character->user)
            ->patch(route('characters.unarchive', ['character' => $character]))
            ->assertRedirect($character->path());

        $character->refresh();

        $this->assertNull($character->archive_date);
    }
}
