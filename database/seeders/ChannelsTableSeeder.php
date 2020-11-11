<?php

namespace Database\Seeders;

use App\Models\Channel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ChannelsTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Channel::create( [
            'name' => 'Laravel 5.8',
            'slug' => Str::slug( 'Laravel 5.8' ),
        ] );

        Channel::create( [
            'name' => 'Angular',
            'slug' => Str::slug( 'Angular' ),
        ] );

        Channel::create( [
            'name' => 'Vue js',
            'slug' => Str::slug( 'Vue js' ),
        ] );

        Channel::create( [
            'name' => 'Node js',
            'slug' => Str::slug( 'Node js' ),
        ] );

    }
}
