@if(isset($route['show']))
<a href="{{ $route['show'] }}">
  <i class="ti ti-eye"></i>
</a>
@endif
@if(isset($route['edit']))
<a href="{{ $route['edit'] }}">
  <i class="ti ti-pencil"></i>
</a>
@endif
@if(isset($route['destroy']))
<a href="javascript:void(0)" onclick="deleteRow('{{ $id }}', '{{ $route['destroy'] }}')">
  <i class="ti ti-trash"></i>
</a>
@endif