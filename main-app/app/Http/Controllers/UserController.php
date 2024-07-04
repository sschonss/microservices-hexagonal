<?php

namespace App\Http\Controllers;

use App\Core\Email\WelcomeEmail;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::create($request->all());

        $emailWelcome = new WelcomeEmail();
        $emailWelcome->sendEmail($user->email);

        return response()->json($user, 201);
    }
}
