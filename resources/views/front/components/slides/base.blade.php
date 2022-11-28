@php
    $id = $id ?? 'id_' . time();
    $ariaLabel = 'Slide';
    
    $options = [
        'type' => 'loop',
        'arrows' => $slideOptions['arrows'] ?? false ? true : false,
        'speed' => 750,
        'autoplay' => $slideOptions['autoplay'] ?? false ? true : true,
        'pagination' => $slideOptions['pagination'] ?? false ? true : false,
    ];
    
    $options = json_encode($options);
@endphp

<div id="{{ $id }}" class="splide jsSplideDefault" role="group" aria-label="{{ $ariaLabel }}"
    data-options="{{ $options }}">
    <div class="splide__track">
        <ul class="splide__list">
            {{ $slotItems }}
        </ul>
    </div>
    <div class="splide__arrows splide__arrows--ltr"></div>
    <ul class="splide__pagination splide__pagination--ltr position-relative" role="tablist"
        aria-label="Escolha um slide a ser mostrado"></ul>
</div>
