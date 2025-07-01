<?php

namespace App\Containers\AppSection\Authentication\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Authentication\Classes\LoginCustomAttribute;
use App\Containers\AppSection\Authentication\Exceptions\LoginFailedException;
use App\Containers\AppSection\Authentication\Tasks\CallOAuthServerTask;
use App\Containers\AppSection\Authentication\Tasks\MakeRefreshCookieTask;
// use App\Containers\AppSection\Authentication\Tasks\MakeRefreshTokenCookieTask;
use App\Containers\AppSection\Authentication\UI\API\Requests\LoginProxyPasswordGrantRequest;
use App\Containers\AppSection\Tenantuser\Models\Tenantuser;
use App\Containers\AppSection\Role\Models\Role;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Hash;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;

class ProxyLoginForTenantWebClientAction extends ParentAction 
{
    use HashIdTrait;
    public function __construct(
        private readonly CallOAuthServerTask $callOAuthServerTask,
        // private readonly MakeRefreshTokenCookieTask $makeRefreshTokenCookieTask,
        private readonly MakeRefreshCookieTask $makeRefreshCookieTask,
    ) {}

    /**
     * @throws LoginFailedException
     * @throws IncorrectIdException
     * @throws NotFoundException
     */
    public function run(LoginProxyPasswordGrantRequest $request): array
    {
        //echo "call<br>";
        //echo $request;
        //die;
        $sanitizedData = $request->sanitizeInput(
            [
                //...array_keys(config('appSection-authentication.login.fields')),
                'email',
                'password',
            ]
        );

        $userData = Tenantuser::where('email', $sanitizedData['email'])->where('status', 'Active')->first();
        if (empty($userData)) {
            $returnData['result'] = false;
            $returnData['message'] = "User Not Found";
            http_response_code(500);
            echo json_encode($returnData);
            exit();
        }

        $userRoleID = Role::where('id', $userData->role_id)->first();
        $userRoleName = $userRoleID->name;
        if ($userRoleID->status == "Active") {
            config(['auth.guards.api.provider' => 'tenant']);

            [$loginFieldValue] = LoginCustomAttribute::extract($sanitizedData);
            $sanitizedData = $this->enrichSanitizedData($loginFieldValue, $sanitizedData);

            $responseContent = $this->callOAuthServerTask->run($sanitizedData, $request->headers->get('accept-language'));
            $refreshCookie = $this->makeRefreshCookieTask->run($responseContent['refresh_token']);

            $role_id = $this->encode((int)$userData->role_id);
            $responseContent['role_id'] = $role_id;
            $responseContent['role_name'] = $userRoleName;
            if ($userRoleName === 'Hotel Operator') {
                $hotel = Hotelmaster::where('assign_to', $userData->id)->whereNull('deleted_at')->get();
                $hotelData = array();
                if (count($hotel) > 0) {
                    for ($i = 0; $i < count($hotel); $i++) {
                        $hotelData[$i]['label'] = $hotel[$i]->name;
                        $hotelData[$i]['value'] = $this->encode($hotel[$i]->id);
                    }
                    $responseContent['hotel'] = $hotelData;
                }
            }

            $user_id = $this->encode((int)$userData->id);
            $responseContent['user_id'] = $user_id;

            return [
                'response_content' => $responseContent,
                'refresh_cookie' => $refreshCookie,
            ];
        } else {
            $returnData['result'] = false;
            $returnData['message'] = "User Role Not Active";
            http_response_code(500);
            echo json_encode($returnData);
            exit();
        }
    }
    

    private function enrichSanitizedData(string $username, array $sanitizedData): array
    {
        $sanitizedData['username'] = $username;
        $sanitizedData['client_id'] = config('appSection-authentication.clients.mobile.id');
        $sanitizedData['client_secret'] = config('appSection-authentication.clients.mobile.secret');
        $sanitizedData['grant_type'] = 'password';
        $sanitizedData['scope'] = '';

        return $sanitizedData;
    }
}
