@extends('emails.layout')
@section('email-body')
Hi {{ $user->name }}, 
<tr style="border-collapse:collapse"> 
    <td class="es-m-txt-l" bgcolor="#ffffff" align="left" style="Margin:0;padding-top:20px;padding-bottom:20px;padding-left:30px;padding-right:30px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:18px;font-family:lato, 'helvetica neue', helvetica, arial, sans-serif;line-height:27px;color:#666666">You have been added as a bahranda admin with your email : {{ $user->email}}
        .</p></td> 
   </tr> 
   <tr style="border-collapse:collapse"> 
    <td align="center" style="Margin:0;padding-left:10px;padding-right:10px;padding-top:35px;padding-bottom:35px"><span class="es-button-border" style="border-style:solid;border-color:#FFFFFF;background:#069801;border-width:1px;display:inline-block;border-radius:2px;width:auto"><a href="{{ $url }}" class="es-button" target="_blank" style="mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;font-size:20px;color:#FFFFFF;border-style:solid;border-color:#069801;border-width:15px 30px;display:inline-block;background:#069801;border-radius:2px;font-weight:normal;font-style:normal;line-height:24px;width:auto;text-align:center"> Continue</a></span></td> 
    </tr> 
@endsection

