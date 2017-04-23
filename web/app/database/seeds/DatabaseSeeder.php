<?php

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        DB::table('users')
            ->insert(array(
                'username'   => 'admin',
                'password'   => Hash::make('admin123'),
                'fullname'   => 'Abhimanyu Sharma',
                'email'      => 'abhimanyusharma003@gmail.com',
                'confirmed'  => 1,
                'permission' => 'admin',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ));

        DB::table('sitesettings')
            ->insert(array(
                array('option' => 'siteName', 'value' => 'Video Venue'),
                array('option' => 'description', 'value' => 'Some Description'),
                array('option' => 'favIcon', 'value' => 'favicon.ico'),
                array('option' => 'tos', 'value' => 'add tos here'),
                array('option' => 'privacy', 'value' => 'add privacy policy here'),
                array('option' => 'faq', 'value' => 'add faq here'),
                array('option' => 'about', 'value' => 'add about us here'),
                array('option' => 'autoApprove', 'value' => 1),
                array('option' => 'perPage', 'value' => 16),
                array('option' => 'limitPerDay', 'value' => 8),
            ));

        DB::table('categories')
            ->insert(array(
                array('name' => 'Uncategorized', 'slug' => 'uncategorized' ,'created_at' => Carbon\Carbon::now(), 'updated_at' => Carbon\Carbon::now())
            ));

        // $this->call('UserTableSeeder');
    }

}