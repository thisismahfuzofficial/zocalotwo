<x-layout>
    @push('styles')
        <!-- include libraries(jQuery, bootstrap) -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

        <!-- include summernote css/js -->
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    @endpush

    <form action="{{ route('pages.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="container mt-3">

            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-body ">
                        <h6 class="dash_head">{{ __('sentence.addpage') }}</h6>
                        <div class="row row-cols-1">
                            <x-form.input name="title" wire:model="name" label="Title *" autofocus required />
                        </div>
                        <div class="row row-cols px-2">
                            <form method="post">
                                <textarea id="summernote" name="body"></textarea>
                            </form>
                        </div>
                        <button class="btn btn-success" type="submit" style="float: right">
                            <i class="fa fa-save"></i> {{ __('sentence.save') }}
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>

    @push('script')
        <script>
            $(document).ready(function() {
                $('#summernote').summernote({
                    placeholder: 'enter your body content here',
                    tabsize: 2,
                    height: 300
                });

            });
        </script>
    @endpush
</x-layout>
