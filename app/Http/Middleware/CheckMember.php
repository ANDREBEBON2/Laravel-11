<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // cek apakah user merupakan member?
        if (!$request->member == true) {
            return redirect('/price'); // jika tidak maka redirect ke route /price
        }

        // Log info ini akan di simpan di file storege/logs/laravel.log
        Log::info('Sebelum Request : ', [
            "url" => $request->url(),
            "params" => $request->all(),
        ]);

        $request = $next($request); // menyimpan hasil request sebelumnya di variabel $request

        sleep(1); // menambahka sleep agar dapat melihat jeda antara sebelum dan sesudah request, hanya untuk debuging

        Log::info('Sesudah Request : ', [
            'status' => $request->getStatusCode(),
            'content' => $request->getContent(),
        ]);

        return $request;
    }
}
