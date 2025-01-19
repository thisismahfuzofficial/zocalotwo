<x-layout>
    {{-- @dd($customer->role->name ?? '') --}}
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        <form action="{{ route('customers.update', $customer) }}" method="post">
            @csrf
            @method('put')
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-8 mb-4">

                        <div class="card">
                            <div class="card-body">
                                <h6 class="dash_head">{{ __('sentence.customerdetails') }}</h6>

                                <div class="row row-cols-2">
                                    <x-form.input name="name" label="Name *" value="{{ $customer->name }}"
                                        required />

                                    <x-form.input name="email" label="Email" value="{{ $customer->email }}" />
                                   
                                    {{-- <x-form.input name="address" label="Address" value="{{ $customer->address }}" /> --}}
                                    <div class="col-md-6">
                                        <label class="control-label">{{ __('sentence.restaurant') }}</label>
                                        <select class="form-control select2" name="restaurant_id">
                                            <option value="">Select</option>
                                            @foreach ($restaurants as $restaurant)
                                                <option value="{{ $restaurant->id }}"
                                                    {{ $customer->restaurant_id == $restaurant->id ? 'selected' : '' }}>
                                                    {{ $restaurant->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">{{ __('sentence.role') }}</label>
                                        <select class="form-control select2" name="role_id">
                                            <option value="">Select</option>
                                            @foreach ($roles as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $customer->role_id == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <x-form.input name="phone" label="Phone *" value="{{ $customer->phone }}" />
                                    <x-form.input name="password" label="Password" type="password" />
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="">
                                    <button class="btn btn-success" type="submit" style="float: right">
                                        <i class="fa fa-save"></i> Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
        </form>
    </div>
</x-layout>
