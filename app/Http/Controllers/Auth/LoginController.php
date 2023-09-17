<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\View\View;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Отображает форму входа в систему.
     *
     * @return View Представление для отображения формы входа.
     */
    public function showLoginForm(): View
    {
        $this->setTemplate('auth.login');
        $this->setTitle('Login');
        $this->setDescription('Login');

        return $this->renderTemplate();
    }
}
