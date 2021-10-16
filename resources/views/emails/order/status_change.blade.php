@extends('emails.layout')
@section('email-body')
Hi {{ $user->name }}, 
<tr style="border-collapse:collapse"> 
    <td class="es-m-txt-l" bgcolor="#ffffff" align="left" style="Margin:0;padding-top:20px;padding-bottom:20px;padding-left:30px;padding-right:30px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:18px;font-family:lato, 'helvetica neue', helvetica, arial, sans-serif;line-height:27px;color:#666666">Your deal on {{ ucwords($deal->commodity->commodity_name) }}  status has been changed to {{ $status }}.
        @if($status == "Closed")
         A sum of ₦{{ number_format($deal->expected_return) }} has been disbursed into your wallet.
         @endif</p></td> 
   </tr> 

</p>
@endsection
