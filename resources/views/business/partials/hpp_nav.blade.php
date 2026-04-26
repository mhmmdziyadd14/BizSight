{{-- File: hpp_nav.blade.php --}}
@php
    $route = \Route::currentRouteName();
    $routeTabMap = [
        'hpp.index'     => 'tab-datahpp',
        'hpp.products'  => 'tab-products',
        'hpp.inventory' => 'tab-inventory',
        'hpp.bom'       => 'tab-bom',
        'hpp.create'    => 'tab-profit',
        'hpp.bahan'     => 'tab-material',
    ];
    $activeTab = $routeTabMap[$route] ?? 'tab-datahpp';
@endphp

<style>
    .hpp-tab {
        position: relative;
        padding: 8px 18px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        cursor: pointer;
        transition: all 0.2s ease;
        color: #94a3b8;
        border: none;
        background: transparent;
    }
    .hpp-tab::after {
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
    .hpp-tab:hover { color: #F97316; background: rgba(249,115,22,0.06); }
    .hpp-tab:hover::after { width: 80%; }
    .hpp-tab.hpp-active { color: #F97316; background: rgba(249,115,22,0.08); }
    .hpp-tab.hpp-active::after { width: 80%; }
    .nav-container { animation: slideUp 0.3s ease-out; }
    @keyframes slideUp {
        from { opacity:0; transform:translateY(10px); }
        to   { opacity:1; transform:translateY(0); }
    }
</style>

<nav class="mb-8 flex flex-wrap gap-1 nav-container" id="hppTabNav">
    <button class="hpp-tab" data-tab="tab-material">Material</button>
    <button class="hpp-tab" data-tab="tab-profit">Profit Count</button>
    <button class="hpp-tab" data-tab="tab-datahpp">Data HPP</button>
    <button class="hpp-tab" data-tab="tab-products">Data Product</button>
    <button class="hpp-tab" data-tab="tab-inventory">Inventory</button>
    <button class="hpp-tab" data-tab="tab-bom">Bill of Material</button>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var INITIAL = '{{ $activeTab }}';

    function activate(tabId) {
        // Update tab button states
        document.querySelectorAll('#hppTabNav .hpp-tab').forEach(function(t) {
            if (t.dataset.tab === tabId) {
                t.classList.add('hpp-active');
            } else {
                t.classList.remove('hpp-active');
            }
        });

        // Update panel visibility
        document.querySelectorAll('.tab-panel').forEach(function(p) {
            if (p.id === tabId) {
                p.style.display = 'block';
            } else {
                p.style.display = 'none';
            }
        });

        // Load iframe if not yet loaded (check attribute, not property)
        var panel = document.getElementById(tabId);
        if (panel) {
            var iframe = panel.querySelector('iframe[data-src]');
            if (iframe) {
                var dataSrc = iframe.getAttribute('data-src');
                var currentSrc = iframe.getAttribute('src');
                // Only load if src is empty or not yet set to data-src
                if (!currentSrc || currentSrc === '' || currentSrc === window.location.href) {
                    iframe.setAttribute('src', dataSrc);
                }
            }
        }

        try { sessionStorage.setItem('hpp_active_tab', tabId); } catch(e) {}
    }

    // Attach click handlers
    document.querySelectorAll('#hppTabNav .hpp-tab').forEach(function(btn) {
        btn.addEventListener('click', function() {
            activate(btn.dataset.tab);
        });
    });

    // Determine starting tab
    var stored = '';
    try { stored = sessionStorage.getItem('hpp_active_tab') || ''; } catch(e) {}
    var startTab = (INITIAL === 'tab-datahpp' && stored) ? stored : INITIAL;

    activate(startTab);
});
</script>
