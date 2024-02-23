@component('mail::message')
{{-- Greeting --}}
@if (!empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('¡Whoops!')
@else
# @lang('¡Hola!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
@if ($line == 'Please click the button below to verify your email address.')
{{
"Haga clic en el botón de abajo para verificar su dirección de correo electrónico."
}}
@elseif ($line == 'You are receiving this email because we received a password reset request for your account.')
{{
"Está recibiendo este correo electrónico porque recibimos una solicitud de restablecimiento de contraseña para su cuenta."
}}
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
@component('mail::button', ['url' => $actionUrl, 'color' => $color, 'style' => 'background-color: #4CAF50; color: white; padding: 10px 20px; border: none; text-decoration: none; font-size: 16px; border-radius: 5px;'])
@if ($actionText == 'Verify Email Address')
{{"Confirme su dirección de correo electrónico"}}
@elseif ($actionText == 'Reset Password')
{{"Restablecer la contraseña"}}
@else
{{$actionText}}
@endif
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
@if ($line == 'If you did not create an account, no further action is required.')
{{
"Si no creó una cuenta, no se requiere ninguna otra acción."
}}
@elseif ($line == 'This password reset link will expire in 60 minutes. If you did not request a password reset, no further action is required.')
{{
"Este enlace para restablecer la contraseña caducará en 60 minutos.  Si no solicitó un restablecimiento de contraseña, no es necesario realizar ninguna otra acción."
}}
@else
{{ $line }}
@endif
@endforeach

{{-- Salutation --}}
@if (!empty($salutation))
{{ $salutation }}
@else
{{"Saludos, TC LOGISTICS"}}
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
) <span style="word-wrap: break-word;"><a href="{{ $actionUrl }}" style="color: #082aea; text-decoration: none;">{{ $displayableActionUrl }}</a></span>
@endslot
@endisset
@endcomponent
