<?php

namespace App\Containers\AppSection\Authentication\Tasks;

use App\Containers\AppSection\Authentication\Exceptions\LoginFailedException;
use App\Containers\AppSection\Authentication\Values\Token;
use App\Ship\Parents\Tasks\Task as ParentTask;
use GuzzleHttp\Utils;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;

class CallOAuthServerTask extends ParentTask
{
    /**
     * @throws LoginFailedException
     */
    public function run(array $data, string|null $languageHeader = null): array
    {
        $authFullApiUrl = route('passport.token');
        // $authFullApiUrl = env('APP_URL')."/public/v1/oauth/token";
        // echo "Route ::=> ".$authFullApiUrl;die;
        $headers = [
            'HTTP_ACCEPT' => 'application/json',
            'HTTP_ACCEPT_LANGUAGE' => $languageHeader ?? config('app.locale'),
        ];

        $request = Request::create($authFullApiUrl, 'POST', $data, server: $headers);
        $response = App::handle($request);
        // print_r($response->getContent());die;
        $content = Utils::jsonDecode($response->getContent(), true);

        if (!$response->isOk()) {
            throw new LoginFailedException($content['message'] ?? null);
        }

        // return new Token($content['token_type'], $content['expires_in'], $content['access_token'], $content['refresh_token']);
        return $content;
    }
}
