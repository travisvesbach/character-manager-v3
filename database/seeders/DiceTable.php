<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DiceTable;

class DiceTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dice_table = DiceTable::factory()
            ->state([
                'name' => 'Wild Magic',
                'user_id' => 1,
                'rows' => [
                    [
                        'range' => [1,2],
                        'result' => "Roll on this table at the start of each of your turns for the next minute, ignoring this result on subsequent rolls."
                    ],
                    [
                        'range' => [3,4],
                        'result' => "For the next minute, you can see any invisible creature if you have line of sight to it."
                    ],
                    [
                        'range' => [5,6],
                        'result' => "A modron chosen and controlled by the DM appears in an unoccupied space within 5 feet of you, then disappears 1 minute later."
                    ],
                    [
                        'range' => [7,8],
                        'result' => "You cast fireball as a 3rd-level spell centered on yourself."
                    ],
                    [
                        'range' => [9,10],
                        'result' => "You cast magic missile as a 5th-level spell."
                    ],
                    [
                        'range' => [11,12],
                        'result' => "Roll a d10. Your height changes by a number of inches equal to the roll. If the roll is odd, you shrink. If the roll is even, you grow."
                    ],
                    [
                        'range' => [13,14],
                        'result' => "You cast confusion centered on yourself."
                    ],
                    [
                        'range' => [15,16],
                        'result' => "For the next minute, you regain 5 hit points at the start of each of your turns."
                    ],
                    [
                        'range' => [17,18],
                        'result' => "You grow a long beard made of feathers that remains until you sneeze, at which point the feathers explode out from your face."
                    ],
                    [
                        'range' => [19,20],
                        'result' => "You cast grease centered on yourself."
                    ],
                    [
                        'range' => [21,22],
                        'result' => "Creatures have disadvantage on saving throws against the next spell you cast in the next minute that involves a saving throw."
                    ],
                    [
                        'range' => [23,24],
                        'result' => "Your skin turns a vibrant shade of blue. A remove curse spell can end this effect."
                    ],
                    [
                        'range' => [25,26],
                        'result' => "An eye appears on your forehead for the next minute."
                    ],
                    [
                        'range' => [27,28],
                        'result' => "For the next minute, all your spells with a casting time of 1 action have a casting time of 1 bonus action."
                    ],
                    [
                        'range' => [29,30],
                        'result' => "You teleport up to 60 feet to an unoccupied space of your choice that you can see."
                    ],
                    [
                        'range' => [31,32],
                        'result' => "You are transported to the Astral Plane until the end of your next turn, after which time you return to the space you previously occupied or the nearest unoccupied space if that space is occupied."
                    ],
                    [
                        'range' => [33,34],
                        'result' => "Maximize the damage of the next damaging spell you cast within the next minute."
                    ],
                    [
                        'range' => [35,36],
                        'result' => "Roll a d10. Your age changes by a number of years equal to the roll. If the roll is odd, you get younger (minimum 1 year old). If the roll is even, you get older."
                    ],
                    [
                        'range' => [37,38],
                        'result' => "1d6 flumphs controlled by the DM appear in unoccupied spaces within 60 feet of you and are frightened of you. They vanish after 1 minute."
                    ],
                    [
                        'range' => [39,40],
                        'result' => "You regain 2d10 hit points."
                    ],
                    [
                        'range' => [41,42],
                        'result' => "You turn into a potted plant until the start of your next turn. While a plant, you are incapacitated and have vulnerability to all damage. If you drop to 0 hit points, your pot breaks, and your form reverts."
                    ],
                    [
                        'range' => [43,44],
                        'result' => "For the next minute, you can teleport up to 20 feet as a bonus action on each of your turns."
                    ],
                    [
                        'range' => [45,46],
                        'result' => "You cast levitate on yourself."
                    ],
                    [
                        'range' => [47,48],
                        'result' => "A unicorn controlled by the DM appears in a space within 5 feet of you, then disappears 1 minute later."
                    ],
                    [
                        'range' => [49,50],
                        'result' => "You can't speak for the next minute. Whenever you try, pink bubbles float out of your mouth."
                    ],
                    [
                        'range' => [51,52],
                        'result' => "A spectral shield hovers near you for the next minute, granting you a +2 bonus to AC and immunity to magic missile."
                    ],
                    [
                        'range' => [53,54],
                        'result' => "You are immune to being intoxicated by alcohol for the next 5d6 days."
                    ],
                    [
                        'range' => [55,56],
                        'result' => "Your hair falls out but grows back within 24 hours."
                    ],
                    [
                        'range' => [57,58],
                        'result' => "For the next minute, any flammable object you touch that isn't being worn or carried by another creature bursts into flame."
                    ],
                    [
                        'range' => [59,60],
                        'result' => "You regain your lowest-level expended spell slot."
                    ],
                    [
                        'range' => [61,62],
                        'result' => "For the next minute, you must shout when you speak."
                    ],
                    [
                        'range' => [63,64],
                        'result' => "You cast fog cloud centered on yourself."
                    ],
                    [
                        'range' => [65,66],
                        'result' => "Up to three creatures you choose within 30 feet of you take 4d10 lightning damage."
                    ],
                    [
                        'range' => [67,68],
                        'result' => "You are frightened by the nearest creature until the end of your next turn."
                    ],
                    [
                        'range' => [69,70],
                        'result' => "Each creature within 30 feet of you becomes invisible for the next minute. The invisibility ends on a creature when it attacks or casts a spell."
                    ],
                    [
                        'range' => [71,72],
                        'result' => "You gain resistance to all damage for the next minute."
                    ],
                    [
                        'range' => [73,74],
                        'result' => "A random creature within 60 feet of you becomes poisoned for 1d4 hours."
                    ],
                    [
                        'range' => [75,76],
                        'result' => "You glow with bright light in a 30-foot radius for the next minute. Any creature that ends its turn within 5 feet of you is blinded until the end of its next turn."
                    ],
                    [
                        'range' => [77,78],
                        'result' => "You cast polymorph on yourself. If you fail the saving throw, you turn into a sheep for the spell's duration."
                    ],
                    [
                        'range' => [79,80],
                        'result' => "Illusory butterflies and flower petals flutter in the air within 10 feet of you for the next minute."
                    ],
                    [
                        'range' => [81,82],
                        'result' => "You can take one additional action immediately."
                    ],
                    [
                        'range' => [83,84],
                        'result' => "Each creature within 30 feet of you takes 1d10 necrotic damage. You regain hit points equal to the sum of the necrotic damage dealt."
                    ],
                    [
                        'range' => [85,86],
                        'result' => "You cast mirror image."
                    ],
                    [
                        'range' => [87,88],
                        'result' => "You cast fly on a random creature within 60 feet of you."
                    ],
                    [
                        'range' => [89,90],
                        'result' => "You become invisible for the next minute. During that time, other creatures can't hear you. The invisibility ends if you attack or cast a spell."
                    ],
                    [
                        'range' => [91,92],
                        'result' => "If you die within the next minute, you immediately come back to life as if by the reincarnate spell."
                    ],
                    [
                        'range' => [93,94],
                        'result' => "Your size increases by one size category for the next minute."
                    ],
                    [
                        'range' => [95,96],
                        'result' => "You and all creatures within 30 feet of you gain vulnerability to piercing damage for the next minute."
                    ],
                    [
                        'range' => [97,98],
                        'result' => "You are surrounded by faint, ethereal music for the next minute."
                    ],
                    [
                        'range' => [99,100],
                        'result' => "You regain all expended sorcery points."
                    ]
                ],
            ])
            ->create();

        $this->command->info($dice_table->name . ' dice table created....');
    }
}
