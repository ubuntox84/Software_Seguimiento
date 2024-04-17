<?php

namespace App\Listeners;

use App\Models\User;
use Dcblogdev\MsGraph\Facades\MsGraph;
use Dcblogdev\MsGraph\Models\MsGraphToken;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class NewMicrosoft365SignInListener
{
    public function handle($event)
    {
        $tokenId = $event->token['token_id'];
        $token   = MsGraphToken::find($tokenId);
        $userExist = User::where('email', $event->token['info']['userPrincipalName'])->first();
        // dd($event);
        //  dd( $userExist );

        if ($token->user_id == null) {
            if ($userExist == null) {
                $user = User::create([
                    'name'     => $event->token['info']['givenName'],
                    'surname'     => $event->token['info']['surname'],
                    'email'    => $event->token['info']['userPrincipalName'],
                    'password' => '',
                    // 'faculty_id' => '',
                    'code' => '',
                ])->assignRole('user');
                $token->user_id = $user->id;
                $token->save();
                Auth::login($user);
                
            } else {
                $token->user_id = $userExist->id;
                $token->save();
                Auth::login($userExist);
            }
        } else {
            $user = User::findOrFail($token->user_id);
            $user->save();

            Auth::login($user);
           
        }
    }
}
