<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Account;

class AccountController extends Controller{

    public function GET_register(){
        return ('/register');
    }

    public function POST_register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'favorite_category' => 'array',
            'role' => [
                'required',
                Rule::in(['User']),
            ],
        ]);

        return redirect('/');
    }
}
