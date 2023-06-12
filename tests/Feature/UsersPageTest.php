<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersPageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_page_users_index(): void
    {
        $response = $this->get('/users');
        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_view_users_index(): void
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
        $users = [];

        foreach ($usersData as $userData) {
            $users[] = User::create($userData);
        }

        $view = $this->view('users.index', ['users' => $users]);

        foreach ($users as $user) {
            $view->assertSee($user['name']);
            $view->assertSee($user['username']);
            $view->assertSee($user['email']);
            $view->assertSee($user['phone']);
        }
    }
}
