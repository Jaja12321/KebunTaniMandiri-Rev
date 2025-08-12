@extends('layouts.admin')

@section('page-title', '')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Profile') }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">

        <!-- Avatar Section -->
        <div class="col-lg-4 order-lg-2 d-flex justify-content-center">
            <div class="card shadow-sm border-light rounded-lg">
                <div class="card-body text-center">
                    <div class="card-profile-image mt-4">
                        <figure class="rounded-circle avatar avatar-xl" style="font-size: 60px; height: 180px; width: 180px; background-color: #e2e2e2;" data-initial="{{ Auth::user()->name[0] }}"></figure>
                    </div>
                    <h5 class="font-weight-bold mt-3">{{ Auth::user()->fullName }}</h5>
                    <p class="text-muted">Administrator</p>
                    <div class="d-flex justify-content-center mt-4">
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="col-lg-8 order-lg-1">

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-secondary text-white py-3">
                    <h6 class="m-0 font-weight-bold">My Account</h6>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('profile.update') }}" autocomplete="off">
                        @csrf
                        @method('PUT')

                        <h6 class="heading-small text-muted mb-4">User Information</h6>

                        <div class="pl-lg-4">
                            <!-- Name and Last Name -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="name">Name<span class="small text-danger">*</span></label>
                                        <input type="text" id="name" class="form-control" name="name" placeholder="Name" value="{{ old('name', Auth::user()->name) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="last_name">Last Name</label>
                                        <input type="text" id="last_name" class="form-control" name="last_name" placeholder="Last Name" value="{{ old('last_name', Auth::user()->last_name) }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Email Address -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="email">Email Address<span class="small text-danger">*</span></label>
                                        <input type="email" id="email" class="form-control" name="email" placeholder="example@example.com" value="{{ old('email', Auth::user()->email) }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Password Section -->
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="current_password">Current Password</label>
                                        <input type="password" id="current_password" class="form-control" name="current_password" placeholder="Current Password">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="new_password">New Password</label>
                                        <input type="password" id="new_password" class="form-control" name="new_password" placeholder="New Password">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="confirm_password">Confirm Password</label>
                                        <input type="password" id="confirm_password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Save Changes Button -->
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-success btn-lg">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>

    </div>

@endsection
