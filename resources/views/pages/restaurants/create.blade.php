<x-layout>
    <form action="{{ route('store.restaurant') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-8 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="dash_head">{{ __('sentence.addrestaurant') }}</h6>
                            <div class="row row-cols-1  ">
                                <x-form.input name="name" wire:model="name" label="{{ __('sentence.title') }} *"
                                    autofocus required />
                            </div>

                            <div class="row row-cols-1  ">
                                <x-form.input name="email" label="Email" label="{{ __('sentence.email') }} *"
                                    autofocus required />
                            </div>
                            <div class="row row-cols-1  ">
                                <x-form.input name="address[address]" wire:model="address"
                                    label="{{ __('sentence.restaurant_address') }} *" autofocus required />
                            </div>
                            <div class="row row-cols-2  ">
                                <x-form.input name="address[city]" wire:model="city"
                                    label="{{ __('sentence.restaurant_city') }}*" autofocus required />
                                <x-form.input name="address[post_code]" wire:model="post_code"
                                    label="{{ __('sentence.restaurant_post_code') }}*" autofocus required />
                            </div>
                            <div class="row row-cols-2  ">

                                <x-form.input name="number" wire:model="number"
                                    label="{{ __('sentence.restaurant_number') }}*" autofocus required />
                            </div>
                            <div class="row row-cols">
                                <x-form.input name="description" label="{{ __('sentence.description') }} *"
                                    value="" style="height: 186px" type="textarea" id="test" autofocus />
                            </div>
                            <div class="row row-cols-1">
                                <x-form.input name="image" wire:model="image" value="" type="file"
                                    label="{{ __('sentence.image_upload') }}" style="padding:50px;" />
                            </div>

                            <div class="row row-cols-1 tox-editor-container" wire:ignore>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-4">
                    <div class="card ">
                        <div class="card-body">
                            <div class="row row-cols-2">
                                {{-- <x-form.input id="longitude" name="address[longitude]" wire:model="longitude"
                                    label="Longitude" value="" required />
                                <x-form.input id="latitude" name="address[latitude]" wire:model="latitude"
                                    label="Latitude" value="" required /> --}}
                                <x-form.input id="merchantId" name="merchantId"
                                    label="{{ __('sentence.merchant_id') }}" value="" required />
                                <x-form.input id="secretKey" name="secretKey" label="{{ __('sentence.secret_key') }}"
                                    value="" required />

                                <x-form.input id="key_version" name="key_version"
                                    label="{{ __('sentence.key_version') }}" value="" required />

                                <x-form.input id="vat_number" name="vat_number" label="{{ __('sentence.vat_number') }}"
                                    value="" required />
                            </div>
                            {{-- <button class="btn btn-success" type="submit" style="float: right">
                                <i class="fa fa-save"></i> {{ __('sentence.save') }}
                            </button> --}}
                        </div>
                    </div>


                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="row row-cols-2">
                                {{-- <x-form.input id="longitude" name="address[longitude]" wire:model="longitude"
                                    label="Longitude" value="" required />
                                <x-form.input id="latitude" name="address[latitude]" wire:model="latitude"
                                    label="Latitude" value="" required /> --}}
                                <x-form.input id="sid" name="sid" label="SID" value="" required />
                                <x-form.input id="token" name="token" label="TOKEN" value="" required />

                                <x-form.input id="printer_id" name="printer_id"
                                    label="{{ __('sentence.printer_uid') }} " value="" required />
                                <x-form.input id="serial_number" name="serial_number"
                                    label="{{ __('sentence.serial_number_of_printer') }}" value="" required />

                                <div class="mb-3">
                                    <label for=""
                                        class="form-label">{{ __('sentence.delivery_option') }}</label>
                                    <select class="form-select " aria-label="Default select example" required
                                        name="delivery_option">
                                        <option selected>{{ __('sentence.select') }}
                                            {{ __('sentence.delivery_option') }}
                                        </option>
                                        <option value="both"> {{ __('sentence.both') }}</option>
                                        <option value="take_away">{{ __('sentence.takeaway') }}</option>
                                        <option value="home_delivery"> {{ __('sentence.homedelivery') }}</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label">{{ __('sentence.status') }}</label>
                                    <select class="form-select " aria-label="Default select example" required
                                        name="status">
                                        <option selected>{{ __('sentence.select_status') }}
                                            {{ __('sentence.select_status') }}
                                        </option>
                                        <option value="1"> {{ __('sentence.open') }}</option>
                                        <option value="0">{{ __('sentence.closed') }}</option>
                                    </select>
                                </div>
                            </div>
                            {{-- <button class="btn btn-success" type="submit" style="float: right">
                                <i class="fa fa-save"></i> {{ __('sentence.save') }}
                            </button> --}}
                        </div>
                    </div>

                    <div class="card mt-3 mb-3">
                        <div class="card-body">

                            <div class="row row-cols-2">
                                <div class="mb-3">
                                    <x-form.input name="business_name" wire:model="business_name" value=""
                                        label="{{ __('sentence.business_name') }} *" autofocus required />
                                </div>
                                <div class="mb-3">
                                    <x-form.input name="license_number" wire:model="license_number" value=""
                                        label="{{ __('sentence.license_number') }} *" autofocus required />
                                </div>
                                <div class="mb-3">
                                    <x-form.input name="business_location" wire:model="business_location"
                                        value="" label="{{ __('sentence.business_location') }} *" autofocus
                                        required />
                                </div>
                                <div class="mb-3">
                                    <x-form.input name="restaurent_code" wire:model="restaurent_code" value=""
                                        label="{{ __('sentence.restaurent_code') }} *" autofocus required />
                                </div>
                            </div>

                            {{-- <button class="btn btn-success" type="submit" style="float: right">
                                <i class="fa fa-save"></i> {{ __('sentence.save') }}
                            </button> --}}
                        </div>
                    </div>
                    <div class="card mt-3 mb-3">
                        <div class="card-body">

                            <div class="row row-cols-2">
                                <div class="mb-3">
                                    <x-form.input name="latitude" wire:model="latitude" value=""
                                        label="Latitude" autofocus />
                                </div>
                                <div class="mb-3">
                                    <x-form.input name="longitude" wire:model="longitude" value=""
                                        label="Longitude" autofocus />
                                </div>
                            </div>

                            <button class="btn btn-success" type="submit" style="float: right">
                                <i class="fa fa-save"></i> {{ __('sentence.save') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-layout>
