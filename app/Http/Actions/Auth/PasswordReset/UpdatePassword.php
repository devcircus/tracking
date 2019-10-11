<?php

namespace App\Http\Actions\Auth\PasswordReset;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthManager;
use PerfectOblivion\Actions\Action;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Contracts\Auth\PasswordBroker as IlluminatePasswordBroker;

class UpdatePassword extends Action
{
    use RedirectsUsers;

    /** @var string */
    protected $redirectTo = '/';

    /** @var \Illuminate\Contracts\Hashing\Hasher */
    private $hasher;

    /** @var \Illuminate\Auth\AuthManager */
    private $auth;

    /** @var \Illuminate\Auth\Passwords\PasswordBroker */
    private $broker;

    /** @var \Illuminate\Auth\Passwords\PasswordBrokerManager */
    private $brokerManager;

    /**
     * Construct a new UpdatePassword action.
     *
     * @param  \Illuminate\Auth\Passwords\PasswordBrokerManager  $brokerManager
     * @param  \Illuminate\Auth\Passwords\PasswordBroker  $broker
     * @param  \Illuminate\Contracts\Hashing\Hasher  $hasher
     * @param  \Illuminate\Auth\AuthManager  $auth
     */
    public function __construct(PasswordBrokerManager $brokerManager, PasswordBroker $broker, Hasher $hasher, AuthManager $auth)
    {
        $this->brokerManager = $brokerManager;
        $this->broker = $broker;
        $this->hasher = $hasher;
        $this->auth = $auth;
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $request->validate($this->rules(), $this->validationErrorMessages());
        $response = $this->broker()->reset(
            $request->credentials('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        return $this->broker::PASSWORD_RESET === $response
            ? $this->sendResetResponse($request, $response)
            : $this->sendResetFailedResponse($request, $response);
    }

    /**
     * Get the password reset validation rules.
     */
    protected function rules(): array
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ];
    }

    /**
     * Get the password reset validation error messages.
     */
    protected function validationErrorMessages(): array
    {
        return [
            'token' => 'Invalid token. Please restart the password reset process.',
            'email' => 'There was a problem with this email. Please try again.',
            'password.required' => 'You must provide a password.',
            'password.confirmed' => 'The given passwords do not match.',
            'password.min' => 'The password must be at lease 8 characters.',
        ];
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string  $password
     */
    protected function resetPassword(Authenticatable $user, string $password)
    {
        $user->password = $this->hasher->make($password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        $this->guard()->login($user);
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     */
    protected function sendResetResponse(Request $request, $response): RedirectResponse
    {
        return redirect()->route('dashboard')->with(['success' => trans($response)]);
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     */
    protected function sendResetFailedResponse(Request $request, $response): RedirectResponse
    {
        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors($this->translateResponseIntoErrors($response));
    }

    /**
     * Get the broker to be used during password reset.
     */
    public function broker(): IlluminatePasswordBroker
    {
        return $this->brokerManager->broker();
    }

    /**
     * Get the guard to be used during password reset.
     */
    protected function guard(): StatefulGuard
    {
        return $this->auth->guard();
    }

    /**
     * Translate the broker response into an errors array.
     *
     * @param  string  $response
     */
    public function translateResponseIntoErrors(string $response): array
    {
        if ('passwords.token' === $response) {
            return ['token' => trans($response)];
        }
        if ('passwords.user' === $response) {
            return ['email' => trans($response)];
        }
        if ('passwords.password' === $response) {
            return ['password' => trans($response)];
        }
    }
}
