@php
    $userFontSize = 1.2;
    $DefaultFont = TRUE
@endphp

<style>

*:not(.fas,.far,.fad,.fal) { 
    @if($DefaultFont) font-family: Roboto Condensed, serif !important; @endif
} 

html {
    @if($userFontSize) font-size: {{ $userFontSize }}rem; @endif
}

</style>