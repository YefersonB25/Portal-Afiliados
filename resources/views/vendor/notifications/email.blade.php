@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Cambiar contraseña')
@endif
@endif

{{-- Intro Lines --}}
<p>
    Has recibido este mensaje porque has solicitado cambiar la contraseña de tu <strong>TC Portal Afiliados.</strong>.
</p>
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
<p>
    Este enlace de restablecimiento de contraseña caducará en 60 minutos.

    Si no solicitó un restablecimiento de contraseña, no se requiere ninguna otra acción.
</p>

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
Saludos,
TC LOGISTICS
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
