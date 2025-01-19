<x-layout>
    @push('style')
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

        <!-- Summernote CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">

        <style>
            .note-frame {
                border-radius: 0px !important;
            }
        </style>
    @endpush
    <form action="{{ route('time_schedules.update', $time_schedule) }}" method="post">
        @csrf
        @method('PUT')
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-12">
                    <select class="form-select " aria-label="Default select example" name="restaurant">
                        <option selected>{{ __('sentence.select') }} {{ __('sentence.category') }} </option>
                        @foreach ($restaurants as $restaurant)
                            <option @if ($time_schedule->restaurant_id == $restaurant->id) selected @endif value="{{ $restaurant->id }}">
                                {{ $restaurant->name }}</option>
                        @endforeach

                    </select>
                </div>
                <div class="col-md-12 mt-2">
                    <label class="mb-3" for=""> {{ __('sentence.time_schedule') }}</label>
                    <textarea name="time_schedule" id="summernote" cols="30" rows="10">{{ $time_schedule->time_schedule }}</textarea>
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Popper.js and Bootstrap 4 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <!-- Summernote JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#summernote').summernote({
                    height: 200, // Set the height of the editor
                    placeholder: 'Write your content here...',
                    toolbar: [
                        // Customizing toolbar options
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                });
            });
        </script>
    @endpush
</x-layout>
