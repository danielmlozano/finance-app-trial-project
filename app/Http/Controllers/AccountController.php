<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Get the data of the logged user
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function me(Request $request)
    {
        return response()->json(['user' => $request->user()]);
    }
}
