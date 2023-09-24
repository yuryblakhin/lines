<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard\Product;

use App\Contracts\Product\ProductRepositoryContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Warehouse;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Throwable;

class ProductController extends Controller
{
    protected ProductRepositoryContract $productRepository;

    public function __construct(
        ProductRepositoryContract $productRepository,
    ) {
        $this->productRepository = $productRepository;
    }

    /**
     * Отображает страницу управления продуктами.
     *
     * @param Request $request Запрос, содержащий параметры и данные запроса.
     *
     * @return View|Exception Представление для отображения страницы управления продуктами
     * или исключение, если возникла ошибка.
     *
     * @throws Exception Если возникла ошибка при выполнении операции.
     */
    public function index(Request $request): View|Exception
    {
        try {
            $data = $request->all();
            $products = $this->productRepository->getAllProducts($data);

            $this->setTemplate('dashboard.product.index');
            $this->setTitle(__('messages.dashboard.product.index.title'));
            $this->setDescription(__('messages.dashboard.product.index.description'));
            $this->setTemplateData(['products' => $products]);

            return $this->renderTemplate();
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Отображает форму создания нового продукта.
     *
     * @param Request $request Запрос.
     *
     * @return View|Exception Представление для отображения формы создания продукта
     * или исключение, если возникла ошибка.
     *
     * @throws Exception Если возникла ошибка при выполнении операции.
     */
    public function create(Request $request): View|Exception
    {
        try {
            $categories = Category::all();

            $this->setTemplate('dashboard.product.create');
            $this->setTitle(__('messages.dashboard.product.create.title'));
            $this->setDescription(__('messages.dashboard.product.create.description'));
            $this->setTemplateData(['categories' => $categories]);

            return $this->renderTemplate();
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Сохраняет новый продукт и перенаправляет на страницу управления продуктами.
     *
     * @param ProductStoreRequest $request Запрос с валидированными данными для создания продукта.
     *
     * @return RedirectResponse|Exception Перенаправление на страницу управления продуктами
     * с сообщением об успешном создании продукта или исключение, если возникла ошибка.
     *
     * @throws Exception Если возникла ошибка при выполнении операции.
     */
    public function store(ProductStoreRequest $request): RedirectResponse|Exception
    {
        try {
            $data = $request->validated();
            $this->productRepository->storeProduct($data);

            return Redirect::route('dashboard.product.index')
                ->with('success', __('messages.dashboard.product.store.redirect'));
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Отображает полную информацию о указанном продукте.
     *
     * @param Request $request Запрос, содержащий параметры и данные запроса.
     * @param int $productId Идентификатор продукта или объект продукта.
     *
     * @return View|Exception Представление для отображения страницы с информацией о продукте
     * или исключение, если возникла ошибка.
     *
     * @throws Exception Если возникла ошибка при выполнении операции.
     */
    public function show(Request $request, int $productId): View|Exception
    {
        try {
            $product = $this->productRepository->findById($productId);
            $warehouses = Warehouse::all();

            $this->setTemplate('dashboard.product.show');
            $this->setTitle(__('messages.dashboard.product.show.title'));
            $this->setDescription(__('messages.dashboard.product.show.description'));
            $this->setTemplateData([
                'product' => $product,
                'warehouses' => $warehouses,
            ]);

            return $this->renderTemplate();
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Отображает страницу с информацией о продукте.
     *
     * @param Request $request Запрос, содержащий параметры и данные запроса.
     * @param int $productId Идентификатор продукта или объект продукта.
     *
     * @return View|Exception Представление для отображения страницы с информацией о продукте
     * или исключение, если возникла ошибка.
     *
     * @throws Exception Если возникла ошибка при выполнении операции.
     */
    public function edit(Request $request, int $productId): View|Exception
    {
        try {
            $product = $this->productRepository->findById($productId);
            $categories = Category::all();

            $this->setTemplate('dashboard.product.edit');
            $this->setTitle(__('messages.dashboard.product.edit.title'));
            $this->setDescription(__('messages.dashboard.product.edit.description'));
            $this->setTemplateData([
                'product' => $product,
                'categories' => $categories,
            ]);

            return $this->renderTemplate();
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Обновляет информацию о продукте.
     *
     * @param ProductUpdateRequest $request Запрос с валидированными данными.
     * @param int $productId Идентификатор продукта, который будет обновлен.
     *
     * @return RedirectResponse|Exception Перенаправление на страницу управления продуктами
     * с сообщением об успешном обновлении или исключение, если возникла ошибка.
     *
     * @throws Exception Если возникла ошибка при выполнении операции.
     */
    public function update(ProductUpdateRequest $request, int $productId): RedirectResponse|Exception
    {
        try {
            $data = $request->validated();
            $product = $this->productRepository->findById($productId);
            $this->productRepository->updateProduct($product, $data);

            return Redirect::route('dashboard.product.index')
                ->with('success', __('messages.dashboard.product.update.redirect'));
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Удаляет продукт.
     *
     * @param Request $request Запрос.
     * @param int $productId Идентификатор продукта, который будет удален.
     *
     * @return RedirectResponse|Exception Перенаправление на страницу управления продуктами
     * с сообщением об успешном удалении продукта или исключение, если возникла ошибка.
     *
     * @throws Exception Если возникла ошибка при выполнении операции.
     */
    public function destroy(Request $request, int $productId): RedirectResponse|Exception
    {
        try {
            $product = $this->productRepository->findById($productId);
            $this->productRepository->destroyProduct($product);

            return Redirect::route('dashboard.product.index')
                ->with('success', __('messages.dashboard.product.destroy.redirect'));
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}
