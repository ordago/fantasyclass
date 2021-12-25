<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LastUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        if ($user) {
            $expiresAt = Carbon::now()->addMinutes(5);
            Cache::put('user-is-online-' . $user->id, true, $expiresAt);
            $user->update(['last_seen' => Carbon::now()]);
        }
        return $next($request);
    }
}