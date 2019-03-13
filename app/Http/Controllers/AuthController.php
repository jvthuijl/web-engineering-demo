<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\Github;
use League\OAuth2\Client\Provider\GithubResourceOwner;

class AuthController extends Controller
{
    private $ghProvider;

    public function __construct(Github $provider) {
        $this->ghProvider = $provider;
    }

    public function login() {
        $authorizationUrl = $this->ghProvider->getAuthorizationUrl([
            'scope' => ['user', 'user:email']
        ]);

        return redirect($authorizationUrl);
    }

    public function verify(Request $request) {
        $this->validate($request, [
            'code' => 'required|string'
        ]);

        try {
            $token = $this->ghProvider->getAccessToken('authorization_code', [
                'code' => $request->get('code'),
                'scope' => ['user', 'user:email']
            ]);

            /**
             * @var GithubResourceOwner $githubUser
             */
            $githubUser = $this->ghProvider->getResourceOwner($token);
            $dbUser = User::whereGithubId($githubUser->getId())->first();
            if (!$dbUser) {
                $dbUser = new User(['github_id' => $githubUser->getId()]);
            }

            $dbUser->name = $githubUser->getNickname();
            $dbUser->email = $githubUser->getEmail();
            $dbUser->github_profile_url = $githubUser->getUrl();
            $dbUser->github_token = json_encode($token->getValues());

            $dbUser->rollApiKey();
            $dbUser->save();

            return response()
                ->json([
                    'success' => true,
                    'error' => null,
                    'data' => [
                        'user' => $dbUser
                    ],
                ])
                ->header('Authorization', $dbUser->api_token);
        } catch (IdentityProviderException $e) {
            return response()
                ->json([
                    'success' => false,
                    'error' => 'User not authorized'
                ], 422);
        }
    }

    public function logout() {
        $user = \Auth::user();
        $user->api_token = null;
        $user->save();

        return ['success' => true];
    }

    public function me() {

    }
}
