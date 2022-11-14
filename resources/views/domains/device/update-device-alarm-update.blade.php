@extends ('domains.device.update-layout')

@section ('content')

<form method="post">
    <input type="hidden" name="_action" value="updateDeviceAlarmUpdate" />

    <div class="box p-5 mt-5">
        <div class="p-2">
            <x-select name="type" id="device-update-device-alarm-update-type" :options="$types" :label="__('device-update-device-alarm-update.type')" readonly disabled></x-select>
        </div>
    </div>

    @include ('domains.device.molecules.update-device-alarm-create-update')

    <div class="box p-5 mt-5">
        <div class="text-right">
            <a href="javascript:;" data-toggle="modal" data-target="#delete-modal" class="btn btn-outline-danger mr-5">{{ __('device-update-device-alarm-update.delete-button') }}</a>
            <button type="submit" class="btn btn-primary" data-click-one>{{ __('device-update-device-alarm-update.save') }}</button>
        </div>
    </div>
</form>

@include ('molecules.delete-modal', [
    'action' => 'updateDeviceAlarmDelete'
])

@stop
