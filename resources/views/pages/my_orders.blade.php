@extends('home', ['myorders' => 'active'])

@section('content')
    <!-- Page Header Start -->
    {{-- <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Shopping Cart</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Shopping Cart</p>
            </div>
        </div>
    </div> --}}
    <!-- Page Header End -->

    <!-- order Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-10 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Order Id</th>
                            <th>Items</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($orders as $order)
                            <tr>
                                {{-- order id --}}
                                <td>
                                    <p class="mt-4">{{ $order->id }}</p>
                                </td>
                                {{-- items --}}
                                <td class="align-middle text-left">
                                    @foreach ($images as $key => $image)
                                        @foreach ($items as $item)
                                            @if ($order->id == $item->order_id && $image->product_id == $item->product_id)
                                                <div class="d-flex align-items-center">
                                                    <img class="m-1"
                                                        src="{{ asset('product_images/' . $image->image_path) }}"
                                                        alt="" style="width: 50px;">
                                                    <li class="mx-4">
                                                        {{ $item->product_name }}
                                                    </li>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </td>

                                {{-- color --}}
                                <td class="align-middle" style="width: 90px">
                                    @foreach ($items as $key => $item)
                                        @if ($order->id == $item->order_id)
                                            <div class="m-4">
                                                {{ $item->color }}
                                            </div>
                                        @endif
                                    @endforeach
                                </td>

                                {{-- Size --}}
                                <td class="align-middle" style="width: 90px">
                                    @foreach ($items as $key => $item)
                                        @if ($order->id == $item->order_id)
                                            <div class="m-4">
                                                {{ $item->size }}
                                            </div>
                                        @endif
                                    @endforeach
                                </td>

                                {{-- total amount --}}
                                <td class="align-middle" style="width: 90px">
                                    {{ $order->total_amount }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        <!-- Cart End -->
    @endsection
