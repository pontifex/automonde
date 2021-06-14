<?php

namespace App\Http\Requests;

use App\Rules\ExistingModel;
use App\Rules\ValidCurrency;
use App\Rules\ValidMileageUnit;
use App\Serializers\ProductSerializer;
use Illuminate\Foundation\Http\FormRequest;

class AddProduct extends FormRequest
{
    public function __construct(
        private ExistingModel $existingModel,
        private ValidCurrency $validCurrency,
        private ValidMileageUnit $validMileageUnit,
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
            sprintf('%s.description', ProductSerializer::getType()) => [
                'required',
                'string',
            ],
            sprintf('%s.mileage_distance', ProductSerializer::getType()) => [
                'required',
                'integer',
                'gt:0',
            ],
            sprintf('%s.mileage_unit', ProductSerializer::getType()) => [
                'required',
                'string',
                $this->validMileageUnit,
            ],
            sprintf('%s.price_amount', ProductSerializer::getType()) => [
                'required',
                'integer',
                'gt:0',
            ],
            sprintf('%s.price_currency', ProductSerializer::getType()) => [
                'required',
                'string',
                $this->validCurrency,
            ],
            sprintf('%s.model_id', ProductSerializer::getType()) => [
                'required',
                'string',
                $this->existingModel,
            ],
        ];
    }
}
