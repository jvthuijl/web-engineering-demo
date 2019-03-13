<?php

namespace App\Http\Controllers;

use App\User;
use Github\Client;
use Illuminate\Http\Request;

class RepositoryFetcher extends Controller
{
    public function fetchForUser(User $user) {
        // Authentication
        $this->authorize('read_repositories', $user);

        $client = new Client();
        $client->authenticate($user->getGhAccessToken(), null, Client::AUTH_HTTP_TOKEN);
        try {
            return ['success' => true, 'data' => $client->me()->starring()->all()];
        } catch (\Exception $e) {
            return response()->json(['success' => true, 'error' => $e->getMessage()], 400);
        }
    }
}
