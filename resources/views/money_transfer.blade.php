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
        
        /*jQuery.validator.addMethod('valid_balance', function(value, element) {
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
        });*/
        
        jQuery.validator.addMethod('valid_balance', function(value, element) {
            var isSuccess = false;
            var totalAmount = 0;
            
            $.ajax({ 
                url: "{!! route('user.getTotalAmount', []) !!}", 
                type: "POST",
                data: {
                    '_token': function(){
                        return $("input[name='_token']").val();
                    }
                },
                async: false, 
                success: function(data) { 
                    //console.log( data );
                    totalAmount = data.totalAmount;
                    isSuccess = (totalAmount && (value <= totalAmount));
                }
            });

            return isSuccess;
        }, function(value, element){
            var element_value = $( element ).val();
            return ( element_value + " is invalid amount" );
        });
        
        $("#myform").validate({
            onfocusout: false,
            onkeyup: false,
            rules: {
                email: {
                    required: true,
                    email: true,
                    email_rule: true
                },
                balance: {
                    required: true,
                    number: true,
                    digits: false,
                    min: 0,
                    valid_balance: true
                }
            },
            messages: {
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
        <h1 class="display-4">Money Transfer</h1>
    </div>

    <div class="row">
        <div class="col col-md-8">

            <form id="myform" action="{{ route('transaction.store', []) }}" method="POST" autocomplete="off">
                @csrf
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" autocomplete="off" value="{{ old('email') }}"/>
                </div>
                <div class="form-group">
                    <label for="balance">Balance</label>
                    <input type="number" name="balance" id="balance" class="form-control" placeholder="Balance" autocomplete="off" value="{{ number_format(old('balance'), 2) }}"/>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>
    <!-- -->
@endsection