<?php

namespace Database\Seeders;

use App\Models\Choice;
use App\Models\Poll;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->isAdmin()->create();

        User::factory()->count(3)->state(
            new Sequence([
                'email' => 'user1@polls-app.com',
                'email' => 'user2@polls-app.com',
                'email' => 'user3@polls-app.com'
            ])
        )->has(
            Poll::factory()->count(5)->has(
                Question::factory()->count(10)->has(
                    Choice::factory()->count(4)->state(new Sequence(
                        ['is_correct_choice' => false],
                        ['is_correct_choice' => true],
                        ['is_correct_choice' => false],
                        ['is_correct_choice' => false],
                    ))
                )
            )
        )->create();
    }
}
