<?php
namespace App\Libraries\MyCrud\Core;

final class FieldLabelResolver
{
    public function resolve(string $field): string
    {
        $key = 'Fields.' . $field;
        $translated = lang($key);

        return is_string($translated) && $translated !== '' && $translated !== $key
            ? $translated
            : Naming::human($field);
    }
}
