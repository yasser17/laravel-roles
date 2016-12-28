<?php
namespace Yasser\Roles\Middlewares;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Yasser\Roles\Exceptions\PermissionDeniedException;

class VerifyRole
{
    /**
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * VerifyPermission constructor.
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param $request
     * @param Closure $next
     * @param $role
     * @return mixed
     * @throws PermissionDeniedException
     */
    public function handle($request, Closure $next, $role)
    {
        if ($this->auth->check() && $this->auth->user()->checkRole($role)) {
            return $next($request);
        }

        throw new PermissionDeniedException("You don't have a required {$role} role");
    }
}