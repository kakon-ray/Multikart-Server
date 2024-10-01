<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />

    <title>Add Product - Admin Dashboard</title>

    <!-- Favicons -->
    <link rel="icon" href="favicon.svg" sizes="any" type="image/svg+xml" />
    <link rel="icon" href="favicon.png" type="image/png" />

    <!-- Inter web font from Bunny.net (GDPR compliant) -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    {{-- nav starts here --}}
    <nav class="bg-white border-gray-200 dark:bg-gray-900">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">

            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul
                    class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    <li>
                        <a href="{{ route('index') }}"
                            class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500"
                            aria-current="page">Home</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav> {{-- nav ends here --}}

    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
            <h2 class="mb-4 text-center text-xl font-bold text-gray-900 dark:text-white">Add a new product</h2>
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data"
                id="producInfoForm">
                @csrf
                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">

                    {{-- product title starts here --}}
                    <div class="col-span-full">
                        <label for="name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product Title</label>
                        <input type="text" name="title"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Type product name">

                        @error('title')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror

                    </div>
                    {{-- product title ends here --}}


                    <div>
                        <label for="category"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                        <select id="category"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            @foreach ($categories as $category)
                                <option selected="">{{ $category->category }}</option>
                            @endforeach
                            <option selected="">Select category</option>
                        </select>
                    </div>


                    {{-- price starts here --}}
                    <div class="w-full">
                        <label for="price"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                        <input type="number" name="price" id="price"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="$2999">

                        @error('price')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror

                    </div>
                    {{-- price ends here --}}

                    {{-- category starts here --}}
                    <div>
                        <label for="category"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                        <select id="category" name="category"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            @foreach ($categories as $category)
                                <option selected="" value="{{ $category->category }}">{{ $category->category }}
                                </option>
                            @endforeach
                            <option selected="">Select category</option>
                        </select>

                        @error('category')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror

                    </div>
                    {{-- category ends here --}}




                    {{-- color variant starts here --}}


                    <div class="col-span-full">

                        <button id="createInput"
                            class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                            Add Color
                        </button>

                    </div>

                    <div id="inputContainer">

                        @error('color')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror

                    </div>



                    <div id="inputStockContainer">

                        @error('stock')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror

                    </div>


                    {{-- color variant ends here --}}



                    <div class="sm:col-span-2">
                        <label for="description"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                        <textarea name="desc" id="description" rows="8"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Your description here"></textarea>
                    </div>
                </div>
                <button type="submit" id="submitButton"
                    class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                    Add product
                </button>
            </form>
        </div>
    </section>

    <script>
        document.getElementById("createInput").addEventListener("click", function(event) {
            event.preventDefault();
            console.log("hello");

            let input = document.createElement("input");
            let inputStock = document.createElement("input");

            // Set attributes for the input element
            input.type = "text";
            input.name = "color[]"; // You can set any name you prefer
            input.className =
                "mt-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500";
            input.placeholder = "color"

            // stock
            inputStock.type = "number";
            inputStock.name = "stock"; // You can set any name you prefer
            inputStock.className =
                "mt-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
            inputStock.placeholder = "Stock"

            // Append the input element to a container (e.g., a div with id 'inputContainer')
            document.getElementById("inputContainer").appendChild(input);
            document.getElementById("inputStockContainer").appendChild(inputStock);

            // document.getElementById('submitButton').addEventListener('click', function() {
            //     // Get references to the forms
            //     let form1 = document.getElementById('productInfoForm');
            //     let form2 = document.getElementById('colorVariantForm');

            //     // Submit both forms
            //     form1.submit();
            //     form2.submit();

            //     console.log('hello');
            // })
        });
    </script>
</body>

</html>
