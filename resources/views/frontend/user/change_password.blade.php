<div class="tab-pane fade" id="change_password_detail" role="tabpanel"
aria-labelledby="change_password-tab">
<div class="card">
    @if (session('error'))
        <span class="alert alert-danger mt-2">{{ session('error') }}</span>
    @endif
    @if (session('success'))
        <span class="alert alert-success mt-2">{{ session('success') }}</span>
    @endif
    <div class="card-header">
        <h5>Change Password</h5>
    </div>
    <div class="card-body">
        <p>Password must be 8 characters
        </p>
        <form action="{{ route('user.change.password') }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="row">


                <div class="form-group col-md-12">
                    <label>Old Password<span class="required">*</span></label>
                    <input type="text" name="old_password"
                        class="form-control  @error('old_password') is-invalid   @enderror"
                        value="" />
                    @error('old_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <label>New Password <span class="required">*</span></label>
                    <input type="text" name="new_password"
                        class="form-control  @error('old_password') is-invalid @enderror"
                        value="" />
                    @error('new_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <label>Confirm Password<span class="required">*</span></label>
                    <input type="text" name="confirm_password"
                        class="form-control  @error('old_password')
                    is-invalid
                @enderror"
                        value="" />
                    @error('confirm_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
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