<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Encounter;
use App\Models\User;

class EncountersTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test **/
    public function guests_cannot_manage_encounters() {
        $encounter = Encounter::factory()->create();

        $this->get(route('encounters.index'))->assertRedirect('login');
        $this->get(route('encounters.create'))->assertRedirect('login');
        $this->get(route('encounters.show', $encounter->id))->assertRedirect('login');
        $this->post(route('encounters.store'), $encounter->toArray())->assertRedirect('login');
    }

    /** @test **/
    public function a_user_can_create_an_encounter() {
        $this->signIn();

        $this->get(route('encounters.create'))->assertStatus(200);

        $attributes = Encounter::factory()->raw();

        $attributes['user_id'] = auth()->user()->id;

        $response = $this->post(route('encounters.store'), $attributes);

        $encounter = Encounter::where('name', $attributes['name'])->first();

        $response->assertRedirect($encounter->path());

        $this->get($encounter->path())
            ->assertSee($attributes['name']);
    }

    /** @test **/
    public function a_user_can_update_their_encounter() {
        $encounter = Encounter::factory()->create();

        $attributes = Encounter::factory()->raw();
        $attributes['user_id'] = $encounter->user_id;
        $attributes['name'] = 'changed';

        $this->actingAs($encounter->user)
            ->patch($encounter->path(), $attributes)
            ->assertRedirect($encounter->path());

        $this->assertDatabaseHas('encounters', ['name' => 'changed']);
    }

    /** @test **/
    public function a_user_can_view_their_encounter() {
        $encounter = Encounter::factory()->create();

        $this->actingAs($encounter->user)
            ->get($encounter->path())
            ->assertSee($encounter->name);
    }

    /** @test **/
    public function unathorized_users_cannot_delete_encounters() {
        $encounter = Encounter::factory()->create();

        $this->delete($encounter->path())
            ->assertRedirect(route('login'));

        $this->signIn();

        $this->delete($encounter->path())->assertStatus(403);
    }

    /** @test **/
    public function a_user_can_delete_their_encounter() {
        $encounter = Encounter::factory()->create();

        $this->actingAs($encounter->user)
            ->delete($encounter->path())
            ->assertRedirect(route('encounters.index'));

        $this->assertDatabaseMissing('encounters', $encounter->only('id'));
    }

    /** @test **/
    public function an_authenticated_user_cannot_view_the_encounters_of_others() {
        $this->signIn();

        $encounter = Encounter::factory()->create();

        $this->get($encounter->path())->assertStatus(403);
    }

    /** @test **/
    public function an_authenticated_user_cannot_update_the_encounters_of_others() {
        $this->signIn();

        $encounter = Encounter::factory()->create();

        $this->patch($encounter->path(), Encounter::factory()->raw())->assertStatus(403);
    }

    /** @test **/
    public function an_authenticated_user_cannot_delete_the_encounters_of_others() {
        $this->signIn();

        $encounter = Encounter::factory()->create();

        $this->delete($encounter->path())->assertStatus(403);
    }

    /** @test **/
    public function an_encounter_requires_a_name() {
        $this->signIn();

        $attributes = Encounter::factory()->raw(['name' => '']);

        $this->post(route('encounters.store'), $attributes)->assertSessionHasErrors('name');
    }

    /** @test **/
    public function an_encounter_is_deleted_with_its_user() {
        $user = User::factory()->create();
        Encounter::factory()->create(['user_id' => $user->id]);

        $this->assertCount(1, Encounter::all());
        $user->delete();
        $this->assertCount(0, Encounter::all());
    }
}
