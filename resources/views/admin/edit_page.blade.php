@extends('admin_index')
@section('content')
    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="row">
        <input type="hidden" value="{{ $product_variants }}" name="product_variants">
        @method('put')
        @csrf
        <h3 style="color: green; text-align: center; margin-top: 5px">{{ Session::get('message') ?? null }}</h3>

        <div class="col-lg-7 col-sm">
            <!-- Product Information -->
            <div class="card mb-4">

                <div class="card-header">
                    <h5 class="card-tile mb-0">Product information</h5>
                </div>

                <div class="card-body">
                    {{-- title --}}
                    <div class="mb-3">
                        <label class="form-label" for="ecommerce-product-name">Title</label>
                        <input type="text" class="form-control" id="ecommerce-product-name" placeholder="Product title"
                            name="title" aria-label="title" value="{{ $product->title }}">

                        @error('title')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="5" class="form-control p-2 pt-2">
                            
                        </textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </div> <!-- /Product Information -->
        </div> {{-- 1st col --}}

        <div class="col-lg-5 col-sm">
            <div class="card mb-4">
                <div class="card-body">
                    {{-- price --}}
                    <div class="mb-3">
                        <label class="form-label" for="ecommerce-product-name">Price</label>
                        <input type="number" class="form-control" id="ecommerce-product-name" placeholder="Price"
                            name="price" value="{{ $product->price }}">
                        @error('price')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- image upload --}}
                    <div class="mb-3">
                        <label for="images[]" class="form-label">Upload Images</label>
                        <input name="images[]" class="form-control" type="file" multiple />
                        @error('images')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                        @foreach ($errors->get('images.*') as $messages)
                            @foreach ($messages as $message)
                                <p style="color: red">
                                    {{ $message }}
                                </p>
                            @endforeach
                        @endforeach
                    </div>

                    {{-- categories --}}
                    {{-- <div class="mb-3">
                        <label for="defaultSelect" class="form-label">Category</label>
                        <select name="category" id="defaultSelect" class="form-select">
                            <option selected value="">Select Category ..</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category }}
                                </option>
                            @endforeach
                        </select>

                        @error('category')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div> --}}
                    {{-- categories --}}

                    <div class="form-repeater" id="variant-container">
                        {{--  Variants button  --}}
                        <label class="form-label" for="ecommerce-product-name">Variants</label>
                        <div class="d-flex">
                            <div style="padding-right: 4px">
                                <button class="btn btn-primary btn-sm" id="add-variant">
                                    Add More Varient
                                </button>
                            </div>
                            <div class="inline-block">
                                <button class="btn btn-primary btn-sm" id="custom-variant">
                                    Add Custom Varient
                                </button>
                            </div>
                        </div>
                        {{-- variants button ends --}}


                        @foreach ($product_variants as $item)
                            <div id="default">
                                {{-- color --}}
                                <div class="row">
                                    <div class="mt-2 col-4">
                                        <select name="color[]" class="form-select">
                                            @foreach ($colors as $color)
                                                <option value="{{ $color->color }}"
                                                    {{ $item->color_id == $color->id ? 'selected' : null }}>
                                                    {{ $color->color }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- size --}}
                                    <div class="mt-2 col-3">
                                        <select name="size[]" class="form-select">
                                            @foreach ($sizes as $size)
                                                <option value="{{ $size->size }}"
                                                    {{ $item->size_id == $size->id ? 'selected' : null }}>
                                                    {{ $size->size }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- stock --}}
                                    <div class="mt-2 col-4">
                                        <input name="stock[]" type="number" id="form-repeater-1-2" class="form-control"
                                            placeholder="Stock" value="{{ $item->stock }}">
                                    </div>
                                    <button onclick="deleteElement('default')" type="button"
                                        class="mt-3 col-1 btn-close"></button>
                                </div>
                            </div>
                        @endforeach

                        @error('color*')
                            <p style="color: red">The color field is required.</p>
                        @enderror

                        @error('size*')
                            <p style="color: red">The size field is required.</p>
                        @enderror

                        @error('stock*')
                            <p style="color: red">The stock field is required.</p>
                        @enderror

                    </div> <!-- /Variants -->
                </div> {{-- card body --}}
            </div>
        </div> {{-- 2nd col --}}

    </form>
@endsection

@section('script')
    <script>
        let id1 = 0;
        let id2 = 0;

        document.getElementById("add-variant").addEventListener("click", function(event) {
            event.preventDefault();

            id1++
            id2++

            // console.log(id1);
            let input = document.createElement("div");
            input.innerHTML = `
                        <div id="${id1}">
                            
                                <div class="row">

                                    <div class="mt-1 col-4">
                                        <select name="color[]" class="form-select">
                                            <option selected value="">Color</option>
                                            @foreach ($colors as $color)
                                                <option value="{{ $color->color }}">{{ $color->color }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mt-1 col-3">
                                        <select name="size[]" class="form-select">
                                            <option selected value="">Size</option>
                                            @foreach ($sizes as $size)
                                                <option value="{{ $size->size }}">{{ $size->size }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mt-1 col-4">
                                        <input name="stock[]" type="number" id="form-repeater-1-2" class="form-control"
                                            placeholder="Stock">
                                    </div>

                                    <button onclick="deleteElement(${id1})" type="button" class="mt-3 col-1 btn-close"></button>
                                   
                                </div>
                           
                        </div>
                        `;
            document.getElementById("variant-container").appendChild(input);
        });


        document.getElementById("custom-variant").addEventListener("click", function(event) {
            event.preventDefault();

            id1++
            id2++

            let input = document.createElement("div");
            input.innerHTML = `
                        <div id="${id2}">
                            
                                <div class="row">

                                    <div class="mt-1 col-4">
                                        <input name="color[]" type="text" id="form-repeater-1-2" class="form-control"
                                            placeholder="Color">
                                    </div>

                                    <div class="mt-1 col-3">
                                        <input name="size[]" type="text" id="form-repeater-1-2" class="form-control"
                                            placeholder="Size">
                                    </div>

                                    <div class="mt-1 col-4">
                                        <input name="stock[]" type="number" id="form-repeater-1-2" class="form-control"
                                            placeholder="Stock">
                                    </div>
                                    
                                    <button onclick="deleteElement(${id2})" type="button" class="mt-3 col-1 btn-close"></button>
                                      
                                </div>
                           
                        </div>
                        `;
            document.getElementById("variant-container").appendChild(input);
        });

        function deleteElement(id) {
            document.getElementById(id).remove();
        }
    </script>
@endsection
