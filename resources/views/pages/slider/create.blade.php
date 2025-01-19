
<x-layout>

    <form action="{{route('slider.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-8 mb-4">

                    <div class="card">
                        <div class="card-body">
                            <h6 class="dash_head">Slider Image</h6>

                            <div class="row row-cols-2">
                                <x-form.input name="heading"  label="Heading *" value="" autofocus
                                    required />
                                <x-form.input name="heading_end"  label="Heading End *" value="" autofocus
                                     />
                            </div>

                            <div class="row row-cols-1">
                                <x-form.input name="image" value="" type="file"
                                label="Drag image to upload For background" style="padding:50px;" />
                            </div>
                            
                            <div class="row row-cols-1">
                                <x-form.input name="title"  label="Title *" value="" autofocus
                                    required />
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
