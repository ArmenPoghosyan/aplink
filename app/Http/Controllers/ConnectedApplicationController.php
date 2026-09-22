<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Passport\Token;

class ConnectedApplicationController extends Controller
{
    /**
     * Revoke a third-party application's access to the user's account.
     */
    public function destroy(Request $request, string $tokenId): RedirectResponse
    {
        $token = Token::where('id', $tokenId)
            ->where('user_id', $request->user()->getKey())
            ->firstOrFail();

        $token->revoke();
        $token->refreshToken?->revoke();

        return back();
    }
}
