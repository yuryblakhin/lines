<?php

declare(strict_types=1);

namespace App\Enums;

enum SortDirectionEnum: string
{
    case ASC = 'asc';
    case DESC = 'desc';

    public function label(): string
    {
        return match ($this) {
            SortDirectionEnum::ASC => 'Сортировка по возрастанию',
            SortDirectionEnum::DESC => 'Сортировка по убыванию',
        };
    }

    public static function getAllValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
