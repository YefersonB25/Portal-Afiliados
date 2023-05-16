@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hola')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
@if ($line == 'Please click the button below to verify your email address.')
    {{"Haga clic en el botón de abajo para verificar su dirección de correo electrónico."}}  
@else
    {{$line}}   
@endif
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
@if ($actionText == 'Verify Email Address')
{{"Confirme su dirección de correo electrónico"}}
@else
{{$actionText}}
    
@endif
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
@if ($line == 'If you did not create an account, no further action is required.')
    {{"Si no creó una cuenta, no se requiere ninguna otra acción."}}
@else  
{{ $line }}
@endif
@endforeach


{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
{{"Saludos,
TC LOGISTICS"}}
@endif

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')

@lang(
    "Si tiene problemas para hacer clic en el botón \":actionText\", copie y pegue la siguiente URL\n".
     'en su navegador web:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset
@endcomponent
