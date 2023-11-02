<?php declare(strict_types=1);

namespace App\Domains\MaintenanceItem\Service\Controller;

abstract class CreateUpdateAbstract extends ControllerAbstract
{
    /**
     * @return void
     */
    protected function request()
    {
        $this->requestMergeWithRow([
            'user_id' => $this->user(false)->id,
        ]);
    }

    /**
     * @return array
     */
    protected function dataCreateUpdate(): array
    {
        return $this->dataCore();
    }
}
