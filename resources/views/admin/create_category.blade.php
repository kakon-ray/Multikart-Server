@extends('admin_index', ['create_category' => 'active'])

@section('content')
    <div class="row">
        <h3 style="
        color: green;
        text-align: center;
        margin-top: 8px">
            {{ Session::get('message') ?? null }}
        </h3>
        <div class="col-lg-7 col-sm">
            <form action="{{ route('create_category') }}" method="POST">
                @csrf
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-tile mb-0">Create Category</h5>
                    </div>
                    <div class="card-body">
                        {{-- title --}}
                        <div class="mb-3">
                            <label class="form-label" for="ecommerce-product-name">Category Name</label>
                            <input type="text" class="form-control" placeholder="Category Name" name="category"
                                aria-label="title" value="{{ old('size') ?? null }}">
                            @error('category')
                                <p style="color: red">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success">Add Category</button>
                    </div>
                </div>
        </div> {{-- 1st col --}}
        </form>

        <div class="col-lg-5 col-sm">
            <div class="card">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Category Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categorys as $key => $category)
                            <tr>
                                <td scope="row">{{ $key + 1 }}</td>
                                <td>{{ $category->category }}</td>
                                <td>
                                    <form action="{{ route('delete_category', ['categoryId' => $category->id]) }}"
                                        method="POST">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

<!-- {{-- @section('script')
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
@endsection --}} -->
