@if($product->specifications)
<dl class="spec-list">@foreach(['height'=>'Wysokość','width'=>'Szerokość','depth'=>'Głębokość','weight'=>'Waga','capacity'=>'Pojemność zbiornika','material'=>'Materiał'] as $key=>$label)@if(!empty($product->specifications[$key]))<div><dt>{{ $label }}</dt><dd>{{ $product->specifications[$key] }}</dd></div>@endif @endforeach</dl>
@endif
@if($product->equipment)<p class="spec-footnote">W standardzie: {{ $product->equipment }}</p>@endif
