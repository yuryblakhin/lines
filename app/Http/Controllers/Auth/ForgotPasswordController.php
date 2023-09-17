<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Отображает форму запроса сброса пароля.
     *
     * @return View Представление для отображения формы запроса сброса пароля.
     */
    public function showLinkRequestForm(): View
    {
        $this->setTemplate('auth.email');
        $this->setTitle(__('messages.auth.forgot_password.title'));
        $this->setDescription(__('messages.auth.forgot_password.description'));

        return $this->renderTemplate();
    }
}
