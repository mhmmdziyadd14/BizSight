@php
    $route = \Route::currentRouteName();
@endphp

<nav class="mb-8 flex flex-wrap gap-2">
    @php
        $items = [
            ['label' => 'HPP', 'route' => 'hpp.index'],
            ['label' => 'Bahan', 'route' => 'hpp.bahan'],
            ['label' => 'Hitung HPP', 'route' => 'hpp.create'],
            ['label' => 'Data Produk', 'route' => 'hpp.products'],
            ['label' => 'Persediaan Bahan', 'route' => 'hpp.inventory'],
            ['label' => 'Bill of Material', 'route' => 'hpp.bom'],
        ];
    @endphp

    @foreach($items as $item)
        @php
            $isActive = $route === $item['route'];
        @endphp
        <a href="{{ route($item['route']) }}" class="px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest transition {{ $isActive ? 'bg-yellow-500 text-white' : 'bg-white text-gray-600 hover:bg-gray-100' }}">
            {{ $item['label'] }}
        </a>
    @endforeach
</nav>
