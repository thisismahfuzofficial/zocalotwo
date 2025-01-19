<div class="card">
    <div class="card-header {{ $customer->orders_sum_due > 0 ? 'bg-danger text-light' : 'card-header-color' }}">

        <div class="d-flex justify-content-between">
            <a class=""
                href="{{ route('orders.index', ['search[column]' => 'customer.name', 'search[query]' => $customer->name]) }}">

                <h5>
                    {{ $customer->name }} {{ $customer->l_name }}
                </h5>
            </a>

        </div>

        <a href="tel:{{ $customer->phone }}">
            {{ $customer->phone }}
        </a>


    </div>
    <div class="card-body">
        @if ($customer->email)
            <a href="mailto:{{ $customer->email }}"><strong>Email:</strong> {{ $customer->email }}</a>
        @endif
        <p class="mb-2"><strong>Role : </strong>{{ $customer->role->name ?? 'user' }}</p>
    </div>
    <div class="card-footer bg-white d-flex justify-content-between align-items-center">

        <div>
            <a class="btn btn-sm btn-primary me-2" href="{{ route('customers.edit', $customer) }}"><i
                    class="fa fa-edit"></i></a>

            <x-actions.delete :action="route('customers.destroy', $customer)" />
        </div>


    </div>
</div>
