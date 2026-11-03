@extends('admin.layout')
@section('content')
<a href="/admin">← Wróć do pulpitu</a>
<h1>{{ $product->exists ? $product->name : 'Dodaj produkt' }}</h1>
<section class="admin-card">
<form class="admin-form" method="post" action="{{ $product->exists ? '/admin/produkty/'.$product->slug : '/admin/produkty' }}" enctype="multipart/form-data">
@csrf @if($product->exists) @method('PUT') @endif
<div class="form-grid">
<label>Nazwa produktu<input name="name" required maxlength="150" value="{{ old('name',$product->name) }}"></label>
<label>Cena brutto (PLN)<input name="price_gross" type="number" step="0.01" min="0" max="999999.99" required value="{{ old('price_gross',$product->price_gross) }}"></label>
<label>Kolor<select name="color" required>@foreach(['niebieski'=>'Niebieski','szary'=>'Szary'] as $value=>$label)<option value="{{ $value }}" @selected(old('color',$product->color)===$value)>{{ $label }}</option>@endforeach</select></label>
<label>Zdjęcie główne (JPG, PNG, WebP, do 8 MB)<input name="image" type="file" accept="image/jpeg,image/png,image/webp" @required(!$product->exists)></label>
<label class="full">Opis produktu<textarea name="description" rows="8" required maxlength="12000">{{ old('description',$product->description) }}</textarea></label>
<label class="full">Dodaj zdjęcia do galerii (łącznie do 8)<input name="gallery[]" type="file" multiple accept="image/jpeg,image/png,image/webp"></label>
@foreach(['height'=>'Wysokość (np. 2220 mm)','width'=>'Szerokość','depth'=>'Głębokość','weight'=>'Waga','capacity'=>'Pojemność zbiornika','material'=>'Materiał'] as $key=>$label)
<label>{{ $label }}<input name="specifications[{{ $key }}]" maxlength="200" value="{{ old('specifications.'.$key,$product->specifications[$key] ?? '') }}"></label>
@endforeach
<label class="full">Wyposażenie standardowe<textarea name="equipment" rows="3" maxlength="3000">{{ old('equipment',$product->equipment) }}</textarea></label>
</div>
<p class="muted">Puste parametry nie pojawią się na karcie produktu. Dostępne kolory: niebieski i szary.</p>
<div class="admin-gallery">@foreach($product->gallery ?? [] as $photo)<label><img src="{{ str_starts_with($photo,'products/')?asset('storage/'.$photo):asset($photo) }}" alt="Zdjęcie galerii {{ $loop->iteration }}"><span><input type="checkbox" name="remove_gallery[]" value="{{ $photo }}"> Usuń z galerii</span></label>@endforeach</div>
<input type="hidden" name="active" value="0"><label class="check"><input name="active" type="checkbox" value="1" @checked(old('active',$product->active))><span>Produkt widoczny na stronie</span></label>
<button class="button dark">{{ $product->exists ? 'Zapisz zmiany' : 'Dodaj produkt' }}</button>
</form></section>
@endsection
