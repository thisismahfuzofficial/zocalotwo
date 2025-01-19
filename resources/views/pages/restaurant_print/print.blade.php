<x-layout>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4 mt-5">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('sentence.request_to_print') }}</h5>
                        <form method="post" action="{{ route('resto_print.restaurant.order', $restaurant) }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fromDate" class="form-label">{{ __('sentence.from_date') }}</label>
                                    <input type="date" class="form-control" id="fromDate" name="fromDate"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="toDate" class="form-label">{{ __('sentence.to_date') }}</label>
                                    <input type="date" class="form-control" id="toDate" name="toDate"
                                        required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('sentence.send') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12">
                <div class="card mb-4 mt-5">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('sentence.request_to_print') }}</h5>
                        <form method="post" action="{{ route('resto_print.restaurant.order.user', $restaurant) }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fromDate" class="form-label">{{ __('sentence.from_date') }}</label>
                                    <input type="date" class="form-control" id="fromDate" name="fromDate"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="toDate" class="form-label">{{ __('sentence.to_date') }}</label>
                                    <input type="date" class="form-control" id="toDate" name="toDate"
                                        required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('sentence.send') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>