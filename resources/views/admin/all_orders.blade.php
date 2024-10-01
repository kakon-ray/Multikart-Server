@extends('admin_index', ['allorders' => 'active'])
@section('content')
    <h3 style="color: green; text-align: center; margin-top: 7px">{{ session('message') ?? null }}</h3>

    <div class="">
        <table class="table align-middle mb-0 bg-white">
            <thead class="bg-light">
                <tr>
                    <th class="p-2 align-middle">Order ID</th>
                    <th class="p-2 align-middle">Cust. Name</th>
                    <th class="p-2 align-middle">Items</th>
                    <th class="p-2 align-middle">Qty</th>
                    <th class="p-2 align-middle">Total Price</th>
                    <th class="p-2 align-middle">Status</th>
                    <th class="p-2 align-middle">Action</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($orders as $order)
                    <tr>
                        {{-- order id --}}
                        <td class="p-2 align-middle">
                            <div class="d-flex align-items-center">
                                <p class="mb-1">
                                    {{ $order->id }}
                                </p>
                            </div>
                        </td>

                        {{-- Customer Name --}}
                        <td class="p-2 align-middle">
                            <p class="fw-normal mb-1">
                                {{ $order->users->name }}
                            </p>
                        </td>


                        {{-- items --}}
                        <td class="p-2 align-middle">
                            @foreach ($images as $key => $image)
                                @foreach ($items as $item)
                                    @if ($order->id == $item->order_id && $image->product_id == $item->product_id)
                                        <div class="d-flex align-items-center">
                                            <img class="m-1" src="{{ asset('product_images/' . $image->image_path) }}"
                                                alt="" style="width: 50px;">
                                            <li class="mx-4">
                                                {{ $item->product_name }}
                                            </li>
                                        </div>
                                    @endif
                                @endforeach
                            @endforeach
                        </td>

                        {{-- Qty --}}
                        <td class="p-2 align-middle">
                            <p class="fw-normal mb-1">
                                @php
                                    $qty = 0;
                                @endphp
                                @foreach ($order->items as $item)
                                    @php
                                        $qty = $qty + $item->quantity;
                                    @endphp
                                @endforeach
                                {{ $qty }}
                            </p>
                        </td>

                        {{-- Total Price --}}
                        <td class="p-2 align-middle">
                            @php
                                $price = 0;
                            @endphp
                            <p class="fw-normal mb-1">
                                @php
                                    $price = 0;
                                @endphp
                                @foreach ($order->items as $item)
                                    @php
                                        $price += $item->unit_price;
                                    @endphp
                                @endforeach
                                {{ $price }}
                            </p>
                        </td>

                        {{-- Status --}}
                        <td class="p-2 align-middle">
                            <p class="fw-normal mb-1">
                                @if (!$order->status)
                                    <button class="btn btn-sm disabled btn-warning">
                                        <i class="fa-solid fa-hourglass-half"></i>
                                    </button>
                                @else
                                    <button class="btn btn-sm disabled btn-success">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                @endif
                            </p>
                        </td>

                        {{-- action button --}}
                        <td class="p-2 align-middle">
                            <form action="{{ route('order_done', $order->id) }}" method="POST"
                                style="display: inline-block">
                                @csrf
                                @method('put')
                                <button {{ $order->status ? 'disabled' : null }} class="btn btn-sm btn-primary">
                                    Done
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <div class="d-flex justify-content-center">
                    {{ $orders->links() }}
                </div>
            </tbody>
        </table>

    </div>
@endsection
