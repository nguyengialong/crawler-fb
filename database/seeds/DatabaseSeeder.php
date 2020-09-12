<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        if ( config( 'app.env' ) == 'local' ) {
            \App\Models\User::firstOrCreate( [
                'email' => 'admin@admin.com',
            ],
                [
                    'name'     => 'Administrator',
                    'password' => bcrypt( 'password' ),
                ] );
        }
    }
}
