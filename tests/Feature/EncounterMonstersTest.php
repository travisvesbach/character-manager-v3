<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Monster;
use App\Models\Encounter;
use App\Models\EncounterMonster;
use App\Models\User;

class EncounterMonstersTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test **/
    public function guests_cannot_manage_encounter_monsters() {
        $encounter_monster = EncounterMonster::factory()->create();

        $this->get(route('encounter_monsters.show', [$encounter_monster->encounter_id, $encounter_monster->id]))->assertRedirect('login');
        $this->post(route('encounter_monsters.store', $encounter_monster->encounter_id), $encounter_monster->toArray())->assertRedirect('login');
    }

    /** @test **/
    public function a_user_can_create_an_encounter_monster_from_a_monster() {
        $this->signIn();

        $encounter = Encounter::factory()->create(['user_id' => auth()->user()->id]);
        $monster = Monster::factory()->create(['user_id' => auth()->user()->id]);

        $attributes = [
            'monster_id' => $monster->id,
        ];

        $response = $this->post(route('encounter_monsters.store', $encounter->id), $attributes);
        $this->assertCount(1, EncounterMonster::all());
        $encounter_monster = EncounterMonster::where('encounter_id', $encounter->id)->first();

        $this->assertDatabaseHas('encounter_monsters', ['name' => $encounter_monster->name]);
    }

    /** @test **/
    public function a_user_can_update_their_encounter_monster() {
        $attributes = EncounterMonster::factory()->raw();
        $encounter_monster = EncounterMonster::factory()->create($attributes);

        $attributes['name'] = 'changed';

        $this->actingAs($encounter_monster->user)
            ->patch($encounter_monster->path(), $attributes)
            ->assertRedirect($encounter_monster->path());

        $this->assertDatabaseHas('encounter_monsters', ['name' => 'changed']);
    }

    /** @test **/
    public function a_user_can_view_their_encounter_monster() {
        $encounter_monster = EncounterMonster::factory()->create();

        $this->actingAs($encounter_monster->user)
            ->get($encounter_monster->path())
            ->assertSee($encounter_monster->name);
    }

    /** @test **/
    public function unathorized_users_cannot_delete_encounter_monsters() {
        $encounter_monster = EncounterMonster::factory()->create();

        $this->delete($encounter_monster->path())
            ->assertRedirect(route('login'));

        $this->signIn();

        $this->delete($encounter_monster->path())->assertStatus(403);
    }

    /** @test **/
    public function a_user_can_delete_their_encounter_monster() {
        $encounter_monster = EncounterMonster::factory()->create();

        $this->actingAs($encounter_monster->user)
            ->delete($encounter_monster->path())
            ->assertRedirect($encounter_monster->encounter->path());

        $this->assertDatabaseMissing('encounter_monsters', $encounter_monster->only('id'));
    }

    /** @test **/
    public function an_authenticated_user_cannot_update_the_encounter_monsters_of_others() {
        $this->signIn();

        $encounter_monster = EncounterMonster::factory()->create();

        $this->patch($encounter_monster->path(), EncounterMonster::factory()->raw())->assertStatus(403);
    }

    /** @test **/
    public function an_authenticated_user_cannot_delete_the_encounter_monsters_of_others() {
        $this->signIn();

        $encounter_monster = EncounterMonster::factory()->create();

        $this->delete($encounter_monster->path())->assertStatus(403);
    }

    /** @test **/
    public function an_encounter_monster_is_deleted_with_its_user() {
        $user = User::factory()->create();
        EncounterMonster::factory()->create(['user_id' => $user->id]);

        $this->assertCount(1, EncounterMonster::all());
        $user->delete();
        $this->assertCount(0, EncounterMonster::all());
    }

    /** @test **/
    public function an_encounter_monster_is_deleted_with_its_encounter() {
        $encounter = Encounter::factory()->create();
        EncounterMonster::factory()->create(['user_id' => $encounter->user_id, 'encounter_id' => $encounter->id]);

        $this->assertCount(1, EncounterMonster::all());
        $encounter->delete();
        $this->assertCount(0, EncounterMonster::all());
    }

    /** @test **/
    public function name_number_is_set_to_the_next_available_number_when_an_encounter_has_monsters_with_the_same_name() {
        $this->signIn();

        $encounter = Encounter::factory()->create(['user_id' => auth()->user()->id]);
        $monster = Monster::factory()->create(['user_id' => auth()->user()->id]);

        $attributes = [
            'monster_id' => $monster->id,
        ];

        $response = $this->post(route('encounter_monsters.store', $encounter->id), $attributes);
        $this->assertCount(1, EncounterMonster::all());
        $encounter_monster = EncounterMonster::where('encounter_id', $encounter->id)->first();
        $this->assertDatabaseHas('encounter_monsters', ['name' => $encounter_monster->name]);
        $this->assertEquals(0, $encounter_monster->name_number);

        $response = $this->post(route('encounter_monsters.store', $encounter->id), $attributes);
        $this->assertCount(2, EncounterMonster::all());
        $encounter_monster = EncounterMonster::find(2);
        $this->assertEquals(1, $encounter_monster->name_number);
    }

    /** @test **/
    public function a_monster_can_take_a_rest() {
        $encounter = Encounter::factory()->create();
        $encounter_monster = EncounterMonster::factory()->create(['user_id' => $encounter->user_id, 'encounter_id' => $encounter->id, 'hp_max' => 15, 'hp_current' => 15]);

        $this->assertEquals($encounter_monster->hp_max, $encounter_monster->hp_current);

        $encounter_monster->hp_current = 0;
        $encounter_monster->save();
        $this->assertEquals(0, $encounter_monster->hp_current);

        $this->withoutExceptionHandling();

        $this->actingAs($encounter_monster->user)
            ->patch(route('encounter_monsters.rest', ['encounter' => $encounter, 'encounter_monster' => $encounter_monster, 'length' => 'long']))
            ->assertRedirect($encounter_monster->path());

        $encounter_monster->refresh();

        $this->assertEquals($encounter_monster->hp_max, $encounter_monster->hp_current);
    }
}
