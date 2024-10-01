<h1>Order Place Successfully</h1>
<h2>Items</h2>
<div>
    @foreach ($items as $item)
        <h3>{{ $item->product_name }}</h3>
    @endforeach
</div>
