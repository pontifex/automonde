<?php

namespace App\Http\Requests;

use App\Rules\ExistingBrand;
use App\Serializers\ModelSerializer;
use Illuminate\Foundation\Http\FormRequest;

class AddModel extends FormRequest
{
    public function __construct(
        private ExistingBrand $existingBrand,
        array $query = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        $content = null
    ) {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    public function rules(): array
    {
        return [
            sprintf('%s.brand_id', ModelSerializer::getType()) => [
                'required',
                'string',
                $this->existingBrand
            ],
            sprintf('%s.name', ModelSerializer::getType()) => [
                'required',
                'string',
                'unique_model'
            ],
        ];
    }
}
