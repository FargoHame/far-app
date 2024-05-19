@props(['width','height','color'])
<svg {{ $attributes->merge(['width' => isset($width) ? $width : "20" ,'height'=> isset($height) ? $height : "20"]) }} width="14" height="18" viewBox="0 0 14 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M1 18H13V4H1V18ZM3.46 8.88L4.87 7.47L7 9.59L9.12 7.47L10.53 8.88L8.41 11L10.53 13.12L9.12 14.53L7 12.41L4.88 14.53L3.47 13.12L5.59 11L3.46 8.88ZM10.5 1L9.5 0H4.5L3.5 1H0V3H14V1H10.5Z" fill="#FF0000"/>
</svg>
