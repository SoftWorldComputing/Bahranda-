@component('mail::message')
Hi Bahranda, <br>
Message From : {{ $name }} <br>
<p>
    {{ $message}}
</p>

<p><strong>Contact : </strong></p>
<p>Phone : {{ $phone }}</p>
<p>email : {{ $email }}</p>
Thanks,<br>
{{ config('app.name') }} Team.
@endcomponent
