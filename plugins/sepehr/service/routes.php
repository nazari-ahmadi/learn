<?php


use Sepehr\Service\Models\Service;

Route::get('/seed-service', function () {
    $faker = \Faker\Factory::create();

    $service = new Service();


    for ($i = 1; $i <= 20; $i++) {
        Service::create([
            'user_id' => 1,
            'manager_id' => null,
            'operator_id' => null,
            'operator_recorded_at' => null,
            'operator_received_at' => null,
            'status_id' => 1,
            'sender_postal_code' => $faker->postcode(),
            'sender_address' => $faker->address(),
            'payment_status' => 0,
            'packages' => [
                0 => [
                    'receiver_postal_code' => $faker->postcode(),
                    'receiver_address' => $faker->address(),
                    'weight_id' => $faker->numberBetween(1, 3),
                    'post_type_id' => $faker->numberBetween(1, 3),
                    'distribution_time_id' => $faker->numberBetween(1, 2),
                    'special_services_id' => $faker->numberBetween(1, 2),
                    'package_type_id' => $faker->numberBetween(1, 2),
                    'insurance_type_id' => $faker->numberBetween(1, 2),
                    'package_number' => $faker->numberBetween(1, 2),
                    'points' => [],
                    'price' => $faker->numberBetween(2000, 15000),
                    'is_rejected' => false

                ],
                1 => [
                    'receiver_postal_code' => $faker->postcode(),
                    'receiver_address' => $faker->address(),
                    'weight_id' => $faker->numberBetween(1, 3),
                    'post_type_id' => $faker->numberBetween(1, 3),
                    'distribution_time_id' => $faker->numberBetween(1, 2),
                    'special_services_id' => $faker->numberBetween(1, 2),
                    'package_type_id' => $faker->numberBetween(1, 2),
                    'insurance_type_id' => $faker->numberBetween(1, 2),
                    'package_number' => $faker->numberBetween(1, 2),
                    'points' => [],
                    'price' => $faker->numberBetween(2000, 15000),
                    'is_rejected' => false

                ],
                2 => [
                    'receiver_postal_code' => $faker->postcode(),
                    'receiver_address' => $faker->address(),
                    'weight_id' => $faker->numberBetween(1, 3),
                    'post_type_id' => $faker->numberBetween(1, 3),
                    'distribution_time_id' => $faker->numberBetween(1, 2),
                    'special_services_id' => $faker->numberBetween(1, 2),
                    'package_type_id' => $faker->numberBetween(1, 2),
                    'insurance_type_id' => $faker->numberBetween(1, 2),
                    'package_number' => $faker->numberBetween(1, 2),
                    'points' => [],
                    'price' => $faker->numberBetween(2000, 15000),
                    'is_rejected' => false

                ],

            ],
            'postmans' => [],
            'payments' => [],
        ]);
    }
});