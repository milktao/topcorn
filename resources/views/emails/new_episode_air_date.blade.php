@component('mail::message')
# Hello!

Air date of the new episode of {{$name}} is defined.

You are receiving this email because either it is in your watch later list or you liked it.

@component('mail::panel')
Date: {{$next_episode_air_date}} ({{$day_difference_next}} days later)
@endcomponent

@component('mail::button', ['url' => url('/').'/series/'.$series_id, 'color' => 'green'])
Check details
@endcomponent

<small>Feel free to reply this mail for any reason. We would appriciate your feedback. (Questions, bugs, critics, advices, grammer correction etc.)</small>

<small>If you don't want to receive emails from us, please click <a href="{{url('/')}}/account/notifications-emails">here</a> and change your settings.</small>

Thanks,<br>
{{ config('app.name') }} Team
@endcomponent
