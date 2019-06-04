<?php

namespace App\Http\Controllers\Api;

use App\Models\ActivityLog;
use App\Services\ActivityLogService;
use App\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller as BaseController;

class AuthController extends BaseController
{
    /**
     * Check if user is authenticated
     *
     * @return object
     */
    public function check()
    {
        if (!Auth::check()) {
            return response()->json(
                [
                'status_code' => 401,
                'message' => 'Unauthenticated',
                'authenticated' => false
                ], 401
            );
        }

        return response()->json(
            [
            'status_code' => 200,
            'message' => 'Authenticated',
            'authenticated' => true
            ], 200
        );
    }

    /**
     * Issue User Token
     *
     * @return object
     */
    public function getToken()
    {
        $result = App::call('Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
        $resultArr = json_decode($result->content(), true);
        
        if (empty($resultArr['error'])) {
            $user = User::where('user_name', request()->get('username'))->first();
            ActivityLogService::log([
                'user_id' => $user['id'],
                'user_name' => $user['user_name'],
                'action' => 'LOGIN',
                'description' => 'Logged in successfully'
            ]);
        }


        return $result;
    }
}
