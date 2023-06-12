<?php

namespace App\Services;

use App\Models\User;
use Error;
use Illuminate\Support\Facades\Http;

class SyncUsersService
{
    protected string $url = 'https://jsonplaceholder.typicode.com';

    /**
     * @return array<User>
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function getUsers(): array
    {
        $request = Http::get($this->url . '/users')->throw();
        return $request->json();
    }

    /**
     * @return void
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function syncUsers(): void
    {
        $usersData = $this->getUsers();

        if (empty($usersData)) {
            throw new Error('userData is empty!');
        }

        $userEmails = collect($usersData)->pluck('email')->toArray();

        User::onlyTrashed()->whereIn('email', $userEmails)->restore();

        foreach ($usersData as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'username' => $userData['username'],
                    'email' => $userData['email'],
                    'phone' => $userData['phone'],
                ]
            );
        }

        User::whereNotIn('email', $userEmails)->delete();
    }
}