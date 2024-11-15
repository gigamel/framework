<?php declare(strict_types=1);

namespace Gigamel\Form;

use Error;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionProperty;

use function class_exists;

class Form implements FormInterface
{
    protected array $fields = [];

    public function __construct(
        protected array $attributes = []
    ) {
    }

    public function fromEntity(string $entity): FormInterface
    {
        if (!class_exists($entity)) {
            return $this;
        }

        $reflectionClass = new ReflectionClass($entity);
        if ($reflectionClass->isReadonly() || $reflectionClass->isAbstract()) {
            return $this;
        }

        foreach ($reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC) as $reflectionProperty) {
            if ($reflectionProperty->isStatic() || $reflectionProperty->isReadonly()) {
                continue;
            }

            $attributes = $reflectionProperty->getAttributes(FieldInterface::class, ReflectionAttribute::IS_INSTANCEOF);
            if (!$attributes) {
                continue;
            }

            try {
                $this->field($attributes[0]->newInstance());
            } catch (Error) {
                continue;
            }
        }

        return $this;
    }

    public function field(FieldInterface $field, ?string $name = null): self
    {
        if ($name) {
            $field->setAttributes(['name' => $name]);
        }
        $this->fields[] = $field;
        return $this;
    }

    public function render(): string
    {
        if (!$this->fields) {
            return '';
        }

        $fields = '';
        foreach ($this->fields as $field) {
            $fields .= $field->render();
        }

        return sprintf('<form%s>%s</form>', Attributes::render($this->attributes), $fields);
    }
}
