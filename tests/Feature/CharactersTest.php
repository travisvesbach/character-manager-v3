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
        $this->withoutExceptionHandling();

        $this->signIn();

        $this->get(route('characters.create'))->assertStatus(200);

        $attributes = Character::factory()->raw();

        $response = $this->post(route('characters.store'), $attributes);

        $character = Character::where('name', $attributes['name'])->first();

        $response->assertRedirect($character->path());

        $this->get($character->path())
            ->assertSee($attributes['name'])
            ->assertSee($attributes['class']);
    }
}
