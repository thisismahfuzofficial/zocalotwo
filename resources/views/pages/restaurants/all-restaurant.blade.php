<x-layout>

    <div class="dashboard_content ps-0 mt-2">
        <div class="dashboard_content_inner">
            <div class="d-flex justify-content-between mt-1 mb-3">
                <div style="float"class="mt-2">
                    <a href="{{ route('create.restaurant') }}" class="btn btn-primary"><i class="fa fa-plus"></i> {{__('sentence.addnewrestaurant')}}</a>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{__('sentence.image')}}</th>
                        <th scope="col">{{__('sentence.name')}}</th>
                        <th scope="col">{{__('sentence.vat_number')}}</th>
                        <th scope="col">{{__('sentence.business_name')}}</th>
                        <th scope="col">{{__('sentence.license_number')}}</th>
                        <th scope="col">{{__('sentence.restaurent_code')}}</th>
                        <th scope="col">{{ __('sentence.delivery_option') }}</th>
                        <th scope="col">{{__('sentence.action')}}</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($restaurants as $key => $restaurant)
                    
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>
                                <img class="" height="100" width="100"
                                    src="{{ $restaurant->image ? Storage::url($restaurant->image) : asset('images/new/no-image.jpg') }}"
                                    alt="">
                            </td>
                            <td>{{ $restaurant->name ?? '' }}</td>
                            <td>{{ $restaurant->vat_number }}</td>
                            <td>{{ $restaurant->business_name }}</td>
                            <td>{{ $restaurant->license_number }}</td>
                            <td>{{ $restaurant->restaurent_code }}</td>
                            <td>{{ $restaurant->delivery() }}</td>
                            <td class="">

                                <a class="btn btn-sm btn-primary" href="{{ route('edit.restaurant', $restaurant) }}"><i
                                        class="fa fa-edit"></i></a>
                                <x-actions.delete :action="route('delete.restaurant', $restaurant)" />
                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>

    </div>
</x-layout>
