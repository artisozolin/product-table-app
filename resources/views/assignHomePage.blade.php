@include('partials.header')

<div class="nav-bar m-auto mt-4 p-4">
    <div class="nav-bar-title m-auto max-w-fit font-barlowMedium sm:text-4xl text-2xl mb-4">
        Assignment application
    </div>
</div>

<div class="product-list-container m-auto mt-4 p-4">
    <div class="product-list m-auto w-3/4">
        <div class="product-list-header flex m-auto w-full mb-2 text-2xl">
            <div class="product-list-header-left-side">
                Product
            </div>
            <div class="product-list-header-right-side ml-auto flex">
                <div class="title-category">Category</div>
                <div class="title-price mx-16">Price</div>
            </div>
        </div>

        @foreach ($products as $product)
            <div class="product-item flex mb-6">
                <div class="product-container flex w-full">
                    <div class="product-img max-w-[120px]">
                        <img src="{{ $product->image_url }}">
                    </div>
                    <div class="product-info h-full content-center ml-2">
                        <div class="product-name text-2xl">
                            {{ $product->name }}
                        </div>
                        <div class="product-description">
                            {{ $product->description }}
                        </div>
                    </div>
                    <div class="product-item-right-side ml-auto flex text-2xl">
                        <div class="product-category content-center">
                            {{ $product->category }}
                        </div>
                        <div class="product-price ml-16 content-center">
                            {{ $product->currency }} {{ $product->price }}
                        </div>
                        <div class="product-buttons content-center ml-4 relative">
                            <img class="three-dots scale-125 cursor-pointer" src="{{ asset('svg/3dots.svg') }}"
                                 alt="3 Dots" data-dropdown-id="dropdown-menu-{{ $product->id }}">
                            <div id="dropdown-menu-{{ $product->id }}" class="product-button-dropdown absolute right-0 mt-2 bg-white border shadow-lg
                            w-40 p-6 hidden z-10 justify-items-center">
                                <div class="product-share-button flex cursor-pointer mb-2">
                                    <img class="w-6" src="{{ asset('svg/share-arrows.svg') }}" alt="Share icon">
                                    <div>Share</div>
                                </div>
                                <div class="product-delete-button flex cursor-pointer"  onclick="deleteProduct({{ $product->id }})">
                                    <img class="w-6" src="{{ asset('svg/red-trash-can-icon.svg') }}" alt="Delete icon">
                                    <div>Delete</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>

<script>
    function deleteProduct(productId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/product/${productId}`;
        form.innerHTML = `
            @csrf
        @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }

    document.addEventListener("DOMContentLoaded", function() {
        const threeDotsButtons = document.querySelectorAll('.three-dots');

        threeDotsButtons.forEach(button => {
            button.addEventListener('click', function() {
                const dropdownId = button.getAttribute('data-dropdown-id');
                const dropdownMenu = document.getElementById(dropdownId);

                const openDropdowns = document.querySelectorAll('.product-button-dropdown:not(.hidden)');
                openDropdowns.forEach(dropdown => {
                    dropdown.classList.add('hidden');
                });

                dropdownMenu.classList.toggle('hidden');
            });
        });

        document.addEventListener('click', function(event) {
            const clickedInsideDropdown = event.target.closest('.product-button-dropdown');
            const clickedInsideThreeDots = event.target.closest('.three-dots');

            if (!clickedInsideDropdown && !clickedInsideThreeDots) {
                const openDropdowns = document.querySelectorAll('.product-button-dropdown:not(.hidden)');
                openDropdowns.forEach(dropdown => {
                    dropdown.classList.add('hidden');
                });
            }
        });
    });
</script>

@include('partials.footer')
