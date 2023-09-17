<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Отображает домашнюю страницу панели управления.
     *
     * @return View Представление для отображения домашней страницы.
     */
    public function index(): View
    {
        $this->setTemplate('dashboard.home.index');
        $this->setTitle('Dashboard');
        $this->setDescription('Default title');

        return $this->renderTemplate();
    }
}
