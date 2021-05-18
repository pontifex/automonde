<?php

namespace Libs\Api\Fields;

use Libs\Api\Fields\Exceptions\IncorrectFieldException;
use Libs\Api\Fields\Exceptions\NoFieldsException;
use Libs\Api\IApi;

trait Fields
{
    /**
     * @throws IncorrectFieldException
     * @throws NoFieldsException
     */
    public function getFields(
        array $inputFields,
        string $type,
        array $allowedFieldsForType
    ): array {
        $inputFieldsForType = (isset($inputFields[$type]))
            ? explode(IApi::FIELDS_SEPARATOR, $inputFields[$type])
            : [];

        return [
            $type => $this->match($inputFieldsForType, $allowedFieldsForType),
        ];
    }

    /**
     * @throws IncorrectFieldException
     * @throws NoFieldsException
     */
    private function match(array $inputFields, array $allowedFields): array
    {
        $match = [];

        foreach ($inputFields as $field) {
            if ('' === $field) {
                throw new IncorrectFieldException('Incorrect field: [empty field]');
            }

            if (! in_array($field, $allowedFields)) {
                throw new IncorrectFieldException(sprintf('Incorrect field: %s', $field));
            }

            $match[] = $field;
        }

        if (! count($match)) {
            throw new NoFieldsException();
        }

        return $match;
    }
}
