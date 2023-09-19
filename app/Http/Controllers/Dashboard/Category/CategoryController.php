<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard\Category;

use App\Contracts\Category\CategoryRepositoryContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Throwable;

class CategoryController extends Controller
{
    protected CategoryRepositoryContract $categoryRepository;

    public function __construct(
        CategoryRepositoryContract $categoryRepository,
    ) {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Отображает страницу управления категориями.
     *
     * @param Request $request Запрос, содержащий параметры и данные запроса.
     *
     * @return View|Exception Представление для отображения страницы управления категориями
     * или исключение, если возникла ошибка.
     *
     * @throws Exception Если возникла ошибка при выполнении операции.
     */
    public function index(Request $request): View|Exception
    {
        try {
            $data = $request->all();
            $categories = $this->categoryRepository->getAllCategories($data);

            $this->setTemplate('dashboard.category.index');
            $this->setTitle(__('messages.dashboard.category.index.title'));
            $this->setDescription(__('messages.dashboard.category.index.description'));
            $this->setTemplateData(['categories' => $categories]);

            return $this->renderTemplate();
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Отображает форму создания новой категории.
     *
     * @param Request $request Запрос.
     *
     * @return View|Exception Представление для отображения формы создания категории
     * или исключение, если возникла ошибка.
     *
     * @throws Exception Если возникла ошибка при выполнении операции.
     */
    public function create(Request $request): View|Exception
    {
        try {
            $categories = Category::all();

            $this->setTemplate('dashboard.category.create');
            $this->setTitle(__('messages.dashboard.category.create.title'));
            $this->setDescription(__('messages.dashboard.category.create.description'));
            $this->setTemplateData(['categories' => $categories]);

            return $this->renderTemplate();
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Сохраняет новую категорию и перенаправляет на страницу управления категориями.
     *
     * @param CategoryStoreRequest $request Запрос с валидированными данными для создания категории.
     *
     * @return RedirectResponse|Exception Перенаправление на страницу управления категориями
     * с сообщением об успешном создании категории или исключение, если возникла ошибка.
     *
     * @throws Exception Если возникла ошибка при выполнении операции.
     */
    public function store(CategoryStoreRequest $request): RedirectResponse|Exception
    {
        try {
            $data = $request->validated();
            $this->categoryRepository->storeCategory($data);

            return Redirect::route('dashboard.category.index')
                ->with('success', __('messages.dashboard.category.store.redirect'));
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Отображает страницу с информацией о категории.
     *
     * @param Request $request Запрос, содержащий параметры и данные запроса.
     * @param int $categoryId Идентификатор категории или объект категории.
     *
     * @return View|Exception Представление для отображения страницы с информацией о категории
     * или исключение, если возникла ошибка.
     *
     * @throws Exception Если возникла ошибка при выполнении операции.
     */
    public function edit(Request $request, int $categoryId): View|Exception
    {
        try {
            $category = $this->categoryRepository->findById($categoryId);
            $categories = Category::where('id', '!=', $category->id)->get();

            $this->setTemplate('dashboard.category.edit');
            $this->setTitle(__('messages.dashboard.category.edit.title'));
            $this->setDescription(__('messages.dashboard.category.edit.description'));
            $this->setTemplateData([
                'category' => $category,
                'categories' => $categories,
            ]);

            return $this->renderTemplate();
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Обновляет информацию о категории.
     *
     * @param CategoryUpdateRequest $request Запрос с валидированными данными.
     * @param int $categoryId Идентификатор категории, которая будет обновлена.
     *
     * @return RedirectResponse|Exception Перенаправление на страницу управления категориями
     * с сообщением об успешном обновлении или исключение, если возникла ошибка.
     *
     * @throws Exception Если возникла ошибка при выполнении операции.
     */
    public function update(CategoryUpdateRequest $request, int $categoryId): RedirectResponse|Exception
    {
        try {
            $data = $request->validated();
            $category = $this->categoryRepository->findById($categoryId);
            $this->categoryRepository->updateCategory($category, $data);

            return Redirect::route('dashboard.category.index')
                ->with('success', __('messages.dashboard.category.update.redirect'));
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Удаляет категорию.
     *
     * @param Request $request Запрос.
     * @param int $categoryId Идентификатор категории, которая будет удалена.
     *
     * @return RedirectResponse|Exception Перенаправление на страницу управления категориями
     * с сообщением об успешном удалении категории или исключение, если возникла ошибка.
     *
     * @throws Exception Если возникла ошибка при выполнении операции.
     */
    public function destroy(Request $request, int $categoryId): RedirectResponse|Exception
    {
        try {
            $category = $this->categoryRepository->findById($categoryId);
            $this->categoryRepository->destroyCategory($category);

            return Redirect::route('dashboard.category.index')
                ->with('success', __('messages.dashboard.category.destroy.redirect'));
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}
