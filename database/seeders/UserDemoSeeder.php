<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Contracts\User\UserRepositoryContract;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserDemoSeeder extends Seeder
{
    protected UserRepositoryContract $userRepository;

    public function __construct(UserRepositoryContract $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function run()
    {
        $users = [
            [
                'first_name' => 'Ivan',
                'last_name' => 'Ivanov',
                'email' => 'ivan.ivanov@test.com',
                'password' => 'password',
            ],
        ];

        foreach ($users as $user) {
            if (!User::where('email', $user['email'])->first()) {
                $this->userRepository->storeUser($user);
            }
        }
    }
}
