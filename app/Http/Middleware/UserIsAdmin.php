<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        return $request->user()->join("roles","users.role_id","roles.id")->where("roles.title","admin")->get("roles.title")=="admin" ? $next($request) : response()->json(['error' => 'You are not authorized to access this resource'], 403);
    }
}
