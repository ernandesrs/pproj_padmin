<nav class="nav {{ $vertical ?? false ? 'flex-column' : '' }} {{ $customClass ?? null }}">
    @foreach ($items as $item)
        <a class="nav-link" href="{{ $item->url }}" title="{{ $item->title }}" target="{{ $item->target }}">
            @component('front.components.icon',
                [
                    'icon' => $item->icon,
                    'position' => 'start',
                ])
            @endcomponent
            {{ $item->text }}
            @component('front.components.icon',
                [
                    'icon' => $item->icon,
                    'position' => 'end',
                ])
            @endcomponent
        </a>
    @endforeach
</nav>
