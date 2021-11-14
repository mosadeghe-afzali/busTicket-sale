<?php

namespace App\Http\Middleware;

use App\Traits\Response;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HTTPResponse;

class CheckPermission
{
    use Response;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {


        $user = auth('api')->user();
        if($user)
        {
            $userRoles = $user->roles()->pluck('role')->toArray();



                if (!array_intersect($roles, $userRoles)) {
                    return $this->getErrors(
                        'شما به این بخش دسترسی ندارید',
                        HTTPResponse::HTTP_FORBIDDEN
                    );
                }

        }

        return $next($request);
    }
}
