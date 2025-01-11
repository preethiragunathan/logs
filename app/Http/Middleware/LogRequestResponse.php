<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class LogRequestResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $start = microtime(true);

        $response = $next($request);

        $end = microtime(true);
        $responseTime = $end - $start;

        if (config('app.log_requests')) {
            DB::table('request_logs')->insert([
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'status_code' => $response->getStatusCode(),
                'response_time' => $responseTime,
                'created_at' => now(),
            ]);
        }

        Log::info('Request Log Middleware Started');
        Log::info('Method: ' . $request->method());
        Log::info('URL: ' . $request->fullUrl());
        Log::info('Status Code: ' . $response->getStatusCode());
        Log::info('Response Time: ' . $responseTime);

        return $response;
    }
}
