<x-layout>
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        <form action="{{ route('customers.store') }}" method="POST">
            @csrf
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-8 mb-4">

                        <div class="card">
                            <div class="card-body">
                                <h6 class="dash_head">{{ __('sentence.customerdetails') }}</h6>

                                <div class="row row-cols-2">
                                    <x-form.input name="name" label="Name *" required />
                                    <x-form.input name="phone" label="Phone *" />

                                    <x-form.input name="email" label="Email" />

                                    <x-form.input name="password" label="Password" type="password" />
                                    {{-- <x-form.input name="gender" value="{{ old('gender') }}" type="select"
                                        label="Gender" :options="['male' => 'Male', 'female' => 'Female']" /> --}}

                                    <div class="">
                                        <label class="control-label">{{ __('sentence.restaurant') }}</label>
                                        <select class="form-control select2 mt-2" name="restaurant_id">
                                            <option value="">Select</option>
                                            @foreach ($restaurants as $restaurant)
                                                <option value="{{ $restaurant->id }}">
                                                    {{ $restaurant->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="">
                                        <label class="control-label">{{ __('sentence.role') }}</label>
                                        <select class="form-control select2 mt-2" name="role_id">
                                            <option value="">Select</option>
                                            @foreach ($roles as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                </div>
                                <div class="row row-cols-1 mt-2">
                                    <x-form.input name="address" label="Address *" />
                                </div>

                                {{-- <div class="card-footer"> --}}
                                <div class="">
                                    <button class="btn btn-success" type="submit" style="float: right">
                                        <i class="fa fa-save"></i> {{ __('sentence.save') }}
                                    </button>
                                </div>
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-md-4">
                        <div class="card mt-4">
                            <div class="card-body">
                                <div class="row row-cols">

                                    <x-form.input name="discount" type="number"  min="0" max="12"
                                        label="Discount " value="0"  />

                                </div>
                            </div>
                        </div>
                        <div class="card mt-4">

                            <div class="card-footer">
                                <div class="d-grid">
                                    <button class="btn btn-success" type="submit" style="float: right">
                                        <i class="fa fa-save"></i> {{ __('sentence.save') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
        </form>
    </div>
</x-layout>
