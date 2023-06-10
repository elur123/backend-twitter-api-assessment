<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->setUser($request);
            return $next($request);
        });
    }

    protected function setUser(Request $request)
    {
        $this->user = $request->user();
    }
}
