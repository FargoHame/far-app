@props(['width','height','color'])
<svg {{ $attributes->merge(['width' => isset($width) ? $width : "12" ,'height'=> isset($height) ? $height : "14"]) }} viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M12 12.6V2.8C12 2.0279 11.402 1.4 10.6667 1.4H9.33333V0H8V1.4H4V0H2.66667V1.4H1.33333C0.598 1.4 0 2.0279 0 2.8V12.6C0 13.3721 0.598 14 1.33333 14H10.6667C11.402 14 12 13.3721 12 12.6ZM4 11.2H2.66667V9.8H4V11.2ZM4 8.4H2.66667V7H4V8.4ZM6.66667 11.2H5.33333V9.8H6.66667V11.2ZM6.66667 8.4H5.33333V7H6.66667V8.4ZM9.33333 11.2H8V9.8H9.33333V11.2ZM9.33333 8.4H8V7H9.33333V8.4ZM10.6667 4.9H1.33333V3.5H10.6667V4.9Z" {{ $attributes->merge(['fill' => isset($color) ? $color : "#3AB8B9"]) }}/>
</svg>
    