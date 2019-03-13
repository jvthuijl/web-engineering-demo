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
        $authorizationUrl = $this->ghProvider->getAuthorizationUrl();

        return redirect($authorizationUrl);
    }

    public function verify(Request $request) {
        try {
            $token = $this->ghProvider->getAccessToken('authorization_token', [
                'code' => $request->get('code')
            ]);

            /**
             * @var GithubResourceOwner $githubUser
             */
            $githubUser = $this->ghProvider->getResourceOwner($token);
            $dbUser = User::whereEmail($githubUser->getEmail())->first();
            if (!$dbUser) {
                $dbUser = new User(['github_id' => $githubUser->getId()]);
            }
            $dbUser->fill([
                'name' => $githubUser->getNickname(),
                'email' => $githubUser->getEmail(),
                'github_profile_url' => $githubUser->getUrl()
            ]);
            $dbUser->save();

            // Return success
        } catch (IdentityProviderException $e) {
            // Return error
        }
    }

    public function logout() {

    }

    public function me() {

    }
}
