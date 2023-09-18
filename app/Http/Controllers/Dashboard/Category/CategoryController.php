<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard\Category;

use App\Contracts\User\UserRepositoryContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Throwable;

class CategoryController extends Controller
{
    protected UserRepositoryContract $userRepository;

    public function __construct(
        UserRepositoryContract $userRepository,
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * Отображает страницу управления пользователями.
     *
     * @param Request $request Запрос, содержащий параметры и данные запроса.
     *
     * @return View|Exception Представление для отображения страницы управления пользователями
     * или исключение, если возникла ошибка.
     *
     * @throws Exception Если возникла ошибка при выполнении операции.
     */
    public function index(Request $request): View|Exception
    {
        try {
            $data = $request->all();
            $users = $this->userRepository->getAllUsers($data);

            $this->setTemplate('dashboard.user.index');
            $this->setTitle(__('messages.dashboard.user.index.title'));
            $this->setDescription(__('messages.dashboard.user.index.description'));
            $this->setTemplateData(['users' => new UserCollection($users)]);

            return $this->renderTemplate();
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Отображает форму создания нового пользователя.
     *
     * @param Request $request Запрос.
     *
     * @return View|Exception Представление для отображения формы создания пользователя
     * или исключение, если возникла ошибка.
     *
     * @throws Exception Если возникла ошибка при выполнении операции.
     */
    public function create(Request $request): View|Exception
    {
        try {
            $this->setTemplate('dashboard.user.create');
            $this->setTitle(__('messages.dashboard.user.create.title'));
            $this->setDescription(__('messages.dashboard.user.create.description'));

            return $this->renderTemplate();
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Сохраняет нового пользователя и перенаправляет на страницу управления пользователями.
     *
     * @param UserStoreRequest $request Запрос с валидированными данными для создания пользователя.
     *
     * @return RedirectResponse|Exception Перенаправление на страницу управления пользователями
     * с сообщением об успешном создании пользователя или исключение, если возникла ошибка.
     *
     * @throws Exception Если возникла ошибка при выполнении операции.
     */
    public function store(UserStoreRequest $request): RedirectResponse|Exception
    {
        try {
            $data = $request->validated();
            $this->userRepository->storeUser($data);

            return Redirect::route('dashboard.user.index')
                ->with('success', __('messages.dashboard.user.store.redirect'));
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Отображает страницу с информацией о пользователе.
     *
     * @param Request $request Запрос, содержащий параметры и данные запроса.
     * @param int $userId Идентификатор пользователя или объект пользователя.
     *
     * @return View|Exception Представление для отображения страницы с информацией о пользователе
     * или исключение, если возникла ошибка.
     *
     * @throws Exception Если возникла ошибка при выполнении операции.
     */
    public function edit(Request $request, int $userId): View|Exception
    {
        try {
            $user = $this->userRepository->findById($userId);

            $this->setTemplate('dashboard.user.edit');
            $this->setTitle(__('messages.dashboard.user.edit.title'));
            $this->setDescription(__('messages.dashboard.user.edit.description'));
            $this->setTemplateData(['user' => new UserResource($user)]);

            return $this->renderTemplate();
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Обновляет информацию о пользователе.
     *
     * @param UserUpdateRequest $request Запрос с валидированными данными.
     * @param int $userId Идентификатор пользователя, который будет обновлен.
     *
     * @return RedirectResponse|Exception Перенаправление на страницу управления пользователями
     * с сообщением об успешном обновлении или исключение, если возникла ошибка.
     *
     * @throws Exception Если возникла ошибка при выполнении операции.
     */
    public function update(UserUpdateRequest $request, int $userId): RedirectResponse|Exception
    {
        try {
            $data = $request->validated();
            $user = $this->userRepository->findById($userId);
            $this->userRepository->updateUser($user, $data);

            return Redirect::route('dashboard.user.index')
                ->with('success', __('messages.dashboard.user.update.redirect'));
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Удаляет пользователя.
     *
     * @param Request $request Запрос.
     * @param int $userId Идентификатор пользователя, который будет удален.
     *
     * @return RedirectResponse|Exception Перенаправление на страницу управления пользователями
     * с сообщением об успешном удалении пользователя или исключение, если возникла ошибка.
     *
     * @throws Exception Если возникла ошибка при выполнении операции.
     */
    public function destroy(Request $request, int $userId): RedirectResponse|Exception
    {
        try {
            $user = $this->userRepository->findById($userId);
            $this->userRepository->destroyUser($user);

            return Redirect::route('dashboard.user.index')
                ->with('success', __('messages.dashboard.user.destroy.redirect'));
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}
