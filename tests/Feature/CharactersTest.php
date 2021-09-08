<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Character;
use App\Models\User;
// use Facades\Tests\Setup\CharacterFactory;

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

}
