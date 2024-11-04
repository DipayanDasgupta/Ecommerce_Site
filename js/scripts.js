// JavaScript for managing cart functionality

// Get the cart from localStorage or initialize as empty
let cart = JSON.parse(localStorage.getItem("cart")) || [];

// Function to save cart to localStorage
function saveCart() {
    localStorage.setItem("cart", JSON.stringify(cart));
}

// Function to add item to the cart
function addToCart(productId) {
    // Check if the product is already in the cart
    const existingProduct = cart.find(item => item.id === productId);

    if (existingProduct) {
        existingProduct.quantity += 1;
    } else {
        cart.push({ id: productId, quantity: 1 });
    }
    saveCart();
    updateCartCount();
    alert("Product added to cart!");
}

// Function to update cart item count on page load
function updateCartCount() {
    const cartCount = cart.reduce((total, item) => total + item.quantity, 0);
    document.getElementById("cart-count").textContent = cartCount;
}

// Function to display cart items on the cart page
function displayCartItems(products) {
    const cartItemsContainer = document.getElementById("cart-items");
    cartItemsContainer.innerHTML = "";

    let total = 0;

    cart.forEach(cartItem => {
        const product = products.find(p => p.id === cartItem.id);
        if (product) {
            const itemTotal = product.price * cartItem.quantity;
            total += itemTotal;

            const itemDiv = document.createElement("div");
            itemDiv.className = "cart-item";
            itemDiv.innerHTML = `
                <p>${product.name} - $${product.price} x ${cartItem.quantity} = $${itemTotal.toFixed(2)}</p>
                <button onclick="removeFromCart(${product.id})">Remove</button>
            `;
            cartItemsContainer.appendChild(itemDiv);
        }
    });

    document.getElementById("cart-total").textContent = `Total: $${total.toFixed(2)}`;
}

// Function to remove item from the cart
function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    saveCart();
    updateCartCount();
    window.location.reload();
}

// Initial setup
window.addEventListener("load", () => {
    updateCartCount();

    // If on the cart page, load the cart items
    if (window.location.pathname.endsWith("cart.php")) {
        // Fetch product data from the server
        fetch("get_products.php")
            .then(response => response.json())
            .then(products => displayCartItems(products))
            .catch(error => console.error("Error loading products:", error));
    }
});
