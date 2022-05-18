<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

final class AuthMutator
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $credentials = Arr::only($args, ['email', 'password']);

        if (Auth::once($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('login-token');

            return $token->plainTextToken;
        }

        return null;
    }
}
