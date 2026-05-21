<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate(
            ['id' => 1],
            [
                'about' => 'Ut enim ad minim veniam perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae.',
                'contact' => [
                    'address' => '34/8, East Hukupara, Gifirtok, Sadan.',
                    'email' => 'support@fruitkha.com',
                    'phone' => '+00 111 222 3333',
                ],
                'pages' => ['Home', 'About', 'Shop', 'News', 'Contact'],
            ]
        );
    }
}
