<x-layout>
    {{-- @dd($category->parent_id) --}}
    <div class="card mt-4">
        <div class="card-body">
            <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div>
                    <h3>{{ __('sentence.editcategory') }}</h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="disabledTextInput" class="form-label">{{ __('sentence.name') }}</label>
                            <input type="text" id="disabledTextInput" class="form-control" placeholder="Category Name"
                                name="name" value="{{ $category->name }}">
                        </div>

                        <div class="col-md-3 item-content">
                            <label class="control-label md-2">{{ __('sentence.category') }} </label>
                            <select class="form-control select2" name="parent_id">
                                <option value="">Select</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $category->parent_id == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-md-3 item-content">
                            <div class="mb-3">
                                <label for="sequency" class="form-label">{{ __('sentence.sequency') }}</label>
                                <input type="number" class="form-control" id="sequency" placeholder="Sequency"
                                    data-name="sequency" name="sequency" value="{{ $category->sequency }}">
                            </div>
                        </div>

                        <div class="col-md-12 item-content mb-3">
                            <label class="control-label">{{ __('sentence.category_description') }}</label>
                            <x-form.input name="description" value="{{ $category->description }}" style="height: 130px"
                                type="textarea" id="test" />
                        </div>
                        <div class="repeater-remove-btn">
                            <button type="submit" class="btn btn-success"
                                style="height: auto;">{{ __('sentence.submit') }}</button>
                            <a href="{{ route('categories.index') }}"
                                class="btn btn-danger">{{ __('sentence.cancel') }}</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-layout>
