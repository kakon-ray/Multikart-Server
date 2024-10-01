@extends('admin_index', ['productlist' => 'active'])
@section('content')
    <h3 style="color: red; text-align: center; margin-top: 7px">{{ session('success') ?? null }}</h3>
    <h3 style="color: green; text-align: center; margin-top: 7px">{{ session('message') ?? null }}</h3>

    <div class="">
        <table class="table align-middle mb-0 bg-white">
            <thead class="bg-light">
                <tr>
                    <th>Product Title</th>
                    <th>Price</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        {{-- title --}}
                        <td style="width: 40vw">
                            <div class="d-flex align-items-center">
                                @foreach ($images as $image)
                                    @if ($product->id == $image->product_id)
                                        <img src="{{ asset('product_images/' . $image->image_path) }}" alt=""
                                            style="width: 45px; height: 45px" class="rounded-circle" />
                                    @break
                                @endif
                            @endforeach
                            <div class="ms-3">
                                <p class="fw-bold mb-1">{{ $product->title }}</p>
                                {{-- <p class="text-muted mb-0">john.doe@gmail.com</p> --}}
                            </div>
                        </div>
                    </td>

                    {{-- price --}}
                    <td>
                        <p class="fw-normal mb-1">$ {{ $product->price }}</p>
                    </td>

                    {{-- Color --}}
                    <td>
                        @foreach ($stocks as $stock)
                            @if ($stock->product_id == $product->id)
                                <p class="fw-normal mb-1">
                                    {{ $stock->color->color }}
                                </p>
                            @endif
                        @endforeach
                    </td>

                    {{-- size --}}
                    <td>
                        @foreach ($stocks as $stock)
                            @if ($stock->product_id == $product->id)
                                <p class="fw-normal mb-1">
                                    {{ $stock->size->size }}
                                </p>
                            @endif
                        @endforeach
                    </td>

                    {{-- stock --}}
                    <td style="padding-left: 35px">
                        @foreach ($stocks as $stock)
                            @if ($stock->product_id == $product->id)
                                <p class="fw-normal mb-1">
                                    {{ $stock['stock'] }}
                                </p>
                            @endif
                        @endforeach
                    </td>

                    {{-- action button --}}
                    <td style="">
                        <form action="{{ route('product.edit', $product->id) }}" style="display: inline-block">
                            @csrf
                            <button class="btn btn-sm btn-success">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                        </form>

                        <form action="{{ route('product.destroy', ['product' => $product->id]) }}" method="POST"
                            style="display: inline-block">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-danger" id="btn" onclick="delete(e)">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            <div class="d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        </tbody>
    </table>
</div>
@endsection
