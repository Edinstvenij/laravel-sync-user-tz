<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\SyncUsersService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SyncUsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function test_sync_users_db(): void
    {
        $usersData = [
            [
                'id' => 1,
                'name' => 'John Doe',
                'username' => 'johndoe',
                'email' => 'johndoe@example.com',
                'phone' => '123456789',
            ],
            [
                'id' => 2,
                'name' => 'Back Black',
                'username' => 'backblack',
                'email' => 'backblack@example.com',
                'phone' => '987654321',
            ],
            [
                'id' => 3,
                'name' => 'Din Westchester',
                'username' => 'dinwestchester',
                'email' => 'westchester@example.com',
                'phone' => '123459876',
            ],
            [
                'id' => 4,
                'name' => 'Sam Westchester',
                'username' => 'samwestchester',
                'email' => 'samwestchester@example.com',
                'phone' => '987612345',
            ],
        ];
        $modifiedUsersData = [
            [
                'id' => 2,
                'name' => 'Back Black2',
                'username' => 'backblack',
                'email' => 'backblack@example.com',
                'phone' => '987654321',
            ],
            [
                'id' => 3,
                'name' => 'Din Westchester',
                'username' => 'dinwestchester',
                'email' => 'westchester@example.com',
                'phone' => '222222222',
            ],
            [
                'id' => 4,
                'name' => 'Sam Westchester4',
                'username' => 'samwestchester4',
                'email' => 'samwestchester@example.com',
                'phone' => '187612345',
            ],
            [
                'id' => 5,
                'name' => 'Bob Smit',
                'username' => 'smit',
                'email' => 'smitbobi@example.com',
                'phone' => '187312345',
            ],
        ];

        $mockService = $this->getMockBuilder(SyncUsersService::class)
            ->onlyMethods(['getUsers'])
            ->getMock();

        $mockService->expects($this->exactly(3))
            ->method('getUsers')
            ->willReturnOnConsecutiveCalls($usersData, $modifiedUsersData, $usersData);

        //  1
        $mockService->syncUsers();

        foreach ($usersData as $userData) {
            $this->assertDatabaseHas('users', [
                'id' => $userData['id'],
                'name' => $userData['name'],
                'username' => $userData['username'],
                'email' => $userData['email'],
                'phone' => $userData['phone'],
            ]);
        }

        $deletedUsers = User::whereNotIn('email', array_column($usersData, 'email'))->get();
        $this->assertCount(0, $deletedUsers);

        //  2
        $mockService->syncUsers();

        foreach ($modifiedUsersData as $modifiedUserData) {
            $this->assertDatabaseHas('users', [
                'id' => $modifiedUserData['id'],
                'name' => $modifiedUserData['name'],
                'username' => $modifiedUserData['username'],
                'email' => $modifiedUserData['email'],
                'phone' => $modifiedUserData['phone'],
            ]);
        }

        $deletedUsers = User::whereNotIn('email', array_column($modifiedUsersData, 'email'))->get();
        $this->assertCount(0, $deletedUsers);

        //  3
        $mockService->syncUsers();

        foreach ($usersData as $userData) {
            $this->assertDatabaseHas('users', [
                'id' => $userData['id'],
                'name' => $userData['name'],
                'username' => $userData['username'],
                'email' => $userData['email'],
                'phone' => $userData['phone'],
            ]);
        }

        $deletedUsers = User::whereNotIn('email', array_column($usersData, 'email'))->get();
        $this->assertCount(0, $deletedUsers);
    }
}