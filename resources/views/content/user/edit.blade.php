@extends('layouts/contentNavbarLayout')

@section('title', 'Edit User Profile')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
@endsection

@section('content')
<div class="row">
  <div class="col-lg-8 mb-4 order-0">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title text-primary">Edit User Profile</h5>
        <form id='user-edit' action="{{ route('users.update', $user->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
          </div>
          <!-- Add other fields as needed -->
          <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
      </div>
    </div>
  </div>
</div>
@section('page-script')
<!-- jQuery -->
<script>
  jQuery(document).ready(function() {

    // Preload emails from server-side
    var existingEmails = @json($emails);

    // Custom method to validate letters and spaces only
    jQuery.validator.addMethod("lettersOnly", function(value, element) {
      return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
    }, "Please enter letters only");

    // Custom method to validate email uniqueness
    jQuery.validator.addMethod("uniqueEmail", function(value, element) {
    return this.optional(element) || !existingEmails.includes(value);
    }, "This email is already registered");

    jQuery('#formAuthentication').validate({
      rules: {
        name: {
          required: true,
          lettersOnly: true,
          minlength: 3
        },
        email: {
          required: true,
          email: true,
          uniqueEmail: true
        }
      },
      messages: {
        name: {
          required: "Please enter your username",
          lettersOnly: "Please enter letters only",
          minlength: "The name should be atleast 3 letters"
        },
        email: {
          required: "Please enter your email address",
          email: "Please enter a valid email address",
          uniqueEmail: "This email is already registered, Sign In instead"
        }
      },
      errorClass: 'text-danger',
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.insertAfter(element);
      },
      submitHandler: function(form) {
        form.submit();
      }
    });
    setTimeout(function() {
      $('#error-alert').fadeOut('slow');
    }, 3000); // 3000 milliseconds = 3 seconds
  });
</script>
@endsection
@endsection
