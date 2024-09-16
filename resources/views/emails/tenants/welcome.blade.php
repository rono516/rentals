@component('mail::message')
Greetings {{ $tenant->user->name }},

You have been added to {{ $rental->name }} rental as a tenant in {{ $tenant->house->name }}
and your online tenant account is ready. Use this account to check and pay your invoices.

Before accessing the account, you will be required to set a new password.

@component('mail::button', ['url' => route('tenants.password.create', ['inviteUuid' => $tenant->invite_code, 'email' => $tenant->user->email])])
Set New Password
@endcomponent

Kind Regards,<br>
{{ $rental->user->name }} - {{ $rental->name }}.

<i>Sent through {{ config('app.name') }}.</i>
@endcomponent
