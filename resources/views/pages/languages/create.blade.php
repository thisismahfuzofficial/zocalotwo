<x-layout>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif

    <div class="card mt-4">
        <div class="card-body">
            <form action="{{ route('languages.store') }}" method="POST">
                @csrf
                <div class="">
                    <h3>{{ __('sentence.language') }} </h3>
                    <div class="row">
                        <div class="col-md-2 item-content">
                            <div class="mb-3">
                                <label for="inputName1" class="form-label">Key</label>
                                <input type="text" class="form-control" id="inputName1" placeholder="Key"
                                    data-name="key" name="key" autofocus>
                            </div>
                        </div>
                        <div class="col-md-5 item-content">
                            <div class="">
                                <label for="english" class="form-label">English</label>
                                <input type="text" class="form-control" id="english" placeholder="English"
                                    data-name="english" name="english" autofocus>
                            </div>
                        </div>
                        <div class="col-md-5 item-content">
                            <div class="">
                                <label for="french" class="form-label">French</label>
                                <input type="text" class="form-control" id="french" placeholder="french"
                                    data-name="french" name="french" autofocus>
                            </div>
                        </div>
                        <div class="repeater-remove-btn">
                            <button type="submit" class="btn btn-success" style="height: auto;">{{ __('sentence.save') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-layout>
