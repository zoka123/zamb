<?php

namespace Zantolov\Zamb\Controllers\API;

use Zantolov\Zamb\Controllers\BaseApiController;
use App;
use Config;
use Session;
use Input;
use Role;
use Lang;
use Illuminate\Http\JsonResponse;
use Mail;
use Auth;
use Confide;
use User;

class UserApiController extends BaseApiController
{

    public function postLogin()
    {
        $repo = App::make('UserRepository');
        $input = Input::all();

        if ($repo->login($input)) {
            $data = array('message' => 'Login successful');

            if (Session::get('url.intended')) {
                $data['redirect'] = Session::get('url.intended');
                Session::remove('url.intended');
            }

            return new JsonResponse($this->getSuccessResponse($data));
        } else {
            if ($repo->isThrottled($input)) {
                $err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
            } elseif ($repo->existsButNotConfirmed($input)) {
                $err_msg = Lang::get('confide::confide.alerts.not_confirmed');
            } else {
                $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
            }

            return new JsonResponse($this->getErrorResponse(array('message' => $err_msg)), 401);
        }
    }


    public function postRegister()
    {

        $repo = App::make('UserRepository');
        $user = $repo->signup(Input::all());

        if ($user->id) {
            $role = Role::where(array('name' => 'user'))->first();
            if (!empty($role)) {
                $user->roles()->save($role);
            }

            if (Config::get('confide::signup_email')) {
                Mail::queueOn(Config::get('confide::email_queue'), Config::get('confide::email_account_confirmation'), compact('user'),
                    function ($message) use ($user) {
                        $message->to($user->email, $user->username)->subject(Lang::get('confide::confide.email.account_confirmation.subject'));
                    });
            }

            return new JsonResponse($this->getSuccessResponse(array('message' => Lang::get('confide::confide.alerts.account_created'))));
        } else {
            $error = $user->errors()->all(':message');

            return new JsonResponse($this->getErrorResponse(array('message' => $error)), 400);
        }
    }

    public function postLogout()
    {
        Auth::logout();

        return new JsonResponse($this->getSuccessResponse(array('message' => 'Logout successful')));
    }

    public function postForgottenPassword()
    {
        if (Confide::forgotPassword(Input::get('email'))) {
            $notice_msg = Lang::get('confide.alerts.password_forgot');

            return new JsonResponse($this->getSuccessResponse(array('message' => $notice_msg)));

        } else {
            $error_msg = Lang::get('confide.alerts.wrong_password_forgot');

            return new JsonResponse($this->getErrorResponse(array('message' => $error_msg)), 400);
        }
    }

    /**
     * Check if username is available
     * @return array
     */
    public function getCheckUsername()
    {
        $username = Input::get('username');
        $user = User::where(array('username' => $username))->first();

        return array('valid' => empty($user));
    }

    /**
     * Check if email is available
     * @return array
     */
    public function getCheckEmail()
    {
        $email = Input::get('email');
        $user = User::where(array('email' => $email))->first();

        return array('valid' => empty($user));
    }

}