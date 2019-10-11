<?php

namespace App\Http\Actions\Auth\Register;

use Inertia\Inertia;
use Inertia\Response;
use PerfectOblivion\Actions\Action;

class ShowForm extends Action
{
    /**
     * Show the application registration form.
     */
    public function __invoke(): Response
    {
        return Inertia::render('Auth/Register');
    }
}
