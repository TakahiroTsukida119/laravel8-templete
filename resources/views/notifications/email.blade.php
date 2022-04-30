@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
@if($greeting === null)
# @lang('Hello!')
@endif
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
switch ($level) {
case 'success':
case 'error':
$color = $level;
break;
default:
$color = 'primary';
}
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@endif

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang("notification.reset_user_password.trouble_shooting",['actionText' => $actionText])<br>
<span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset
@endcomponent
