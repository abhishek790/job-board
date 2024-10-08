<?php

namespace Database\Seeders;

use App\Models\Employer;
use App\Models\JobApplication;
use App\Models\JobPost;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'jon smith',
            'email' => 'jon@smith.com'
        ]);

        User::factory(300)->create();
        //shuffle will randomize all the element like sfuffling cards
        $users = User::all()->shuffle();

        // now every employer has to be tied with users, not every user has to be an employer but every employer has to an user
        for ($i = 0; $i < 20; $i++) {
            // associating every employer with some user id
            Employer::factory()->create([
                //this pop will remove the element it just assigned form the $users list ensuring only one user id is assigned
                'user_id' => $users->pop()->id
            ]);
        }

        $employers = Employer::all();

        for ($i = 0; $i < 100; $i++) {
            JobPost::factory()->create([
                //random() would return a random element from a $employers collection and we just get random id from a random element 
                'employer_id' => $employers->random()->id
            ]);

        }

        foreach ($users as $user) {
            //we use inRandomOrder() for taking 0 to 4 jobs in random order so that we don't use same jobs over an over
            $jobs = JobPost::inRandomOrder()->take(rand(0, 4))->get();
            foreach ($jobs as $job) {
                JobApplication::factory()->create([
                    'user_id' => $user->id,
                    'job_post_id' => $job->id
                ]);
            }

        }


    }
}
