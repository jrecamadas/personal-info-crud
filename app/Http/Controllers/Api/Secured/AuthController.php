<?php

namespace App\Http\Controllers\Api\Secured;

use App\Models\ActivityLog;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Auth;
use Lcobucci\JWT\Parser;
use Dingo\Api\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use DB;

class AuthController extends BaseController
{
    /**
     * Logout user, invalidate user access_token
     */
    public function logout(Request $request)
    {
        $token = $request->header('Authorization');

        if ($token) {
            $token = str_replace('Bearer ', '', $token);
            $id = (new Parser())->parse($token)->getHeader('jti');
            $revoked = DB::table('oauth_access_tokens')->where('id', $id)->update(['revoked' => 1]);
        }

        ActivityLogService::log([
            'action' => 'LOGOUT',
            'description' => 'Logged out successfully'
        ]);

        return response()->json(
            [
            'status_code' => 200,
            'message' => 'You are successfully logged out'
            ], 200
        );
    }
}
