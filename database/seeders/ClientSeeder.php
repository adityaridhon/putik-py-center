<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            [
                'name' => 'Pertamina',
                'location' => 'Balikpapan',
            ],
            [
                'name' => 'Astra',
                'location' => 'Balikpapan',
            ],
            [
                'name' => 'SMP Patra Dharma',
                'location' => 'Balikpapan',
            ],
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }
    }
}
