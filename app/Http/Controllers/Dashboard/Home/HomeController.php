<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Warehouse;
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
        $users = User::all();
        $categories = Category::all();
        $products = Product::all();
        $warehouses = Warehouse::all();

        $this->setTemplate('dashboard.home.index');
        $this->setTitle(__('messages.dashboard.home.index.title'));
        $this->setDescription(__('messages.dashboard.home.index.description'));
        $this->setTemplateData([
            'users' => $users,
            'categories' => $categories,
            'products' => $products,
            'warehouses' => $warehouses,
        ]);

        return $this->renderTemplate();
    }
}
