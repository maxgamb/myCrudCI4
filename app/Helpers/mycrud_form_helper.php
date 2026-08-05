<?php

if (!function_exists('mycrud_field_value')) {
    function mycrud_field_value(?object $row, string $field, mixed $default = ''): mixed
    {
        return old($field, $row->{$field} ?? $default);
    }
}
