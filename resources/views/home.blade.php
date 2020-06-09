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
        //
    });
</script>

@endpush

@section('container')
    <!-- -->
    <div class="row">
        <div class="jumbotron">
            @isset($current_user)
            <div class="row">
                <div class="col col-md-4">
                    <p class="lead">Name</p>
                </div>
                <div class="col col-md-4">
                    <p class="lead">{{ $current_user->name }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col col-md-4">
                    <p class="lead">Email</p>
                </div>
                <div class="col col-md-4">
                    <p class="lead">{{ $current_user->email }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col col-md-4">
                    <p class="lead">Balance</p>
                </div>
                <div class="col col-md-4">
                    <p class="lead">{{ number_format($current_user->getTotalAmount(), 2) }}</p>
                </div>
            </div>
            <p class="lead">
                <a class="btn btn-primary btn-lg" href="{!! route('transaction_data', []) !!}" role="button">Detail View</a>
            </p>
            @endisset
        </div>
    </div>
    <!-- -->
@endsection