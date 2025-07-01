<?php

namespace App\Containers\AppSection\Authentication\UI\API\Controllers;

use App\Containers\AppSection\Authentication\Actions\ApiLogoutAction;
use App\Containers\AppSection\Authentication\Actions\ProxyLoginForTenantWebClientAction;
use App\Containers\AppSection\Authentication\Actions\ProxyRefreshForWebClientAction;
use App\Containers\AppSection\Authentication\Actions\TenantUserForgotpasswordAction;
use App\Containers\AppSection\Authentication\Exceptions\RefreshTokenMissedException;
use App\Containers\AppSection\Authentication\Exceptions\UserNotConfirmedException;
use App\Containers\AppSection\Authentication\UI\API\Requests\LogoutRequest;
use App\Containers\AppSection\Authentication\UI\API\Requests\ProxyLoginPasswordGrantRequest;
use App\Containers\AppSection\Authentication\UI\API\Requests\ProxyRefreshRequest;
use App\Containers\AppSection\Authentication\UI\API\Requests\LoginProxyPasswordGrantRequest;
use App\Containers\AppSection\Tenantuser\UI\API\Requests\GetAllTenantusersRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cookie;
use App\Containers\AppSection\Tenantuser\Entities\Tenantusers;

class Controller extends ApiController
{
  
    public function tenantUserLogin(LoginProxyPasswordGrantRequest $request): JsonResponse
    {

        $result = app(ProxyLoginForTenantWebClientAction::class)->run($request);
        return $this->json($result['response_content'])->withCookie($result['refresh_cookie']);
    }

    public function tenantUserlogout(LogoutRequest $request)
    {
        app(ApiLogoutAction::class)->run($request);
        return $this->accepted([
            'message' => 'Token revoked successfully.',
        ])->withCookie(Cookie::forget('refreshToken'));
    }

    public function tenantUserForgotpassword(GetAllTenantusersRequest $request)
    {
        $InputData = new Tenantusers(
            $request
        );
        $returnData = app(TenantUserForgotpasswordAction::class)->run($request, $InputData);
        return $returnData;
    }

}
