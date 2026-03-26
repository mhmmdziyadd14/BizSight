{{-- File: hpp-nav-underline.blade.php --}}
@php
    $route = \Route::currentRouteName();
@endphp

<style>
    .nav-underline {
        position: relative;
        transition: all 0.2s ease;
    }
    
    .nav-underline::after {
        content: '';
        position: absolute;
        bottom: -4px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, #F97316, #F59E0B);
        transition: width 0.25s ease;
        border-radius: 2px;
    }
    
    .nav-underline:hover::after {
        width: 80%;
    }
    
    .nav-underline-active::after {
        width: 80%;
        background: linear-gradient(90deg, #F97316, #F59E0B);
    }
    
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .nav-container {
        animation: slideUp 0.4s ease-out;
    }
</style>

<nav class="mb-8 flex flex-wrap gap-1 nav-container">
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
        <a href="{{ route($item['route']) }}" 
           class="nav-underline px-5 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all duration-300 {{ $isActive ? 'text-orange-600 bg-orange-50/50 nav-underline-active' : 'text-navy-500 hover:text-orange-500 hover:bg-orange-50/30' }}">
            {{ $item['label'] }}
        </a>
    @endforeach
</nav>