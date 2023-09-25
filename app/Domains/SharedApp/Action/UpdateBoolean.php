<?php declare(strict_types=1);

namespace App\Domains\SharedApp\Action;

use App\Domains\Shared\Model\ModelAbstract;

abstract class UpdateBoolean extends ActionAbstract
{
    /**
     * @return \App\Domains\Shared\Model\ModelAbstract
     */
    public function handle(): ModelAbstract
    {
        $this->before();
        $this->check();
        $this->data();
        $this->store();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function before(): void
    {
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        if (array_key_exists($this->data['column'], $this->row->toArray()) === false) {
            $this->exceptionValidator(__('validator.column-not-valid'));
        }
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataValue();
    }

    /**
     * @return void
     */
    protected function dataValue(): void
    {
        $value = $this->row->{$this->data['column']};

        $this->data['value'] = match (is_bool($value)) {
            true => $this->dataValueBoolean($value),
            false => $this->dataValueDate($value),
        };
    }

    /**
     * @param bool $value
     *
     * @return bool
     */
    protected function dataValueBoolean(bool $value): bool
    {
        return $value === false;
    }

    /**
     * @param ?string $value
     *
     * @return ?string
     */
    protected function dataValueDate(?string $value): ?string
    {
        return $value ? null : date('Y-m-d H:i:s');
    }

    /**
     * @return void
     */
    protected function store(): void
    {
        $this->row->{$this->data['column']} = $this->data['value'];
        $this->row->save();
    }
}
