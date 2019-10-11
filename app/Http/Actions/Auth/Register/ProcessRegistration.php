<?php

namespace App\Http\Actions\Auth\Register;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthManager;
use PerfectOblivion\Actions\Action;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Validation\Factory as Validator;
use Illuminate\Contracts\Validation\Validator as IlluminateValidator;

class ProcessRegistration extends Action
{
    use RedirectsUsers;

    /** @var string */
    protected $redirectTo = '/';

    /** @var \Illuminate\Validation\Factory */
    private $validator;

    /** @var \Illuminate\Contracts\Hashing\Hasher */
    private $hasher;

    /** @var \Illuminate\Auth\AuthManager */
    private $auth;

    /**
     * Construct a new ProcessRegistration action.
     *
     * @param  \Illuminate\Validation\Factory  $validator
     * @param  \Illuminate\Contracts\Hashing\Hasher  $hasher
     * @param  \Illuminate\Auth\AuthManager  $auth
     */
    public function __construct(Validator $validator, Hasher $hasher, AuthManager $auth)
    {
        $this->validator = $validator;
        $this->hasher = $hasher;
        $this->auth = $auth;
    }

    /**
     * Execute the action to register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect()->route('dashboard');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     */
    protected function validator(array $data): IlluminateValidator
    {
        return $this->validator->make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     */
    protected function create(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $this->hasher->make($data['password']),
        ]);
    }

    /**
     * Get the guard to be used during registration.
     */
    protected function guard(): StatefulGuard
    {
        return $this->auth->guard();
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     */
    protected function registered(Request $request, $user):RedirectResponse
    {
        parent::registered();

        return redirect()->route('dashboard')->with(['success' => 'User registered. Check your email to verify your account.']);
    }
}
