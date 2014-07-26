<?php

class UserController extends BaseController {

    /**
     * User Model
     * @var User
     */
    protected $user;

    /**
     * Inject the models.
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * Users settings page
     *
     * @return View
     */
    public function getIndex()
    {
        list($user,$redirect) = $this->user->checkAuthAndRedirect('user');
        if($redirect){return $redirect;}

        // Show the page
        return View::make('site/user/index', compact('user'));
    }

    /**
     * Stores new user
     *
     */
    public function postIndex()
    {
        $this->user->username = Input::get( 'username' );
        $this->user->email = Input::get( 'email' );

        $password = Input::get( 'password' );
        $passwordConfirmation = Input::get( 'password_confirmation' );

        if(!empty($password)) {
            if($password === $passwordConfirmation) {
                $this->user->password = $password;
                // The password confirmation will be removed from model
                // before saving. This field will be used in Ardent's
                // auto validation.
                $this->user->password_confirmation = $passwordConfirmation;
            } else {
                // Redirect to the new user page
                return Redirect::to('user/create')
                    ->withInput(Input::except('password','password_confirmation'))
                    ->with('error', Lang::get('admin/users/messages.password_does_not_match'));
            }
        } else {
            unset($this->user->password);
            unset($this->user->password_confirmation);
        }

        // Save if valid. Password field will be hashed before save
        $this->user->save();

        if ( $this->user->id )
        {
            // Redirect with success message, You may replace "Lang::get(..." for your custom message.
            return Redirect::to('user/login')
                ->with( 'notice', Lang::get('user/user.user_account_created') );
        }
        else
        {
            // Get validation errors (see Ardent package)
            $error = $this->user->errors()->all();

            return Redirect::to('user/create')
                ->withInput(Input::except('password'))
                ->with( 'error', $error );
        }
    }

    /**
     * Edits a user
     *
     */
    public function postEdit($user)
    {
        // Validate the inputs
        $validator = Validator::make(Input::all(), $user->getUpdateRules());


        if ($validator->passes())
        {
            $oldUser = clone $user;
            $user->username = Input::get( 'username' );
            $user->email = Input::get( 'email' );

            $password = Input::get( 'password' );
            $passwordConfirmation = Input::get( 'password_confirmation' );

            if(!empty($password)) {
                if($password === $passwordConfirmation) {
                    $user->password = $password;
                    // The password confirmation will be removed from model
                    // before saving. This field will be used in Ardent's
                    // auto validation.
                    $user->password_confirmation = $passwordConfirmation;
                } else {
                    // Redirect to the new user page
                    return Redirect::to('users')->with('error', Lang::get('admin/users/messages.password_does_not_match'));
                }
            } else {
                unset($user->password);
                unset($user->password_confirmation);
            }

            $user->prepareRules($oldUser, $user);

            // Save if valid. Password field will be hashed before save
            $user->amend();
        }

        // Get validation errors (see Ardent package)
        $error = $user->errors()->all();

        if(empty($error)) {
            return Redirect::to('user')
                ->with( 'success', Lang::get('user/user.user_account_updated') );
        } else {
            return Redirect::to('user')
                ->withInput(Input::except('password','password_confirmation'))
                ->with( 'error', $error );
        }
    }

    /**
     * Displays the form for user creation
     *
     */
    public function getCreate()
    {
        return View::make('site/user/create');
    }


    /**
     * Displays the login form
     *
     */
    public function getLogin()
    {
        $user = Auth::user();
        if(!empty($user->id)){
            return Redirect::to('/');
        }

        return View::make('site/user/login');
    }

    /**
     * Receive Facebook login parameter
     *
     */
    public function getFacebookLogin()
    {
         // get data from input
        $code = Input::get( 'code' );

        // get fb service
        $fb = OAuth::consumer( 'Facebook' );

        // check if code is valid

        // if code is provided get user data and sign in
        if ( !empty( $code ) ) {

            // This was a callback request from facebook, get the token
            $token = $fb->requestAccessToken( $code ) ;

            // Send a request with it
            $result = json_decode( $fb->request( '/me' ), true );

            if(User::where('email',$result['email'])->exists())
            {
                $exist_user = User::where('email',$result['email'])->first();
                //Active user ...####

                if(UserAuth::where('service','facebook')->where('user_id', $exist_user->id)->exists())
                {
                    //update facebook info ?
                }else{
                    //dd($token);
                    //Update Userauth Info & token
                    $auth               = new UserAuth;
                    $auth->service      = 'facebook';
                    $auth->user_id      = $exist_user->id;
                    $auth->uid          = $result['id'];
                    $auth->accessToken  = $token->getAccessToken();
                    $auth->endOfLife    = $token->getEndOfLife();
                    $auth->refreshToken = $token->getRefreshToken();
                    $auth->extraParams  = json_encode($token->getExtraParams());
                    $auth->save();
                    dd('finished');
                    //Update User Bio

                        // code...####
                }

            }else
            {
                //create new user
            }
        }
        // if not ask for permission first
        else {
            // get fb authorization
            $url = $fb->getAuthorizationUri();

            // return to facebook login url
             return Redirect::to( (string)$url );
        }
    }

    /**
     * Receive Google login parameter
     *
     */
    public function getGoogleLogin() {
        
        // get data from input
        $code = Input::get( 'code' );

        // get google service
        $googleService = OAuth::consumer( 'Google' );

        // check if code is valid

        // if code is provided get user data and sign in
        if ( !empty( $code ) ) {

            // This was a callback request from google, get the token
            $token = $googleService->requestAccessToken( $code );

            // Send a request with it
            $result = json_decode( $googleService->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );

            //var_dump($api_result);
            //dd();

            if(User::where('email',$result['email'])->exists())
            {
                $exist_user = User::where('email',$result['email'])->first();
                //Active user ...####

                if(UserAuth::where('service','google')->where('user_id', $exist_user->id)->exists())
                {
                    //update google info 
                    $auth = UserAuth::where('service','google')->where('user_id', $exist_user->id)->first();
                }else{
                    //Update Userauth Info & token
                    $auth               = new UserAuth;
                    $auth->service      = 'google';
                }
                    $auth->user_id      = $exist_user->id;
                    $auth->uid          = $result['id'];
                    $auth->accessToken  = $token->getAccessToken();
                    $auth->endOfLife    = $token->getEndOfLife();
                    $auth->refreshToken = $token->getRefreshToken();
                    $auth->extraParams  = json_encode($token->getExtraParams());
                    $auth->save();
                    
                    $json = true;

                    if( $json )  {
                        $userInfo = array( 'auth' => json_decode($auth), 'user' => json_decode($exist_user) );
                        echo json_encode($userInfo);
                    }else {
                        return Redirect::to('/page/start')->with('success','Login成功！開始約人吧！');   
                    }
                    //return result
                    
                    
                    //Update User Bio


            }else
            {
                //create new user
            }
        }
        // if not ask for permission first
        else {
            // get googleService authorization
            $url = $googleService->getAuthorizationUri();

            // return to google login url
            return Redirect::to( (string)$url );
        }
    }
    /**
     * get User Google Calendar
     *
     */
    public function getGoogleCalendar()
    {
        
        $gAuth = UserAuth::where('service', 'google')->where('user_id', 3)->first();

        $extraParams = json_decode($gAuth->extraParams);
        $getToken = array( 
                'access_token' => $gAuth->accessToken,
                'token_type'   => $extraParams->token_type,
                'expires_in'   => '3600',
                'created'      => $gAuth->endOfLife - 3600
                    );
        
        $client = new Google_Client();
        $client->setAccessToken(json_encode($getToken));

        $event = new Google_Service_Calendar_Event();
        $event->setSummary('rex test');
        $event->setLocation('台北市中山南路一號');
        $start = new Google_Service_Calendar_EventDateTime();
        $start->setDateTime('2014-07-27T18:57:12.000+08:00');
        //$start->setTimeZone('Asia/Taipei');
        $event->setStart($start);
        $end = new Google_Service_Calendar_EventDateTime();
        $end->setDateTime('2014-07-27T20:25:00.000+08:00');
        //$end->setTimeZone('Asia/Taipei');
        $event->setEnd($end);
        //$event->setRecurrence(array('RRULE:FREQ=WEEKLY;UNTIL=20110701T100000-07:00'));
        $attendee1 = new Google_Service_Calendar_EventAttendee();
        $attendee1->setEmail('rex@huijun.org');
        $attendees = array($attendee1);
        $event->attendees = $attendees;
        $calendarService = new Google_Service_Calendar($client);
        $recurringEvent = $calendarService->events->insert('primary', $event);

        echo $recurringEvent->getId();
    }

    
    /**
     * Attempt to do login
     *
     */
    public function postLogin()
    {
        $input = array(
            'email'    => Input::get( 'email' ), // May be the username too
            'username' => Input::get( 'email' ), // May be the username too
            'password' => Input::get( 'password' ),
            'remember' => Input::get( 'remember' ),
        );

        // If you wish to only allow login from confirmed users, call logAttempt
        // with the second parameter as true.
        // logAttempt will check if the 'email' perhaps is the username.
        // Check that the user is confirmed.
        if ( Confide::logAttempt( $input, true ) )
        {
            return Redirect::intended('/');
        }
        else
        {
            // Check if there was too many login attempts
            if ( Confide::isThrottled( $input ) ) {
                $err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
            } elseif ( $this->user->checkUserExists( $input ) && ! $this->user->isConfirmed( $input ) ) {
                $err_msg = Lang::get('confide::confide.alerts.not_confirmed');
            } else {
                $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
            }

            return Redirect::to('user/login')
                ->withInput(Input::except('password'))
                ->with( 'error', $err_msg );
        }
    }

    /**
     * Attempt to confirm account with code
     *
     * @param  string  $code
     */
    public function getConfirm( $code )
    {
        if ( Confide::confirm( $code ) )
        {
            return Redirect::to('user/login')
                ->with( 'notice', Lang::get('confide::confide.alerts.confirmation') );
        }
        else
        {
            return Redirect::to('user/login')
                ->with( 'error', Lang::get('confide::confide.alerts.wrong_confirmation') );
        }
    }

    /**
     * Displays the forgot password form
     *
     */
    public function getForgot()
    {
        return View::make('site/user/forgot');
    }

    /**
     * Attempt to reset password with given email
     *
     */
    public function postForgot()
    {
        if( Confide::forgotPassword( Input::get( 'email' ) ) )
        {
            return Redirect::to('user/login')
                ->with( 'notice', Lang::get('confide::confide.alerts.password_forgot') );
        }
        else
        {
            return Redirect::to('user/forgot')
                ->withInput()
                ->with( 'error', Lang::get('confide::confide.alerts.wrong_password_forgot') );
        }
    }

    /**
     * Shows the change password form with the given token
     *
     */
    public function getReset( $token )
    {

        return View::make('site/user/reset')
            ->with('token',$token);
    }


    /**
     * Attempt change password of the user
     *
     */
    public function postReset()
    {
        $input = array(
            'token'=>Input::get( 'token' ),
            'password'=>Input::get( 'password' ),
            'password_confirmation'=>Input::get( 'password_confirmation' ),
        );

        // By passing an array with the token, password and confirmation
        if( Confide::resetPassword( $input ) )
        {
            return Redirect::to('user/login')
            ->with( 'notice', Lang::get('confide::confide.alerts.password_reset') );
        }
        else
        {
            return Redirect::to('user/reset/'.$input['token'])
                ->withInput()
                ->with( 'error', Lang::get('confide::confide.alerts.wrong_password_reset') );
        }
    }

    /**
     * Log the user out of the application.
     *
     */
    public function getLogout()
    {
        Confide::logout();

        return Redirect::to('/');
    }

    /**
     * Get user's profile
     * @param $username
     * @return mixed
     */
    public function getProfile($username)
    {
        $userModel = new User;
        $user = $userModel->getUserByUsername($username);

        // Check if the user exists
        if (is_null($user))
        {
            return App::abort(404);
        }

        return View::make('site/user/profile', compact('user'));
    }

    public function getSettings()
    {
        list($user,$redirect) = User::checkAuthAndRedirect('user/settings');
        if($redirect){return $redirect;}

        return View::make('site/user/profile', compact('user'));
    }

    /**
     * Process a dumb redirect.
     * @param $url1
     * @param $url2
     * @param $url3
     * @return string
     */
    public function processRedirect($url1,$url2,$url3)
    {
        $redirect = '';
        if( ! empty( $url1 ) )
        {
            $redirect = $url1;
            $redirect .= (empty($url2)? '' : '/' . $url2);
            $redirect .= (empty($url3)? '' : '/' . $url3);
        }
        return $redirect;
    }
}
