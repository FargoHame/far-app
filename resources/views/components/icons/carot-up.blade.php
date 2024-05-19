@props(['width','height','color'])
<svg  {{ $attributes->merge(['width' => isset($width) ? $width : "12" ,'height'=> isset($height) ? $height : "6"]) }}  viewBox="0 0 12 6" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M0 6H12L6 0L0 6Z"  {{ $attributes->merge(['fill' => isset($color) ? $color : "black"]) }}/>
</svg>
    