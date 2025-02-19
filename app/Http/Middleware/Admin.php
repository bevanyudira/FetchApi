<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class Admin {
    public function handle($request, Closure $next) {
        if (!Auth::user()->level == 'admin') {
            return redirect()->back();
        }
        return abort(404);
    }
}
