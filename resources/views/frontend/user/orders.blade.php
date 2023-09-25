<div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
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
                            $orders = App\Models\Order::where('user_id', Auth::user()->id)->paginate(5);
                        @endphp
                        @foreach ($orders as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->invoice_no }}</td>
                                <td>{{ '$' . $item->amount }}</td>
                                <td>{{ $item->order_date }}</td>
                                <td>{{ $item->payment_method }}</td>
                                <td>
                                    @if ($item->status == 'pending')
                                        <span class="badge rounded-pill bg-danger">Pending</span>
                                    @elseif($item->status == 'confirmed')
                                        <span
                                            class="badge rounded-pill  bg-primary text-white">Confirmed</span>
                                    @elseif($item->status == 'processing')
                                        <span
                                            class="badge rounded-pill  bg-warning  text-white">Processing</span>
                                    @elseif($item->status == 'delivered')
                                       <div class="d-flex">
                                        <span
                                        class="badge rounded-pill  bg-success">Delivered</span>
                                        @if ($item->return_order=='1')
                                        <span
                                        class="badge rounded-pill  bg-danger">Return</span>
                                        @endif
                                       </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{route('order.view',$item->id)}}" class="btn-small text-warning me-2">View</a>
                                        <a href="{{route('order.invoice',$item->id)}}" class="btn-small text-primary">Download</a>
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
