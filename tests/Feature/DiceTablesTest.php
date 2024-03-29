<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\DiceTable;
use App\Models\User;

class DiceTablesTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test **/
    public function guests_cannot_manage_dice_tables() {
        $dice_table = DiceTable::factory()->create();

        $this->get(route('dice_tables.index'))->assertRedirect('login');
        $this->get(route('dice_tables.create'))->assertRedirect('login');
        $this->get(route('dice_tables.show', $dice_table->id))->assertRedirect('login');
        $this->post(route('dice_tables.store'), $dice_table->toArray())->assertRedirect('login');
    }

    /** @test **/
    public function a_user_can_create_a_dice_table() {
        $this->signIn();

        $this->get(route('dice_tables.create'))->assertStatus(200);

        $attributes = DiceTable::factory()->raw();

        $attributes['user_id'] = auth()->user()->id;

        $response = $this->post(route('dice_tables.store'), $attributes);

        $dice_table = DiceTable::where('name', $attributes['name'])->first();

        $response->assertRedirect($dice_table->path());

        $this->assertDatabaseHas('dice_tables', ['name' => $attributes['name']]);

        $this->get($dice_table->path())
            ->assertSee($attributes['name']);
    }

    /** @test **/
    public function a_user_can_update_their_dice_table() {
        // $this->withoutExceptionHandling();
        $dice_table = DiceTable::factory()->create();

        $attributes = DiceTable::factory()->raw();
        $attributes['user_id'] = $dice_table->user_id;
        $attributes['name'] = 'changed';

        // var_dump($dice_table->path());

        $this->actingAs($dice_table->user)
            ->patch($dice_table->path(), $attributes)
            ->assertRedirect($dice_table->path());

        $this->assertDatabaseHas('dice_tables', ['name' => 'changed']);
    }

    /** @test **/
    public function a_user_can_view_their_dice_table() {
        $dice_table = DiceTable::factory()->create();

        $this->actingAs($dice_table->user)
            ->get($dice_table->path())
            ->assertSee($dice_table->name);
    }

    /** @test **/
    public function unathorized_users_cannot_delete_dice_tables() {
        $dice_table = DiceTable::factory()->create();

        $this->delete($dice_table->path())
            ->assertRedirect(route('login'));

        $this->signIn();

        $this->delete($dice_table->path())->assertStatus(403);
    }

    /** @test **/
    public function a_user_can_delete_their_dice_table() {
        $dice_table = DiceTable::factory()->create();

        $this->actingAs($dice_table->user)
            ->delete($dice_table->path())
            ->assertRedirect(route('dice_tables.index'));

        $this->assertDatabaseMissing('dice_tables', $dice_table->only('id'));
    }

    /** @test **/
    public function an_authenticated_user_cannot_view_the_private_dice_tables_of_others() {
        $this->signIn();

        $dice_table = DiceTable::factory()->create(['public' => false]);

        $this->get($dice_table->path())->assertStatus(403);
    }

    /** @test **/
    public function an_authenticated_user_cannot_view_the_public_dice_tables_of_others() {
        $this->signIn();

        $dice_table = DiceTable::factory()->create(['public' => true]);

        $this->get($dice_table->path())->assertStatus(200);
    }

    /** @test **/
    public function an_authenticated_user_cannot_update_the_dice_tables_of_others() {
        $this->signIn();

        $dice_table = DiceTable::factory()->create();

        $this->patch($dice_table->path(), DiceTable::factory()->raw())->assertStatus(403);
    }

    /** @test **/
    public function an_authenticated_user_cannot_delete_the_dice_tables_of_others() {
        $this->signIn();

        $dice_table = DiceTable::factory()->create();

        $this->delete($dice_table->path())->assertStatus(403);
    }

    /** @test **/
    public function a_dice_table_requires_a_name() {
        $this->signIn();

        $attributes = DiceTable::factory()->raw(['name' => '']);

        $this->post(route('dice_tables.store'), $attributes)->assertSessionHasErrors('name');
    }

    /** @test **/
    public function a_dice_table_is_deleted_with_its_user() {
        $user = User::factory()->create();
        DiceTable::factory()->create(['user_id' => $user->id]);

        $this->assertCount(1, DiceTable::all());
        $user->delete();
        $this->assertCount(0, DiceTable::all());
    }

    /** @test **/
    public function a_dice_tables_ranges_must_start_with_1() {
        $this->signIn();

        $attributes = DiceTable::factory()->raw();
        $attributes['rows'] = [
            [
                'range' => [2],
                'result' => '2',
            ],
            [
                'range' => [3],
                'result' => '3',
            ],
            [
                'range' => [4],
                'result' => '4',
            ],
        ];
        $this->post(route('dice_tables.store'), $attributes)->assertSessionHasErrors('rows');
    }

    /** @test **/
    public function a_dice_table_ranges_start_cannot_be_greater_than_its_end() {
        $this->signIn();

        $attributes = DiceTable::factory()->raw();
        $attributes['rows'] = [
            [
                'range' => [1,2],
                'result' => '2',
            ],
            [
                'range' => [4,3],
                'result' => '3',
            ],
            [
                'range' => [5,6],
                'result' => '4',
            ],
        ];
        $this->post(route('dice_tables.store'), $attributes)->assertSessionHasErrors('rows');
    }

    /** @test **/
    public function a_dice_table_must_include_all_numbers_in_ranges_between_first_and_last_number() {
        $this->signIn();

        $attributes = DiceTable::factory()->raw();
        $attributes['rows'] = [
            [
                'range' => [1],
                'result' => '1',
            ],
            [
                'range' => [3],
                'result' => '3',
            ],
            [
                'range' => [4],
                'result' => '4',
            ],
        ];
        $this->post(route('dice_tables.store'), $attributes)->assertSessionHasErrors('rows');
    }

    /** @test **/
    public function a_dice_table_range_start_cannot_be_empty() {
        $this->signIn();

        $attributes = DiceTable::factory()->raw();
        $attributes['rows'] = [
            [
                'range' => [1],
                'result' => '1',
            ],
            [
                'range' => [],
                'result' => '2',
            ],
            [
                'range' => [3],
                'result' => '3',
            ],
        ];
        $this->post(route('dice_tables.store'), $attributes)->assertSessionHasErrors('rows');
    }

    /** @test **/
    public function a_dice_table_result_cannot_be_empty() {
        $this->signIn();

        $attributes = DiceTable::factory()->raw();
        $attributes['rows'] = [
            [
                'range' => [1],
                'result' => '1',
            ],
            [
                'range' => [2],
                'result' => '',
            ],
            [
                'range' => [3],
                'result' => '3',
            ],
        ];
        $this->post(route('dice_tables.store'), $attributes)->assertSessionHasErrors('rows');
    }

    /** @test **/
    public function a_dice_table_range_cannot_have_duplicate_numbers() {
        $this->signIn();

        $attributes = DiceTable::factory()->raw();
        $attributes['rows'] = [
            [
                'range' => [1],
                'result' => '1',
            ],
            [
                'range' => [2],
                'result' => '',
            ],
            [
                'range' => [3],
                'result' => '3',
            ],
            [
                'range' => [3],
                'result' => '3',
            ],
        ];
        $this->post(route('dice_tables.store'), $attributes)->assertSessionHasErrors('rows');
    }

    /** @test **/
    public function dice_table_test_passing() {
        $this->signIn();

        $attributes = DiceTable::factory()->raw();
        $attributes['rows'] = [
            [
                'range' => [1,5],
                'result' => '1',
            ],
            [
                'range' => [6],
                'result' => '2',
            ],
            [
                'range' => [7,11],
                'result' => '3',
            ],
            [
                'range' => [12],
                'result' => '4',
            ],
        ];
        $this->post(route('dice_tables.store'), $attributes)->assertSessionHasNoErrors();
    }
}
