<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Monster;
use App\Models\User;

class MonstersTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test **/
    public function guests_cannot_manage_monsters() {
        $monster = Monster::factory()->create();

        $this->get(route('monsters.index'))->assertRedirect('login');
        $this->get(route('monsters.create'))->assertRedirect('login');
        $this->get(route('monsters.show', $monster->id))->assertRedirect('login');
        $this->post(route('monsters.store'), $monster->toArray())->assertRedirect('login');
    }

    /** @test **/
    public function a_user_can_create_a_monster() {
        $this->signIn();

        $this->get(route('monsters.create'))->assertStatus(200);

        $attributes = Monster::factory()->raw();

        $attributes['user_id'] = auth()->user()->id;

        $response = $this->post(route('monsters.store'), $attributes);

        $monster = Monster::where('name', $attributes['name'])->first();

        $response->assertRedirect($monster->path());

        $this->assertDatabaseHas('monsters', ['name' => $attributes['name']]);

        $this->get($monster->path())
            ->assertSee($attributes['name'])
            ->assertSee($attributes['type']);
    }

    /** @test **/
    public function a_user_can_update_their_monster() {

        $monster = Monster::factory()->create();

        $attributes = Monster::factory()->raw();
        $attributes['user_id'] = $monster->user_id;
        $attributes['name'] = 'changed';

        $this->actingAs($monster->user)
            ->patch($monster->path(), $attributes)
            ->assertRedirect($monster->path());

        $this->assertDatabaseHas('monsters', ['name' => 'changed']);
    }

    /** @test **/
    public function a_user_can_view_their_monster() {
        $monster = Monster::factory()->create();

        $this->actingAs($monster->user)
            ->get($monster->path())
            ->assertSee($monster->name);
    }

    /** @test **/
    public function unathorized_users_cannot_delete_monsters() {
        $monster = Monster::factory()->create();

        $this->delete($monster->path())
            ->assertRedirect(route('login'));

        $this->signIn();

        $this->delete($monster->path())->assertStatus(403);
    }

    /** @test **/
    public function a_user_can_delete_their_monster() {
        $monster = Monster::factory()->create();

        $this->actingAs($monster->user)
            ->delete($monster->path())
            ->assertRedirect(route('monsters.index'));

        $this->assertDatabaseMissing('monsters', $monster->only('id'));
    }

    /** @test **/
    public function an_authenticated_user_cannot_view_the_private_monsters_of_others() {
        $this->signIn();

        $monster = Monster::factory()->create(['public' => false]);

        $this->get($monster->path())->assertStatus(403);
    }

    /** @test **/
    public function an_authenticated_user_cannot_view_the_public_monsters_of_others() {
        $this->signIn();

        $monster = Monster::factory()->create(['public' => true]);

        $this->get($monster->path())->assertStatus(200);
    }

    /** @test **/
    public function an_authenticated_user_cannot_update_the_monsters_of_others() {
        $this->signIn();

        $monster = Monster::factory()->create();

        $this->patch($monster->path(), Monster::factory()->raw())->assertStatus(403);
    }

    /** @test **/
    public function an_authenticated_user_cannot_delete_the_monsters_of_others() {
        $this->signIn();

        $monster = Monster::factory()->create();

        $this->delete($monster->path())->assertStatus(403);
    }

    /** @test **/
    public function a_monster_requires_a_name() {
        $this->signIn();

        $attributes = Monster::factory()->raw(['name' => '']);

        $this->post(route('monsters.store'), $attributes)->assertSessionHasErrors('name');
    }

    /** @test **/
    public function a_monster_is_deleted_with_its_user() {
        $user = User::factory()->create();
        Monster::factory()->create(['user_id' => $user->id]);

        $this->assertCount(1, Monster::all());
        $user->delete();
        $this->assertCount(0, Monster::all());
    }
}
