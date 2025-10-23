@component('mail::message')
# Hello, {{ $userName }}!

These are birthdays for next 7 days:

@forelse($items as $it)
- **{{ $it['name'] }}** — {{ $it->display_date }}
@empty
You don't have any bd this week. ✨
@endforelse

@component('mail::button', ['url' => route('birthdays')])
Open app
@endcomponent

Thank you,
**Birthday Reminder**
@endcomponent
