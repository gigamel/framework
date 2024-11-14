<?php declare(strict_types=1);

namespace Gigamel\Form;

use in_array;
use is_string;

final class Attributes
{
    public static function render(array $attributes, array $excludes = []): string
    {
        $renderedAttributes = '';
        foreach ($attributes as $name => $value) {
            if (is_string($name) && is_string($value) && !in_array($name, $excludes)) {
                $renderedAttributes .= sprintf(' %s="%s"', $name, $value);
            }
        }

        return $renderedAttributes;
    }
}
