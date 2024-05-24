@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
<style>
  /* CSS to position success message */
  .position-absolute-top-right {
    position: absolute;
    top: 0;
    right: 0;
  }

  .position-absolute-bottom-right {
    position: absolute;
    bottom: 20px;
    right: 20px;
  }
</style>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-8 mb-4 order-0">
    <div class="card">
      <div class="d-flex align-items-end row">
        <div class="card-body">
          <!-- Welcome message -->
          <h5 class="card-title text-primary">PROFILE PAGE</h5>
          <!-- Success message -->
          @if ($message = Session::get('success'))
            <div class="alert alert-success position-absolute-top-right" id="success-alert">
              <p>{{ $message }}</p>
            </div>
          @endif
          <!-- User info -->
          <div class="row">
            <div class="col-sm-7">
              <div class="form-group">
                <label for="name">NAME : </label> {{ $admin->name }}
              </div>
              <div class="form-group">
                <label for="email">EMAIL ADDRESS : </label> {{ $admin->email }}
              </div>
            </div>
            <div class="col-sm-5 text-center text-sm-right">
              <a href="{{ route('admin.edit') }}" class="btn btn-primary position-absolute-bottom-right">Edit Profile</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-script')
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script>
  jQuery(document).ready(function() {
    setTimeout(function() {
      $('#success-alert').fadeOut('slow');
    }, 3000);
  });
</script>
@endsection
