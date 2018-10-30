<?php

namespace Modules\User\Http\Controllers\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Core\Http\Controllers\CoreController;
use Modules\User\Models\User;
use Modules\User\Notifications\UserWasRegistered;
use function abort;

class RegisterController extends CoreController
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');

        $this->redirectTo = config('user.redirect_route_after_register', '/');
        
        parent::__construct();
    }

    public function showRegistrationForm()
    {
        if (!config('user.allow_user_registration')) {
            abort(404);
        }

        title('Create Account');

        return view('user::auth.register');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \Modules\User\Models\User
     */
    protected function create(array $data)
    {
        if (!config('user.allow_user_registration')) {
            abort(404);
        }

        $user = new User();

        $instance = $user->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'active' => config('user.activate_user_on_registration') ? 1 : 0,
        ]);

        if (!count($instance->errors())) {
            sendNotification($instance->email, new UserWasRegistered($instance));

            flash('Your account has been created successfully!', 'success');
        }

        return $instance;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        if (!config('user.allow_user_registration')) {
            abort(404);
        }

        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
}
