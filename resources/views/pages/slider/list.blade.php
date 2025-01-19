<x-layout>


    <div class="dashboard_content ps-0 mt-2">
        <div class="dashboard_content_inner">
                <div class="d-flex justify-content-between mt-1 mb-3">
                    <div style="float"class="mt-2">
                        <a href="{{ route('slider.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>
                            Add New Slider</a>
                    </div>
                </div>
            <table class="table">
                <thead>
                    <tr>

                        <th scope="col">#</th>
                        <th scope="col">{{ __('sentence.image') }}</th>
                        <th scope="col">Heading</th>
                        <th scope="col">Heading End</th>
                        <th scope="col">Title</th>
                        <th scope="col" class="text-center">{{ __('sentence.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sliders as $key => $slider)
                       
                        <tr>


                            <th scope="row">{{ $key + 1 }}</th>
                            <td>
                                <img class="" height="100" width="100" src="{{ Storage::url($slider->image) }}"
                                    alt="">
                            </td>
                            <td>{{ $slider->heading }}</td>
                            <td>{{ $slider->heading_end }}</td>
                            <td>{{ $slider->title }}</td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-primary" href="{{ route('edit.slider', $slider) }}"><i
                                        class="fa fa-edit"></i></a>
                                <x-actions.delete :action="route('delete.slider', $slider)" />
                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>

    </div>

</x-layout>

