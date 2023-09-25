<div class="tab-pane fade" id="account-detail" role="tabpanel"
aria-labelledby="account-detail-tab">
<div class="card">
    <div class="card-header">
        <h5>Account Details</h5>
    </div>
    <div class="card-body">
        <p>Already have an account? <a href="{{ route('login') }}">Log in
                instead!</a>
        </p>
        <form action="{{ route('update.user.profile') }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Name <span class="required">*</span></label>
                    <input required="" class="form-control" name="name"
                        type="text" value="{{ $data->name }}" />
                </div>
                <div class="form-group col-md-6">
                    <label>Username <span class="required">*</span></label>
                    <input required="" class="form-control" name="username"
                        value="{{ $data->username }}" />
                </div>

                <div class="form-group col-md-12">
                    <label>Email Address <span class="required">*</span></label>
                    <input required="" class="form-control" name="email"
                        type="email" value="{{ $data->email }}" />
                </div>
                <div class="form-group col-md-12">
                    <label>Phone <span class="required">*</span></label>
                    <input required="" class="form-control" name="phone"
                        type="number" value="{{ $data->phone }}" />
                </div>
                <div class="form-group col-md-12">
                    <label>Address<span class="required">*</span></label>
                    <input required="" class="form-control" name="address"
                        type="text" value="{{ $data->address }}" />
                </div>
                <div class="form-group col-md-3">
                    <label>Profile image<span class="required">*</span></label>
                    <input type="hidden" name="remove_img" id="remove_img"
                        value="">
                    <input type="file" name="image" class="dropify"
                        data-plugins="dropify" data-height="150"
                        data-default-file="{{ !empty($data->image) ? asset('uploads/user_images/' . $data->image) : url('uploads/img/no_image.jpg') }}" />
                </div>
                <div class="col-md-12">
                    <button type="submit"
                        class="btn btn-fill-out submit font-weight-bold"
                        name="submit" value="Submit">Save Change</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>