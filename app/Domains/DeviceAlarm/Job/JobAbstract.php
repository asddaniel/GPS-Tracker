<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Job;

use Illuminate\Queue\Middleware\WithoutOverlapping;
use App\Domains\DeviceAlarm\Model\DeviceAlarm as Model;
use App\Domains\Shared\Job\JobAbstract as JobAbstractShared;

abstract class JobAbstract extends JobAbstractShared
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
    public function middleware()
    {
        return [(new WithoutOverlapping((string)$this->id))->expireAfter(30)];
    }

    /**
     * @return \App\Domains\DeviceAlarm\Model\DeviceAlarm
     */
    protected function row(): Model
    {
        return Model::query()->selectPointAsLatitudeLongitude()->findOrFail($this->id);
    }
}
