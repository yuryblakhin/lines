<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Contracts\User\UserRepositoryContract;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    protected UserRepositoryContract $userRepository;

    public function __construct(UserRepositoryContract $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function run()
    {
        $usersData = [
            [
                'first_name' => 'Ivan',
                'last_name' => 'Ivanov',
                'email' => 'ivan.ivanov@test.com',
                'password' => 'password',
            ],
        ];

        foreach ($usersData as $data) {
            if (!User::where('email', $data['email'])->exists()) {
                $this->userRepository->storeUser($data);
            }
        }
    }
}
