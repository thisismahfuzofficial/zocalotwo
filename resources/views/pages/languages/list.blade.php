<x-layout>
    @push('styles')
        <style>
            .filter_row .srch_inner .srch_btn {
                width: inherit;
                background-color: transparent;
            }

            .filter_row .srch_inner .srch_btn:hover {
                background-color: transparent;
            }

            button:hover {
                background-color: transparent;
            }

            .srch_inner input[type="text"] {
                padding: 12px 20px 12px 75px;
            }
        </style>
    @endpush

    <div class="dashboard_content ps-0 mt-2">
        <div class="dashboard_content_inner">
            <div class="d-flex justify-content-between mt-1 mb-4">
                <div style="float">
                    <a href="{{ route('languages.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>{{__('sentence.create_new')}} </a>
                </div>
            </div>

            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif

            <div class="view_box list_view_box active_view">
                <div class="all_tab_panel" data-tab-parent="tabgroup1">
                    <div class="tab_panel active">
                        <div class="panel_inner panel_inner_scrollable">
                            <table class="list_table all">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('sentence.key') }}</th>
                                        <th scope="col" class="text-center">{{ __('sentence.english') }}</th>
                                        <th scope="col">{{ __('sentence.french') }}</th>
                                        <th scope="col">{{ __('sentence.createdat') }}</th>
                                        <th scope="col">{{ __('sentence.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($languages as $key => $language)
                                        <tr>
                                            
                                            <td class="text-center">{{ $language->key }}</td>
                                            <td>{{ $language->english }}</td>
                                            <td>{{ $language->french }}</td>
                                            <td>{{ $language->created_at }}</td>
                                            <td class="d-flex">
                                                <a class="btn btn-primary btn-sm me-2" href="{{ route('languages.edit', $language) }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                {{-- <x-actions.delete :action="route('categories.destroy', $category)" /> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            
                        </div>
                    </div>

                </div>
            </div>

            {{ $languages->links() }}
        </div>
    </div>

    <x-filter :url="route('languages.index')">
        <h6 class="mb-4">{{__('sentence.search')}} </h6>
        <div class="row g-1">
            <div class="col-md-4">
                <x-form.input type="select" name="search[column]" :value="@request()->search['column']" label="Field" :options="[
                    'key' => 'key',
                    'english' => 'english',
                    'french' => 'key',
                ]" />
            </div>
            <div class="col-md-8">
                <x-form.input type="text" name="search[query]" :value="@request()->search['query']" label="Search" />
            </div>
        </div>
        <hr>
        <h6 class="mb-4">{{ __('sentence.filter') }}</h6>
        <div class="row row-cols-2 g-1">

            <x-form.input type="date" name="date[created_at][from]" label="From" :value="@request()->date['created_at']['from']" />
            <x-form.input type="date" name="date[created_at][to]" label="To" :value="@request()->date['created_at']['to']" />
        </div>
        <hr>

    </x-filter>



</x-layout>
