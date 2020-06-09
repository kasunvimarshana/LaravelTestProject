
@isset($data)

    @if( (isset( $data['recipient']->email )) )
        
        <p>Dear {{ $data['recipient']->name }},</p>

    @endif
    
    <p> you have received Rs. {{ number_format($data['balance'], 2) }} amount of money </p>
    <p> plese check your account </p>

@endisset

<p>****** System Genarated Message ******</p>