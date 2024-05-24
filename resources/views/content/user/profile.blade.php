@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
<style>
  /* CSS to position success message and edit button */
  .position-absolute-top-right {
    position: absolute;
    top: 0;
    right: 0;
  }

  .position-absolute-bottom-right {
    position: absolute;
    bottom: 0;
    right: 0;
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
          <!-- User info -->
          <div class="row">
            <div class="col-sm-7">
              <div class="form-group">
                <label for="name">NAME : </label> {{ $user->name }}
              </div>
              <div class="form-group">
                <label for="email">EMAIL ADDRESS : </label> {{ $user->email }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
