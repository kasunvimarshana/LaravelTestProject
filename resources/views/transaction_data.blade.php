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
    <div class="page-header">
        <h1 class="display-4">Transactions</h1>
    </div>

    <div class="row">
        <div class="col col-md-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>DATE</th>
                            <!-- th>DETAIL</th -->
                            <th>DEPOSIT</th>
                            <th>WITHDRAWAL</th>
                        </tr>
                    </thead>
                        
                    <tbody>
                        @isset( $transactions )
                            @foreach($transactions as $key => $value)
                                @php
                                    $balance = $value->balance;
                                    $transaction_type = $value->transaction_type;
                                    $created_at = $value->created_at;
                                    $record_type = $value->record_type;
                                    $deposit = null;
                                    $withdrawal = null;
                                    if( (strcmp($record_type, "DEPOSIT") == 0) ){
                                        $deposit = number_format($balance, 2);
                                    }else if( (strcmp($record_type, "WITHDRAWAL") == 0) ){
                                        $withdrawal = number_format($balance, 2);
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $created_at }}</td>
                                    <!-- td>{{ $transaction_type }}</td -->
                                    <td>{{ $deposit }}</td>
                                    <td>{{ $withdrawal }}</td>
                                </tr>
                            @endforeach
                        @endisset
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- -->
@endsection