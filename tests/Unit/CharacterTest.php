<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Character;
use App\Models\User;

class CharacterTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function it_has_a_path() {
        $character = Character::factory()->create();

        $this->assertEquals(config('app.url') . '/characters/' . $character->id, $character->path());
    }

    /** @test **/
    public function it_belongs_to_a_user() {
        $character = Character::factory()->create();

        $this->assertInstanceOf('App\Models\User', $character->user);
    }
}
