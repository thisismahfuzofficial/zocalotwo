<x-layout>

    <div class="dashboard_content ps-0 mt-2">
        <div class="dashboard_content_inner">
            <div class="d-flex justify-content-between mt-1 mb-3">
                <div style="float"class="mt-2">
                    <a href="{{ route('time_schedules.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>
                        {{ __('sentence.time_schedule_create') }}</a>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ __('sentence.restaurant_name') }}</th>
                        <th scope="col">{{ __('sentence.time_schedule') }}</th>
                        <th scope="col">{{ __('sentence.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($time_schedules as $key => $time_schedule)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $time_schedule->restaurant ? $time_schedule->restaurant->name : '' }}</td>
                            <td>{!! $time_schedule->time_schedule !!}</td>
                            <td class="">

                                <a class="btn btn-sm btn-primary"
                                    href="{{ route('time_schedules.edit', $time_schedule) }}"><i class="fa fa-edit"></i></a>
                                <x-actions.delete :action="route('time_schedules.destroy', $time_schedule)" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-layout>
