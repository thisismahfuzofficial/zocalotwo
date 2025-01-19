{{-- @dd($product) --}}
<x-layout>
    @push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.css" rel="stylesheet">
    @endpush
    @push('script')
        <script>
            const addRow = () => {
                const index = $('#priscription-products').children().length
                const row = `<tr  class="table-row">
                <input type="hidden" name="option[${index}][id]"  value="">
                            <td>
                                <x-form.input name="option[${index}][name]" label="{{ __('sentence.option_name') }}" value=""  required/>
                            </td>
                            <td>
                                <x-form.input name="option[${index}][price]" label="{{ __('sentence.price') }}" value="" required />
                            </td>
                            

                            <td class="text-center">
                                <button type="button"
                                    class="btn btn-danger btn-sm h-auto remove-row" onclick="removeRow(this)"> <i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>`;
                $('#priscription-products').append(row)
                const baseUrl = "{{ env('VITE_API_URI', 'https://pos.sohojware.com') }}";
                const addHeaders = function(xhr) {
                    xhr.setRequestHeader('x-secret-key', "{{ env('PASSWORD') }}");
                };
                $('.products-ajax').select2({
                    ajax: {
                        url: `${baseUrl}/api/products`,

                        processResults: function(data) {
                            // Transforms the top-level key of the response object from 'items' to 'results'
                            return {
                                results: data
                            }
                        },
                        beforeSend: addHeaders
                    }
                });
            }

            const removeRow = (el) => {
                el.closest('tr').remove();
            }
        </script>
    @endpush
    <form action="{{ route('update.product', $product) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-8 mb-4">

                    <div class="card">
                        <div class="card-body">
                            <h6 class="dash_head">{{ __('sentence.productdetails') }}</h6>

                            <div class="row row-cols-1">
                                <x-form.input name="name" wire:model="name" label="{{ __('sentence.product_name ') }} *"
                                    value="{{ $product->name }}" autofocus required />
                            </div>
                            {{-- <div class="row row-cols-1">
                                <x-form.input name="flavors" label="Product flavors *"
                                    value="{{ $product->flavors }}" autofocus />
                            </div> --}}
                            <div class="row row-cols-1">

                            </div>

                            <div class="row row-cols">
                                <x-form.input name="description" label="{{ __('sentence.description') }} *" value="{{ $product->text }}"
                                    style="height: 130px" type="textarea" id="test" autofocus />
                            </div>

                            <select class="form-select " aria-label="Default select example" name="category">
                                <option selected>{{ __('sentence.select') }} {{ __('sentence.category') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                @endforeach

                            </select>


                        </div>
                    </div>
                    <div class="card mt-4">
                        <div class="card-body">
                            <h6 class="dash_head">{{ __('sentence.productmade') }}</h6>


                            <div class="row row-cols">
                                {{-- <x-form.input name="composition" label="Composition *"
                                    value="{{ $product->composition }}" style="height: 130px" type="textarea"
                                    id="test" autofocus /> --}}
                                    <label class="mb-3" for=""> {{ __('sentence.composition') }}</label>
                                    <textarea name="composition" id="summernote" cols="30" rows="10">{{ $product->composition }}</textarea>
                            </div>
                            <div class="row row-cols-1">
                                <x-form.input name="allergenes" wire:model="allergenes" label="{{ __('sentence.allergenes') }} *"
                                    value="{{ $product->allergenes }}" autofocus />
                            </div>
                        </div>
                    </div>



                </div>

                <div class="col-md-4">
                    <div class="card ">
                        <div class="card-body">
                            <div class="row row-cols-1">
                                <x-form.input name="image" wire:model="image" value="{{ $product->image }}"
                                    type="file" label="{{ __('sentence.product_image_upload') }}" style="padding:50px;" />
                            </div>
                        </div>
                    </div>
                    <div class="card mt-4 mb-2">
                        <div class="card-body">
                            <table class="table table-bordered ">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            {{__('sentence.optionname')}}
                                        </th>

                                        <th class="text-center w-auto">
                                            {{__('sentence.price')}}
                                        </th>

                                        <th class="text-center ">
                                            {{__('sentence.action')}}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="priscription-products">
                                    @foreach ($product_options as $option)
                                        <input type="hidden" name="option[{{ $loop->iteration }}][id]"
                                            value="{{ $option->id }}">
                                        <tr class="table-row">
                                            <td style="width:300px">
                                                <input type="text" name="option[{{ $loop->iteration }}][name]"
                                                    value="{{ $option->option_name }}">
                                            </td>
                                            <td style="width:300px">
                                                <input type="text" name="option[{{ $loop->iteration }}][price]"
                                                    value="{{ $option->option_price }}">
                                            </td>
                                            <td class="text-center">
                                                
                                                <button class="btn btn-sm btn-danger h-auto" form="deleteOption" onclick="return confirm('Are you sure')"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="10" class="text-end">
                                            <button onclick="addRow()" type="button"
                                                class="btn btn-primary btn-sm h-auto add-row"> <i
                                                    class="fa fa-plus"></i></button>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>

                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="row row-cols-1">
                                <x-form.input id="sequence"  name="sequence"  label="{{ __('sentence.sequency') }}  *"
                                    value="{{ $product->sequency }}" required />
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="row row-cols-1">
                                <x-form.input id="tax"  name="tax"  label="{{ __('sentence.tax') }} "
                                    value="{{ $product->tax }}" />
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="row row-cols-1">

                                <x-form.input id="price" name="price" wire:model="price" label="{{ __('sentence.price') }} *"
                                value="{{ number_format($product->price, 2) }}"  required />

                                <x-form.input id="status" name="status" wire:model="status" label="{{ __('sentence.status') }} *"
                                value="{{ ($product->status) }}"  />
                                

                            </div>
                            <button class="btn btn-success" type="submit" style="float: right">
                                <i class="fa fa-save"></i> {{ __('sentence.save') }}
                            </button>
                        </div>
                    </div>

                </div>





            </div>
    </form>
    @if(count($product_options) > 0 )
    <form action="{{route('delete.option', $option)}}" method="post" class="d-inline" id="deleteOption">
        @csrf
        @method('delete')
    </form> 
    @endif
    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.js"></script>


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
