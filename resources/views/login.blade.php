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
                    isSuccess = (data.isValidUser == true ? true : false);
                }
            });

            return isSuccess;
        }, function(value, element){
            var element_value = $( element ).val();
            return ( element_value + " is a invalid user" );
        });
        
        $("#myform").validate({
            onfocusout: false,
            onkeyup: false,
            rules: {
                password: {
                    required: true,
                    minlength: 5
                },
                email: {
                    required: true,
                    email: true,
                    email_rule: true
                }
            },
            messages: {
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },
                email: {
                    required: "Please enter your email address.",
                    email: "Please enter a valid email address."
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
        <h1 class="display-4">Login</h1>
    </div>

    <div class="row">
        <div class="col col-md-8">

            <form id="myform" action="{{ route('login.do', []) }}" method="POST" autocomplete="off">
                @csrf
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" autocomplete="off" value="{{ old('email') }}"/>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" autocomplete="off"/>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>
    <!-- -->
@endsection