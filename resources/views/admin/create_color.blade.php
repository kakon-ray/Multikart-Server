@extends('admin_index', ['create_color' => 'active'])

@section('content')
    <div class="row">
        <h3 style="color: green; text-align: center; margin-top: 5px">{{ Session::get('message') ?? null }}</h3>
        <div class="col-lg-7 col-sm">
            <form action="{{ route('create_color') }}" method="POST">
                @csrf
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-tile mb-0">Create Color</h5>
                    </div>
                    <div class="card-body">
                        {{-- title --}}
                        <div class="mb-3">
                            <label class="form-label" for="ecommerce-product-name">Color Name</label>
                            <input type="text" class="form-control" placeholder="Color Name" name="color"
                                aria-label="title" value="{{ old('color') ?? null }}">
                            @error('color')
                                <p style="color: red">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success">Add Color</button>
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
                            <th scope="col">Color Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($colors as $key => $color)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $color->color }}</td>
                                <td>
                                    <form action="{{ route('delete_color', ['colorId' => $color->id]) }}" method="POST">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-sm btn-danger" id="btn" onclick="delete(e)">
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
