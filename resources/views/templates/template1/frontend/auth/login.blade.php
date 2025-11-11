@extends('templates.template1.frontend.master.app')
@section('app-content')
    <div class="container-fluid">
        <div class="row vh-100 bg-success d-flex align-items-center justify-content-center">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="card rounded-0 bg-white">
                    <div class="card-header text-center">
                        <h3 class="h3">Login Page</h3>
                    </div>
                    <div class="card-body">
                        <form id="loginForm">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 mb-3">
                                    <label class="fw-semibold mb-1">Email:</label>
                                    <input type="text" class="form-control rounded-0" name="email">
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <label class="fw-semibold mb-1">Password:</label>
                                    <input type="password" class="form-control rounded-0" name="password">
                                </div>
                                <div class="col-sm-12 text-center">
                                    <input type="submit" class="btn btn-outline-success rounded-0 w-100" value="Login Now">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a href="#" class="text-decoration-none">Not Registered? Register Now</a>
                        <a href="#" class="text-decoration-none">Forget Password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('app-script')
    <script>
        $(document).ready(function() {
            $('#loginForm').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 6
                    }
                },
                messages: {
                    email: {
                        required: "Email is required",
                        email: "Enter a valid email"
                    },
                    password: {
                        required: "Password is required",
                        minlength: "Password must be at least 6 characters"
                    }
                },
                errorPlacement: function(error, element) {
                    error.addClass('text-danger small d-block mt-1');
                    error.insertAfter(element);
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: "{{ route('login') }}",
                        type: "POST",
                        data: $(form).serialize(),
                        dataType: "json",
                        beforeSend: function() {
                            $('input[type="submit"]').prop('disabled', true).val(
                                'Logging in...');
                        },
                        success: function(response) {
                            if (response.status) {
                                window.location.href = response.redirect;
                            } else if (response.errors) {
                                $.each(response.errors, function(key, val) {
                                    let field = $('[name="' + key + '"]');
                                    field.addClass('is-invalid');
                                    if (field.next('.text-danger').length === 0)
                                        field.after(
                                            '<label class="text-danger small d-block mt-1">' +
                                            val[0] + '</label>');
                                });
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(xhr) {
                            alert('Something went wrong.');
                        },
                        complete: function() {
                            $('input[type="submit"]').prop('disabled', false).val(
                                'Login Now');
                        }
                    });
                    return false;
                }
            });
        });
    </script>
@endpush
