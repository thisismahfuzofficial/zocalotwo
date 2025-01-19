<x-layout>
    @push('style')
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">

        <style>
            .note-frame {
                border-radius: 0px !important;
            }
        </style>
    @endpush
    <form action="{{ route('time_schedules.store') }}" method="post">
        @csrf
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-12">
                    <select class="form-select " aria-label="Default select example" name="restaurant">
                        <option selected>{{ __('sentence.select') }} {{ __('sentence.category') }} </option>
                        @foreach ($restaurants as $restaurant)
                            <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                        @endforeach

                    </select>
                </div>
                <div class="col-md-12 mt-2">
                    <label class="mb-3" for=""> {{ __('sentence.time_schedule') }}</label>
                    <textarea name="time_schedule" id="summernote" cols="30" rows="10"></textarea>
                </div>
                <div class="col-md-12 mt-3">
                    <button class="btn btn-success" type="submit">
                        <i class="fa fa-save"></i> {{ __('sentence.save') }}
                    </button>
                </div>
            </div>
        </div>
    </form>

    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>


        <script>
            $(document).ready(function() {
                $('#summernote').summernote({
                    height: 200, // Set the height of the editor
                    placeholder: 'Write your content here...'
                });
            });
        </script>
    @endpush
</x-layout>
