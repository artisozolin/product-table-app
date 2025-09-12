@include('partials.header')

<div class="nav-bar">
    <div class="nav-bar-title">
        Assignment application
    </div>
</div>

<div id="notification"
     class="app-notifications -top-20 z-50">
    <div id="notification-text" class="app-notification-text"></div>
</div>


<div class="product-list-container">
    <div class="product-list">
        <div class="product-list-header">
            <div class="product-list-header-left-side">
                Product
            </div>
            <div class="product-list-header-right-side">
                <div class="title-category">Category</div>
                <div class="title-price">Price</div>
            </div>
        </div>

        @foreach ($products as $product)
            <div class="product-item">
                <div class="product-container">
                    <div class="product-img-container">
                        <img class="product-img"
                             src="{{ $product->image_url }}"
                             alt="Product Image">
                    </div>
                    <div class="product-info">
                        <div class="product-name">
                            {{ $product->name }}
                        </div>
                        <div class="product-description">
                            {{ $product->description }}
                        </div>
                    </div>
                    <div class="product-item-right-side">
                        <div class="product-category">
                            {{ $product->category }}
                        </div>
                        <div class="product-price">
                            {{ $product->currency_symbol }} {{ $product->price }}
                        </div>
                        <div class="product-buttons">
                            <img class="three-dots"
                                 src="{{ asset('svg/3dots.svg') }}"
                                 alt="3 Dots" data-dropdown-id="dropdown-menu-{{ $product->id }}">
                            <div id="dropdown-menu-{{ $product->id }}" class="product-button-dropdown hidden">
                                <div class="product-share-button-container"
                                     onclick="openModal({{ json_encode($product) }})">
                                    <img class="dropdown-button-icon"
                                         src="{{ asset('svg/share-arrows.svg') }}"
                                         alt="Share icon">
                                    <div class="dropdown-button-text">Share</div>
                                </div>
                                <div class="product-delete-button-container"
                                     onclick="deleteProduct({{ $product->id }})">
                                    <img class="dropdown-button-icon"
                                         src="{{ asset('svg/red-trash-can-icon.svg') }}"
                                         alt="Delete icon">
                                    <div class="dropdown-button-text">Delete</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div id="productModal" class="product-modal-container hidden">
            <div class="product-modal-wrapper">
                <div class="product-modal-title">Share Your Product!</div>
                <div class="product-modal-image-container">
                    <img class="product-modal-image"
                         id="productImage"
                         src=""
                         alt="Product Image">
                </div>
                <div class="product-modal-name-container">
                    <div id="name" class="product-modal-name">Product name</div>
                </div>
                <div class="product-modal-description-container">
                    <div id="description" class="product-modal-description">Product Description</div>
                </div>
                <div class="product-modal-buttons">
                    <button type="button" onclick="closeModal()" class="product-modal-close">
                        Close
                    </button>
                    <button type="button" onclick="copyToClipboard()" class="product-modal-share">
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
        const productModal = document.getElementById('productModal');

        productModal.classList.remove('hidden');
        productModal.classList.add('flex');

        window.productUrl = product.url;
        document.getElementById('name').innerHTML = product.name;
        document.getElementById('description').innerHTML = product.description;
        document.getElementById('productImage').src = product.image_url;
    }

    function closeModal() {
        const productModal = document.getElementById('productModal');

        productModal.classList.add('hidden');
        productModal.classList.remove('flex');
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
