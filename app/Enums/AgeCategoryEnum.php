<?php

namespace App\Enums;

enum AgeCategoryEnum: string
{

    case BOYS   = 'Boys';
    case GIRLS = 'Girls';


    public function label(): string
    {
        return match ($this) {
            self::BOYS   => __('messages.boys'),
            self::GIRLS => __('messages.girls'),
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
