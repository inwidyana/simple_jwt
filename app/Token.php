<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Token extends Model
{
    protected $fillable = [
        'user_id',
        'token',
    ]; 

    public static function generateTokenFor (User $user) {
        if ($user->token) {
            $user->token->delete();
        }

        $token = $user->token()->create([
            'token' => str_random(32),
        ]);

        return $token->token;
    }
}
