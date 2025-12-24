<?php

namespace App\Enums;

enum ShirtTypeEnum: string
{

    case SINGLE   = 'Single';
    case VERTICAL = 'Vertical';
    case HORIZONTAL = 'Horizontal';

    public function label(): string
    {
        return match ($this) {
            self::SINGLE   => __('messages.single_color'),
            self::VERTICAL => __('messages.striped_vertical'),
            self::HORIZONTAL => __('messages.striped_horizontal'),
        };
    }

    public static function toDictionary(): array {
        $dictionary = [];
        foreach (self::cases() as $index=>$case) {
            $dictionary[$index]['name'] = $case->name;
            $dictionary[$index]['value'] = $case->value;
            $dictionary[$index]['label'] = $case->label();
        }
        return $dictionary;
    }

}
