@php
    $items = [
        ['route' => 'dashboard',  'icon' => 'home',          'label' => 'Beranda'],
        ['route' => 'wallets',    'icon' => 'wallet',        'label' => 'Dompet'],
        ['route' => 'gold',       'icon' => 'star',          'label' => 'Emas'],
        ['route' => 'family',     'icon' => 'users',         'label' => 'Keluarga'],
        ['route' => 'profile',    'icon' => 'user-circle',   'label' => 'Profil'],
    ];
@endphp
<nav class="nav-pill">
    @foreach ($items as $item)
        <a href="{{ route($item['route']) }}"
           class="nav-item {{ request()->routeIs($item['route']) ? 'on' : '' }}">
            <i class="ti ti-{{ $item['icon'] }}"></i>
            <span>{{ $item['label'] }}</span>
        </a>
    @endforeach
</nav>
