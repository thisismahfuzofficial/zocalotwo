<x-profile>
    <div class="php-email-form mt-0" data-aos="fade-up" data-aos-delay="200">
        <table class="table">
            <tr>
                <th>#id</th>
                <th>Order Date</th>
                <th>Delivery</th>
                <th>Total</th>
                <th>View</th>
            </tr>
            @foreach ($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->created_at->format('d-M-Y') }}, </td>
                    <td>{{ $order->time_option }}</td>
                    <td>{{ $order->total }}€</td>
                    <td><a href="{{ route('invoice', $order) }}" class="btn btn-danger">View</a></td>
                </tr>
            @endforeach

        </table>
        {{ $orders->onEachSide(5)->links('vendor.pagination.bootstrap-5') }}
    </div>
</x-profile>
