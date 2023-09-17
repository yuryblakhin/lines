<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;

    /**
     * Отображает форму сброса пароля.
     *
     * @param Request $request Запрос, содержащий параметры маршрута и данные запроса.
     * @return View Представление для отображения формы сброса пароля.
     */
    public function showResetForm(Request $request): View
    {
        $this->setTemplate('auth.reset');
        $this->setTitle('Reset Password');
        $this->setDescription('Reset Password');
        $this->setTemplateData([
            'token' =>  $request->route()->parameter('token'),
            'email' => $request->email,
        ]);

        return $this->renderTemplate();
    }
}
