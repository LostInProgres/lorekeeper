@php
    $userFontSize = Auth::user()->settings->font_size;
    $DefaultFont = Auth::user()->settings->site_fonts_disabled;
@endphp

<style>
    *:not(.fas, .far, .fad, .fal) {
        @if ($DefaultFont)
            font-family: Roboto Condensed, serif !important;
        @endif
    }

    html {
        @if ($userFontSize)
            font-size: {{ $userFontSize }}rem;
        @endif
    }
</style>
