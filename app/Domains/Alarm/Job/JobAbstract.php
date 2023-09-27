<?php declare(strict_types=1);

namespace App\Domains\Alarm\Job;

use Illuminate\Queue\Middleware\WithoutOverlapping;
use App\Domains\Alarm\Model\Alarm as Model;
use App\Domains\Core\Job\JobAbstract as JobAbstractCore;

abstract class JobAbstract extends JobAbstractCore
{
    /**
     * @param int $id
     *
     * @return void
     */
    public function __construct(protected int $id)
    {
    }

    /**
     * @return array
     */
    public function middleware(): array
    {
        return [(new WithoutOverlapping((string)$this->id))->expireAfter(30)];
    }

    /**
     * @return \App\Domains\Alarm\Model\Alarm
     */
    protected function row(): Model
    {
        return Model::query()->findOrFail($this->id);
    }
}
