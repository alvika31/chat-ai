<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ChatController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('session_id')) {
            $sessionId = app(ChatController::class)->createSession();
            $request->merge(['session_id' => $sessionId]);
        }
        return $next($request);
    }
}
