<?php declare(strict_types=1);

namespace App\Domains\Device\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class Create extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['bail', 'string', 'required'],
            'model' => ['bail', 'string', 'required'],
            'serial' => ['bail', 'string', 'required'],
            'phone_number' => ['bail', 'string'],
            'password' => ['bail', 'string'],
            'vehicle_id' => ['bail', 'nullable', 'integer'],
            'enabled' => ['bail', 'boolean'],
            'shared' => ['bail', 'boolean'],
        ];
    }
}
