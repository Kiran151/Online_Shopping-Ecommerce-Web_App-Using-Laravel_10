@extends('vendor.vendor_dashboard')
@section('vendor')
    <div class="page-content">
        <div class="container">
            <div class="main-body">
                <div class="row">
                    <div class="card">
                        @if (session('error'))
                        <span class="alert alert-danger mt-2">{{session('error')}}</span>                         
                        @endif
                        @if (session('success'))
                        <span class="alert alert-success mt-2">{{session('success')}}</span>                         
                        @endif
                        <div class="card-body">
                            <form action="{{ route('change.password') }}" method="post">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Old Password</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="old_password"
                                            class="form-control  @error('old_password')
                                        is-invalid
                                    @enderror"
                                            value="" />
                                        @error('old_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">New Password</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="new_password" class="form-control  @error('old_password')
                                        is-invalid
                                    @enderror" value="" />
                                    @error('new_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Confirm Password</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="confirm_password" class="form-control  @error('old_password')
                                        is-invalid
                                    @enderror" value="" />
                                        @error('confirm_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="submit" class="btn btn-primary px-4" value="Save Changes" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
