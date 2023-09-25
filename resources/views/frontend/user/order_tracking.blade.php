<div class="tab-pane fade" id="track-orders" role="tabpanel"
aria-labelledby="track-orders-tab">
<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Orders tracking</h3>
    </div>
    <div class="card-body contact-from-area">
        <p>To track your order please enter your Invoice ID in the box below and press
            "Track" button. This was given to you on your receipt and in the
            confirmation email you should have received.</p>
        <div class="row">
            <div class="col-lg-8">
                <form class="contact-form-style mt-30 mb-50" action="{{route('order.track')}}"
                    method="post">
                    @csrf
                    <div class="input-style mb-20">
                        <label>Invoice ID</label>
                        <input name="invoice_no"
                            placeholder="Invoice number"
                            type="text" />
                    </div>
                    <button class="submit submit-auto-width"
                        type="submit">Track</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>