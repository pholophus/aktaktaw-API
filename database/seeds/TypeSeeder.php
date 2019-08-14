<?php

use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
            'native language',
            'other language',
            'speaking language',
        ];

        $bookings = [
            'pre-order',
            'on-demand'
        ];

        $this->command->info('Seeding Types');
        foreach ($languages as $language) {
            foreach ($bookings as $booking) {
                \App\Models\Type::updateOrCreate(
                    [
                        'name' => $language,
                        'category' => $booking,
                    ]
                );
            }
        }
    }
}
