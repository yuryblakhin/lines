<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard\Warehouse;

use App\Contracts\Warehouse\WarehouseRepositoryContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Warehouse\WarehouseStoreRequest;
use App\Http\Requests\Warehouse\WarehouseUpdateRequest;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Throwable;

class WarehouseController extends Controller
{
    protected WarehouseRepositoryContract $warehouseRepository;

    public function __construct(
        WarehouseRepositoryContract $warehouseRepository,
    ) {
        $this->warehouseRepository = $warehouseRepository;
    }

    /**
     * Отображает страницу управления складами.
     *
     * @param Request $request Запрос, содержащий параметры и данные запроса.
     *
     * @return View|Exception Представление для отображения страницы управления складами
     * или исключение, если возникла ошибка.
     *
     * @throws Exception Если возникла ошибка при выполнении операции.
     */
    public function index(Request $request): View|Exception
    {
        try {
            $data = $request->all();
            $warehouses = $this->warehouseRepository->getAllWarehouses($data);

            $this->setTemplate('dashboard.warehouse.index');
            $this->setTitle(__('messages.dashboard.warehouse.index.title'));
            $this->setDescription(__('messages.dashboard.warehouse.index.description'));
            $this->setTemplateData(['warehouses' => $warehouses]);

            return $this->renderTemplate();
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Отображает форму создания нового склада.
     *
     * @param Request $request Запрос.
     *
     * @return View|Exception Представление для отображения формы создания склада
     * или исключение, если возникла ошибка.
     *
     * @throws Exception Если возникла ошибка при выполнении операции.
     */
    public function create(Request $request): View|Exception
    {
        try {
            $this->setTemplate('dashboard.warehouse.create');
            $this->setTitle(__('messages.dashboard.warehouse.create.title'));
            $this->setDescription(__('messages.dashboard.warehouse.create.description'));

            return $this->renderTemplate();
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Сохраняет нового склада и перенаправляет на страницу управления складами.
     *
     * @param WarehouseStoreRequest $request Запрос с валидированными данными для создания склада.
     *
     * @return RedirectResponse|Exception Перенаправление на страницу управления складами
     * с сообщением об успешном создании склада или исключение, если возникла ошибка.
     *
     * @throws Exception Если возникла ошибка при выполнении операции.
     */
    public function store(WarehouseStoreRequest $request): RedirectResponse|Exception
    {
        try {
            $data = $request->validated();
            $this->warehouseRepository->storeWarehouse($data);

            return Redirect::route('dashboard.warehouse.index')
                ->with('success', __('messages.dashboard.warehouse.store.redirect'));
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Отображает страницу с информацией о складе.
     *
     * @param Request $request Запрос, содержащий параметры и данные запроса.
     * @param int $warehouseId Идентификатор склада или объект склада.
     *
     * @return View|Exception Представление для отображения страницы с информацией о складе
     * или исключение, если возникла ошибка.
     *
     * @throws Exception Если возникла ошибка при выполнении операции.
     */
    public function edit(Request $request, int $warehouseId): View|Exception
    {
        try {
            $warehouse = $this->warehouseRepository->findById($warehouseId);

            $this->setTemplate('dashboard.warehouse.edit');
            $this->setTitle(__('messages.dashboard.warehouse.edit.title'));
            $this->setDescription(__('messages.dashboard.warehouse.edit.description'));
            $this->setTemplateData(['warehouse' => $warehouse]);

            return $this->renderTemplate();
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Обновляет информацию о складе.
     *
     * @param WarehouseUpdateRequest $request Запрос с валидированными данными.
     * @param int $warehouseId Идентификатор склада, который будет обновлен.
     *
     * @return RedirectResponse|Exception Перенаправление на страницу управления складами
     * с сообщением об успешном обновлении или исключение, если возникла ошибка.
     *
     * @throws Exception Если возникла ошибка при выполнении операции.
     */
    public function update(WarehouseUpdateRequest $request, int $warehouseId): RedirectResponse|Exception
    {
        try {
            $data = $request->validated();
            $warehouse = $this->warehouseRepository->findById($warehouseId);
            $this->warehouseRepository->updateWarehouse($warehouse, $data);

            return Redirect::route('dashboard.warehouse.index')
                ->with('success', __('messages.dashboard.warehouse.update.redirect'));
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Удаляет склад.
     *
     * @param Request $request Запрос.
     * @param int $warehouseId Идентификатор склада, который будет удален.
     *
     * @return RedirectResponse|Exception Перенаправление на страницу управления складами
     * с сообщением об успешном удалении склада или исключение, если возникла ошибка.
     *
     * @throws Exception Если возникла ошибка при выполнении операции.
     */
    public function destroy(Request $request, int $warehouseId): RedirectResponse|Exception
    {
        try {
            $warehouse = $this->warehouseRepository->findById($warehouseId);
            $this->warehouseRepository->destroyWarehouse($warehouse);

            return Redirect::route('dashboard.warehouse.index')
                ->with('success', __('messages.dashboard.warehouse.destroy.redirect'));
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}
