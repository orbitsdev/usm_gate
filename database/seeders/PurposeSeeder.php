<?php

namespace Database\Seeders;

use App\Models\Purpose;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PurposeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eventTitles = [
            'Conferences',
            'Seminars/Workshops',
            'Training Sessions',
            'Meetings',
            'Webinars',
            'Employee Orientation',
            'Trade Shows/Exhibitions',
            'Company Events',
            'School/College Classes',
            'Community Events',
            'Sports Events',
            'Music Concerts',
            'Religious Services',
            'Cultural Events',
            'Health and Wellness Programs',
            'Government Meetings',
            'Weddings',
            'Birthday Parties',
            'Volunteer Events',
            'Networking Events',
        ];

        foreach ($eventTitles as $title) {
            Purpose::create(['title' => $title]);
        }
    }
}
