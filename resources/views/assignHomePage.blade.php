@include('partials.header')

<div class="nav-bar m-auto mt-4 p-4">
    <div class="nav-bar-title font-montserratMedium m-auto max-w-fit font-barlowMedium md:text-4xl text-2xl mb-4">
        Assignment application
    </div>
</div>

<div id="notification"
     class="app-notifications w-fit border border-asig-successGreen bg-asig-lightGreen p-2 rounded-[18px]
     fixed left-0 right-0 m-auto transition-all duration-500 -top-20 z-50">
    <div id="notification-text" class="app-notification-text font-montserratRegular"></div>
</div>


<div class="product-list-container m-auto mt-4 p-4">
    <div class="product-list m-auto w-3/4">
        <div class="product-list-header flex m-auto w-full mb-2 text-sm md:text-base lg:text-xl xl2:text-2xl">
            <div class="product-list-header-left-side w-[calc(35%+100px)] md:w-[calc(35%+120px)] lg:w-[calc(45%+160px)] pl-8">
                Product
            </div>
            <div class="product-list-header-right-side ml-auto flex w-[39%] xl2:w-[35%] font-barlowMedium">
                <div class="title-category w-1/2">Category</div>
                <div class="title-price mx-auto w-[45%] md:w-[35%]">Price</div>
            </div>
        </div>

        @foreach ($products as $product)
            <div class="product-item h-[125px] md:h-[140px] lg:h-[160px] flex mb-6">
                <div class="product-container flex w-full border-y border-[#e1e1e1] transition-transform duration-200
                hover:scale-[1.02] hover:shadow-md">
                    <div class="product-img content-center max-w-[100px] md:max-w-[120px] lg:max-w-[160px]">
                        <img class="w-max object-contain aspect-square" src="{{ $product->image_url }}" alt="Product Image">
                    </div>
                    <div class="product-info w-[35%] xl2:w-[45%] h-full content-center ml-4">
                        <div class="product-name text-sm md:text-base lg:text-xl xl2:text-2xl font-barlowMedium">
                            {{ $product->name }}
                        </div>
                        <div class="product-description mt-4 truncate text-xs lg:text-base font-montserratRegular">
                            {{ $product->description }}
                        </div>
                    </div>
                    <div class="product-item-right-side ml-auto flex text-xs md:text-sm lg:text-xl xl2:text-2xl w-[39%]
                    xl2:w-[35%]">
                        <div class="product-category content-center w-1/2 font-barlowMedium">
                            {{ $product->category }}
                        </div>
                        <div class="product-price mx-auto content-center text-center w-[40%] md:w-[35%] font-barlowMedium">
                            {{ $product->currency_symbol }} {{ $product->price }}
                        </div>
                        <div class="product-buttons content-center ml-4 relative w-1/5">
                            <img class="three-dots scale-100 lg:scale-125 cursor-pointer w-[30px] h-[30px]"
                                 src="{{ asset('svg/3dots.svg') }}"
                                 alt="3 Dots" data-dropdown-id="dropdown-menu-{{ $product->id }}">
                            <div id="dropdown-menu-{{ $product->id }}" class="product-button-dropdown absolute right-0
                            mt-2 bg-white border shadow-lg
                            w-40 p-6 hidden z-10 justify-items-center">
                                <div class="product-share-button flex cursor-pointer mb-2"
                                     onclick="openModal({{ json_encode($product) }})">
                                    <img class="w-1/5" src="{{ asset('svg/share-arrows.svg') }}" alt="Share icon">
                                    <div class="w-4/5 text-center">Share</div>
                                </div>
                                <div class="product-delete-button flex cursor-pointer"
                                     onclick="deleteProduct({{ $product->id }})">
                                    <img class="w-1/5" src="{{ asset('svg/red-trash-can-icon.svg') }}" alt="Delete icon">
                                    <div class="w-4/5 text-center">Delete</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div id="productModal" class="product-modal-container fixed inset-0 bg-gray-600 bg-opacity-50 z-50 hidden
        justify-center items-center flex">
            <div class="product-modal-wrapper bg-white p-6 rounded-lg max-w-sm w-full">
                <div class="product-modal-title text-2xl font-bold mb-4 text-center font-barlowMedium">Share Your Product!</div>
                <div class="product-modal-image mb-4">
                    <img class="max-h-[240px] justify-self-center" id="productImage" src="" alt="Product Image">
                </div>
                <div class="product-modal-name mb-4">
                    <div id="name" class="block text-sm font-montserratRegular">Product name</div>
                </div>
                <div class="product-modal-description mb-4">
                    <div id="description" class="block text-sm font-montserratRegular">Product Description</div>
                </div>
                <div class="product-modal-buttons flex justify-between">
                    <button type="button" onclick="closeModal()" class="product-modal-close bg-red-500 text-white px-4
                    py-2 rounded-md">
                        Close
                    </button>
                    <button type="button" onclick="copyToClipboard()" class="product-modal-share bg-blue-500 text-white
                    px-4 py-2 rounded-md">
                        Share
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            showNotification(@json(session('success')));
        });
    </script>
@endif

<script>
    function showNotification(message) {
        const notification = document.getElementById('notification');
        const notificationText = document.getElementById('notification-text');

        notificationText.textContent = message;

        notification.classList.remove('-top-20');
        notification.classList.add('top-6');

        setTimeout(() => {
            notification.classList.remove('top-6');
            notification.classList.add('-top-20');
        }, 5000);
    }

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

    function openModal(product) {
        document.getElementById('productModal').classList.remove('hidden');

        window.productUrl = product.url;
        document.getElementById('name').innerHTML = product.name;
        document.getElementById('description').innerHTML = product.description;
        document.getElementById('productImage').src = product.image_url;
    }

    function closeModal() {
        document.getElementById('productModal').classList.add('hidden');
    }

    function copyToClipboard() {
        const productShareUrlInput = document.createElement('input');
        productShareUrlInput.value = window.productUrl;
        document.body.appendChild(productShareUrlInput);

        productShareUrlInput.select();
        document.execCommand('copy');

        document.body.removeChild(productShareUrlInput);
        closeModal();

        showNotification('Product link copied to clipboard');
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
