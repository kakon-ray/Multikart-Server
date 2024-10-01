@extends('admin_index', ['create_size' => 'active'])

@section('content')
    <div class="row">
        <h3 style="
        color: green;
        text-align: center;
        margin-top: 8px">
            {{ Session::get('message') ?? null }}
        </h3>
        <div class="col-lg-7 col-sm">
            <form action="{{ route('create_size') }}" method="POST">
                @csrf
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-tile mb-0">Create Size</h5>
                    </div>
                    <div class="card-body">
                        {{-- title --}}
                        <div class="mb-3">
                            <label class="form-label" for="ecommerce-product-name">Size Name</label>
                            <input type="text" class="form-control" placeholder="Color Name" name="size"
                                aria-label="title" value="{{ old('size') ?? null }}">
                            @error('size')
                                <p style="color: red">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success">Add Size</button>
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
                            <th scope="col">Size Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sizes as $key => $size)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $size->size }}</td>
                                <td>
                                    <form action="{{ route('delete_size', ['sizeId' => $size->id]) }}" method="POST">
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
