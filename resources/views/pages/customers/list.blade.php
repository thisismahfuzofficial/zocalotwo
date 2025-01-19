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

            .card-header-color {
                background-color: #205E61 !important;
                color: #fff !important;
            }
        </style>
    @endpush
    <div class="dashboard_content ps-0 mt-2">
        <div class="dashboard_content_inner">
            <div class="d-flex justify-content-between mt-1 mb-3">
                <div style="float"class="mt-2">
                    <a href="{{ route('customers.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add new
                        customer</a>

                    <a href="{{ route('export.users') }}" class="btn btn-success">Export Customer</a>

                    {{-- @if (request()->has('due_customer') && request()->input('due_customer') == 1)
                        <a href="{{ route('customers.index') }}" class="btn btn-success"><i
                                class="fa-solid fa-reply-all"></i> All Customers</a>
                    @else
                        <a href="{{ route('customers.index', ['due_customer' => 1]) }}" class="btn btn-danger"><i
                                class="fas fa-money-bill"></i> Due Customers</a>
                    @endif --}}
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

                            @if (request()->view == 'list')
                                <x-customers.table.list :customers="$customers" />
                            @else
                                <x-customers.grid.deck :customers="$customers" />
                            @endif


                            {{ $customers->onEachSide(1)->links() }}

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <x-filter :url="route('customers.index')">
        <h6 class="mb-4">{{ __('sentence.search') }} </h6>
        <div class="row g-1">
            <div class="col-md-4">
                <x-form.input type="select" name="search[column]" :value="@request()->search['column']" label="Field" :options="[
                    'name' => 'Name',
                ]" />
            </div>
            <div class="col-md-8">
                <x-form.input type="text" name="search[query]" :value="@request()->search['query']" label="Search" />
            </div>
        </div>

    </x-filter>
</x-layout>
