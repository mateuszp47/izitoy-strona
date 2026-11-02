{!! '<'.'?xml version="1.0" encoding="UTF-8"?'.'>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"><url><loc>{{ url('/') }}</loc></url>@foreach($products as $product)<url><loc>{{ route('product',$product) }}</loc><lastmod>{{ $product->updated_at->toAtomString() }}</lastmod></url>@endforeach<url><loc>{{ route('privacy') }}</loc></url></urlset>
