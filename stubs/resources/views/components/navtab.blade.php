@props(['tabs'])

<nav>
    <div class="nav nav-tabs mb-2" id="nav-tab" role="tablist">
        
        @foreach ($tabs as $item)
            <a href="{{ $item['url'] ?? '#' }}" 
                class="nav-link @if($loop->first) active @endif" 
                id="nav-{{ $item['form'] ?? '' }}-tab" 
                @if (empty($item['url']))
                data-bs-toggle="tab" 
                data-bs-target="#{{ $item['form'] ?? '' }}-tab" 
                @endif
                type="button" role="tab" 
                aria-controls="{{ $item['form'] ?? '' }}-tab" 
                aria-selected="false">{{ $item['title'] ?? '' }}</a>
        @endforeach
        
    </div>
</nav>
