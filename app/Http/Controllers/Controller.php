<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @var string Заголовок страницы.
     */
    protected string $title = '';

    /**
     * @var string Описание страницы.
     */
    protected string $description = '';

    /**
     * @var string Шаблон представления.
     */
    protected string $template = '';

    /**
     * @var array Данные, передаваемые в представление.
     */
    protected array $templateData = [];

    /**
     * Устанавливает заголовок страницы.
     *
     * @param string $title Заголовок страницы.
     */
    protected function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Получает заголовок страницы.
     *
     * @return string Заголовок страницы.
     */
    protected function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Устанавливает описание страницы.
     *
     * @param string $description Описание страницы.
     */
    protected function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Получает описание страницы.
     *
     * @return string Описание страницы.
     */
    protected function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Устанавливает шаблон представления.
     *
     * @param string $template Шаблон представления.
     */
    protected function setTemplate(string $template): void
    {
        $this->template = $template;
    }

    /**
     * Получает шаблон представления.
     *
     * @return string Шаблон представления.
     */
    protected function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * Устанавливает данные для представления.
     *
     * @param array $data Данные для представления.
     */
    protected function setTemplateData(array $data): void
    {
        $this->templateData = $data;
    }

    /**
     * Получает данные для представления.
     *
     * @return array Данные для представления.
     */
    protected function getTemplateData(): array
    {
        $data = $this->templateData;

        if (!isset($data['title'])) {
            $data['title'] = $this->title;
        }

        if (!isset($data['description'])) {
            $data['description'] = $this->description;
        }

        return $data;
    }

    /**
     * Отрисовывает шаблон представления.
     *
     * @return View Представление для отображения.
     */
    protected function renderTemplate(): View
    {
        return view($this->getTemplate(), $this->getTemplateData());
    }
}
