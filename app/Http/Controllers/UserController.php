<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Traits\HttpResponses;
use App\Helpers\ResponseMessages;

class UserController extends Controller
{
    use HttpResponses;
    public function logUser()
    {
        Log::info(34, [
            'firstname' => 'Helen',
            'timezones' => 'America/Los_Angeles'
        ]);

        return $this->successHttpMessage(
            ResponseMessages::LOGGED_SUCCESS, 
            201
        );
    }
}
