@extends('admin_index', ['addproduct' => 'active'])
@section('content')
    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data"
        class="row d-flex justify-content-center mt-3">
        @csrf

        <h4 style="color: green; text-align: center; margin-top: 5px">{{ Session::get('message') ?? null }}</h4>

        <div class="col-lg-10 col-sm">
            <div class="card mb-4">
                <div class="card-body">

                    {{-- title starts --}}
                    <div class="mb-3">
                        <label class="form-label" for="ecommerce-product-name">Title</label>
                        <input type="text" class="form-control" id="ecommerce-product-name" placeholder="Product title"
                            name="title" aria-label="title" value="{{ old('title') ?? null }}">

                        @error('title')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- title ends --}}

                    {{-- descriptions starts --}}
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="5" class="form-control p-2 pt-2" value="{{ old('description') ?? null }}"></textarea>
                    </div>
                    {{-- description ends --}}

                    {{-- price starts --}}
                    <div class="mb-3">
                        <label class="form-label" for="ecommerce-product-name">Price</label>
                        <input type="number" class="form-control" id="ecommerce-product-name" placeholder="Price"
                            name="price" value="{{ old('price') ?? null }}">

                        @error('price')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- price ends --}}

                    {{-- show upload image starts --}}
                    <div id="preview">

                    </div>
                    {{-- show upload image ends --}}

                    {{-- image upload starts --}}
                    <div class="mb-3">

                        <label for="images[]" class="form-label">Upload Images</label>
                        <input id="fileInput" name="images[]" class="form-control" type="file" multiple />

                        @error('images')
                            <p style="color: red">{{ $message }}</p>
                        @enderror

                        @foreach ($errors->get('images.*') as $messages)
                            @foreach ($messages as $message)
                                <p style="color: red">{{ $message }}</p>
                            @endforeach
                        @endforeach
                    </div>
                    {{-- image upload ends --}}

                    {{-- categories --}}
                    <div class="mb-3">
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
                    </div>
                    {{-- categories ends --}}

                    {{-- Add Variants Stars --}}
                    <div class="form-repeater" id="variant-container">
                        {{--  Variants Button Ends  --}}
                        <label class="form-label" for="ecommerce-product-name">Variants</label>
                        <div class="d-flex mb-2">
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
                        {{-- Variants Button Ends --}}

                        {{-- select variants starts --}}
                        <div id="default">
                            <div class="row">
                                <div class="mt-2 col-4">
                                    <select name="color[]" class="form-select">
                                        <option selected value="">Color</option>
                                        @foreach ($colors as $color)
                                            <option value="{{ $color->color }}">{{ $color->color }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-2 col-3">
                                    <select name="size[]" class="form-select">
                                        <option selected value="">Size</option>
                                        @foreach ($sizes as $size)
                                            <option value="{{ $size->size }}">{{ $size->size }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mt-2 col-4">
                                    <input name="stock[]" type="number" id="form-repeater-1-2" class="form-control"
                                        placeholder="Stock">
                                </div>

                                <button onclick="deleteElement('default')" type="button"
                                    class="mt-3 col-1 btn-close"></button>
                            </div>
                        </div>
                        {{-- select variants ends --}}

                        @error('color*')
                            <p style="color: red">The color field is required.</p>
                        @enderror

                        @error('size*')
                            <p style="color: red">The size field is required.</p>
                        @enderror


                        @error('stock*')
                            <p style="color: red">The stock field is required.</p>
                        @enderror

                    </div>
                    {{-- Add Variants Ends --}}

                    <button type="submit" class="mt-3 btn btn-success">Submit</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('style')
    <style>
        #preview {
            display: flex;
        }

        .preview-image {
            margin: 5px;
            width: 180px;
            border: 1x solid black;
        }
    </style>
@endsection

@section('script')
    <script>
        let id1 = 0;
        let id2 = 0;

        const fileInput = document.getElementById('fileInput');
        const preview = document.getElementById('preview');

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

        fileInput.addEventListener('change', function() {
            preview.innerHTML = ''; // Clear previous previews

            const files = this.files;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (!file.type.startsWith('image/')) {
                    continue; // Skip if not an image file
                }

                const reader = new FileReader();
                reader.onload = function(event) {
                    const imageUrl = event.target.result;
                    const img = document.createElement('img');
                    img.src = imageUrl;
                    img.classList.add('preview-image');
                    preview.appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
