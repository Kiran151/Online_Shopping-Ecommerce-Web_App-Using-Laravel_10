<div class="tab-pane fade" id="return_orders" role="tabpanel" aria-labelledby="return_orders-tab">
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">Your Orders</h3>
        </div>
        <div class="card-body">
            <div class="">
                <table class="table table-striped" style="background: #ddd">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Invoice</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $orders = App\Models\Order::where('user_id', Auth::user()->id)
                                ->where('return_order', 1)
                                ->orWhere('return_order', 2)
                                ->paginate(5);
                        @endphp
                        @foreach ($orders as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->invoice_no }}</td>
                                <td>{{ '$' . $item->amount }}</td>
                                <td>{{ $item->order_date }}</td>
                                <td>{{ $item->payment_method }}</td>
                                <td>
                                    <div class="d-flex">
                                        @if ($item->return_order == '1')
                                            <span class="badge rounded-pill  bg-danger">pending</span>
                                        @else
                                            <span class="badge rounded-pill  bg-success">success</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('order.view', $item->id) }}"
                                            class="btn-small text-warning me-2">View</a>
                                        <a href="{{ route('order.invoice', $item->id) }}"
                                            class="btn-small text-primary">Download</a>
                                    </div>

                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
                {{ $orders->links('frontend.custom_pagination') }}

            </div>
        </div>
    </div>
</div>
