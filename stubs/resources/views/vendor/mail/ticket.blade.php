@component('mail::message')
# Ticket Resolved
Hi, {{$ticket->reporter_name}}.

The {{$ticket->title}} ticket has be resolved.

Thank you for contacting us.

<!-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent -->

Thanks,<br>
{{ config('app.name') }}
@endcomponent
