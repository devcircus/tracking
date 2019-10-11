<?php

namespace App\Http\Actions\Auth\PasswordResetRequest;

use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Auth\PasswordBroker;

class SendEmail extends Action
{
    /**
     * Send a reset link to the given user.
     */
    public function __invoke(Request $request)
    {
        $this->validateEmail($request);

        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return Password::RESET_LINK_SENT === $response
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }

    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     */
    protected function sendResetLinkResponse(Request $request, $response): RedirectResponse
    {
        return redirect()->back()->with(['success' => trans($response)]);
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     */
    protected function sendResetLinkFailedResponse(Request $request, $response): RedirectResponse
    {
        return redirect()->back()->withErrors(['email' => trans($response)]);
    }

    /**
     * Get the broker to be used during password reset.
     */
    public function broker(): PasswordBroker
    {
        return Password::broker();
    }
}
