<x-layout>
    {{-- @dd($category->parent_id) --}}
    @if (session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
    <div class="card mt-4">
        <div class="card-body">
            <form action="{{ route('languages.update', $language) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div>
                    <h3>{{ __('sentence.editcategory') }}</h3>
                    <div class="row">
                        <div class="col-md-4 item-content">
                            <div class="">
                                <label for="key" class="form-label">key</label>
                                <input type="text" class="form-control" id="key" placeholder="key"
                                    data-name="key" name="key" value="{{$language->key}}">
                            </div>
                        </div>
                        <div class="col-md-4 item-content">
                            <div class="">
                                <label for="english" class="form-label">English</label>
                                <input type="text" class="form-control" id="english" placeholder="English"
                                    data-name="english" name="english" value="{{$language->english}}" autofocus>
                            </div>
                        </div>
                        <div class="col-md-4 item-content">
                            <div class="">
                                <label for="french" class="form-label">French</label>
                                <input type="text" class="form-control" id="french" placeholder="french"
                                    data-name="french" name="french"  value="{{$language->french}}" autofocus>
                            </div>
                        </div>
                        <div class="repeater-remove-btn" style="margin-top:10px">
                            <button type="submit" class="btn btn-success"
                                style="height: auto;">{{ __('sentence.submit') }}</button>
                            <a href="{{ route('languages.index') }}"
                                class="btn btn-danger">{{ __('sentence.cancel') }}</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-layout>
