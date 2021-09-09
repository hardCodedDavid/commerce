<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
<a href="{{ url('/') }}" style="text-decoration: none">
    <img src="{{ asset(\App\Models\Setting::first()->email_logo) }}" style="width: 165px" alt="Marksot Logo">
</a>
@endif
</a>
</td>
</tr>
