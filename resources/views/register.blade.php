@extends('layouts.app_layout')

@section('styles')
    @parent
@endsection
@section('scripts')
    @parent
@endsection

@push('page_scripts')

<script>
    $(function(){

        jQuery.validator.addMethod('email_rule', function(value, element) {
            var isSuccess = false;

            $.ajax({ 
                url: "{!! route('user.checkValidUser', []) !!}", 
                type: "POST",
                data: {
                    '_token': function(){
                        return $("input[name='_token']").val();
                    },
                    'email': function(){
                        return value;
                    },
                    'match_case': function(){
                        return false;
                    }
                }, 
                async: false, 
                success: function(data) { 
                    //console.log( data );
                    isSuccess = (data.isValidUser == false ? true : false);
                }
            });

            return isSuccess;
        }, function(value, element){
            var element_value = $( element ).val();
            return ( element_value + " is already taken" );
        });

        jQuery.validator.addMethod('valid_balance', function(value, element) {
            var isSuccess = false;

            var regex = /(?:\d*\.\d{1,2}|\d+)$/;
            if (regex.test( value )) {
                isSuccess = true;
            } else {
                isSuccess = false;
            }

            return isSuccess;
        }, function(value, element){
            var element_value = $( element ).val();
            return ( element_value + " is invalid" );
        });

        $("#myform").validate({
            onfocusout: false,
            onkeyup: false,
            rules: {
                name: 'required',
                password: {
                    required: true,
                    minlength: 5
                },
                confirm_password: {
                    required: true,
                    equalTo: '#password'
                },
                email: {
                    required: true,
                    email: true,
                    email_rule: true
                },
                balance: {
                    required: true,
                    number: true,
                    digits: false,
                    min: 0
                }
            },
            messages: {
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },
                confirm_password: {
                    required: "Please provide a password",
                    equalTo: "Please enter the same password as above"
                },
                email: {
                    required: "Please enter your email address.",
                    email: "Please enter a valid email address."
                },
                balance: {
                    min: "balance must be > 0"
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

    });
</script>

@endpush

@section('container')
    <!-- -->
    <div class="page-header">
        <h1 class="display-4">Register</h1>
    </div>

    <div class="row">
        <div class="col col-md-8">

            <form id="myform" action="{{ route('user.store', []) }}" method="POST" autocomplete="off">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Name" autocomplete="off"/>
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" autocomplete="off"/>
                </div>
                <div class="form-group">
                    <label for="balance">Balance</label>
                    <input type="number" name="balance" id="balance" class="form-control" placeholder="Balance" autocomplete="off"/>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" autocomplete="off"/>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password" autocomplete="off"/>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>
    <!-- -->
@endsection