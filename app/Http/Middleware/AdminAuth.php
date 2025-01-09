<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserInformation;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
        {
            $user = session('user');

            if (!$user) {
                return redirect()->route('admin.showLogin');
            }

            $userInfo = UserInformation::where('user_accounts_id', $user->id)->first();

            if (!$userInfo || $userInfo->role !== 'admin') {
                return redirect()->route('admin.showLogin');
            }

            return $next($request);
        }
}
