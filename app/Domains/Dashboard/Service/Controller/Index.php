<?php declare(strict_types=1);

namespace App\Domains\Dashboard\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Alarm\Model\Alarm as AlarmModel;
use App\Domains\Alarm\Model\Collection\Alarm as AlarmCollection;
use App\Domains\AlarmNotification\Model\AlarmNotification as AlarmNotificationModel;
use App\Domains\AlarmNotification\Model\Collection\AlarmNotification as AlarmNotificationCollection;
use App\Domains\Position\Model\Collection\Position as PositionCollection;
use App\Domains\Trip\Model\Collection\Trip as TripCollection;
use App\Domains\Trip\Model\Trip as TripModel;

class Index extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth)
    {
        $this->filters();
    }

    /**
     * @return void
     */
    protected function filters(): void
    {
        $this->request->merge([
            'user_id' => $this->auth->preference('user_id', $this->request->input('user_id')),
            'vehicle_id' => $this->auth->preference('vehicle_id', $this->request->input('vehicle_id')),
            'device_id' => $this->auth->preference('device_id', $this->request->input('device_id')),
        ]);
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'users' => $this->users(),
            'users_multiple' => $this->usersMultiple(),
            'user' => $this->user(false),
            'user_empty' => $this->userEmpty(),
            'vehicles' => $this->vehicles(),
            'vehicles_multiple' => $this->vehiclesMultiple(),
            'vehicle' => $this->vehicle(false),
            'vehicle_empty' => $this->vehicleEmpty(),
            'devices' => $this->devices(),
            'devices_multiple' => $this->devicesMultiple(),
            'device' => $this->device(false),
            'device_empty' => $this->deviceEmpty(),
            'trips' => $this->trips(),
            'trip' => $this->trip(),
            'trip_next_id' => $this->tripNextId(),
            'trip_previous_id' => $this->tripPreviousId(),
            'trip_alarm_notifications' => $this->tripAlarmNotifications(),
            'positions' => $this->positions(),
            'alarms' => $this->alarms(),
            'alarm_notifications' => $this->alarmNotifications(),
        ];
    }

    /**
     * @return \App\Domains\Trip\Model\Collection\Trip
     */
    protected function trips(): TripCollection
    {
        if ($this->vehicle() === null) {
            return new TripCollection();
        }

        return $this->cache(
            fn () => TripModel::query()
                ->selectSimple()
                ->byVehicleId($this->vehicle()->id)
                ->whenDeviceId($this->device()?->id)
                ->listSimple()
                ->limit(50)
                ->get()
        );
    }

    /**
     * @return ?\App\Domains\Trip\Model\Trip
     */
    protected function trip(): ?TripModel
    {
        return $this->cache(
            fn () => $this->trips()->firstWhere('id', $this->request->input('trip_id'))
                ?: $this->trips()->first()
        );
    }

    /**
     * @return ?int
     */
    protected function tripNextId(): ?int
    {
        if ($this->trip() === null) {
            return null;
        }

        return $this->cache(
            fn () => $this->trips()
                ->reverse()
                ->firstWhere('start_utc_at', '>', $this->trip()->start_utc_at)
                ?->id
        );
    }

    /**
     * @return ?int
     */
    protected function tripPreviousId(): ?int
    {
        if ($this->trip() === null) {
            return null;
        }

        return $this->cache(
            fn () => $this->trips()
                ->firstWhere('start_utc_at', '<', $this->trip()->start_utc_at)
                ?->id
        );
    }

    /**
     * @return \App\Domains\AlarmNotification\Model\Collection\AlarmNotification
     */
    protected function tripAlarmNotifications(): AlarmNotificationCollection
    {
        if ($this->trip() === null) {
            return new AlarmNotificationCollection();
        }

        return $this->cache(
            fn () => AlarmNotificationModel::query()
                ->byTripId($this->trip()->id)
                ->withAlarm()
                ->list()
                ->get()
        );
    }

    /**
     * @return \App\Domains\Position\Model\Collection\Position
     */
    protected function positions(): PositionCollection
    {
        if ($this->trip() === null) {
            return new PositionCollection();
        }

        return $this->cache(
            fn () => $this->trip()
                ->positions()
                ->withCity()
                ->list()
                ->get()
        );
    }

    /**
     * @return \App\Domains\Alarm\Model\Collection\Alarm
     */
    protected function alarms(): AlarmCollection
    {
        if ($this->vehicle() === null) {
            return new AlarmCollection();
        }

        return $this->cache(
            fn () => AlarmModel::query()
                ->byVehicleId($this->vehicle()->id)
                ->enabled()
                ->list()
                ->get()
        );
    }

    /**
     * @return \App\Domains\AlarmNotification\Model\Collection\AlarmNotification
     */
    protected function alarmNotifications(): AlarmNotificationCollection
    {
        if ($this->vehicle() === null) {
            return new AlarmNotificationCollection();
        }

        return $this->cache(
            fn () => AlarmNotificationModel::query()
                ->byVehicleId($this->vehicle()->id)
                ->whereClosedAt(false)
                ->withAlarm()
                ->withVehicle()
                ->withPosition()
                ->withTrip()
                ->list()
                ->get()
        );
    }
}
