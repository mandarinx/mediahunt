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
                'username'   => 'SITE_USERNAME',
                'password'   => Hash::make('SITE_PASSWORD'),
                'fullname'   => 'SITE_FULLNAME',
                'email'      => 'SITE_EMAIL',
                'confirmed'  => 1,
                'permission' => 'admin',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ));

        DB::table('sitesettings')
            ->insert(array(
                array('option' => 'siteName', 'value' => 'Media Venue'),
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