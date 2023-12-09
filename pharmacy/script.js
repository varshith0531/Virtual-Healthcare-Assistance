let cartItems = [];

function addToCart(name, strength, price, image) {
    const item = { name, strength, price, image };
    cartItems.push(item);
    alert(`Added "${name} - ${strength}" to cart.`);
    saveCartToLocalStorage();
    updateCartTable(); // Update the cart table when an item is added
}

function removeFromCart(index) {
    if (index >= 0 && index < cartItems.length) {
        const removedItem = cartItems.splice(index, 1)[0];
        alert(`Removed "${removedItem.name} - ${removedItem.strength}" from cart.`);
        saveCartToLocalStorage();
        updateCartTable(); // Update the cart table when an item is removed
    }
}

function loadCartFromLocalStorage() {
    const cartData = localStorage.getItem('cartItems');
    if (cartData) {
        cartItems = JSON.parse(cartData);
    }
}

function saveCartToLocalStorage() {
    localStorage.setItem('cartItems', JSON.stringify(cartItems));
}

function calculateTotalPrice() {
    let total = 0;
    cartItems.forEach(item => {
        total += item.price;
    });
    return total;
}

function updateCartTable(tableId) {
    const cartTable = document.getElementById(tableId);
    cartTable.innerHTML = `
        <tr>
            <th>Tablet Name</th>
            <th>Strength</th>
            <th>Price</th>
            <th>Image</th>
            ${tableId === 'cart-table-cart' ? '' : '<th>Action</th>'}
        </tr>
    `;

    cartItems.forEach((item, index) => {
        cartTable.innerHTML += `
            <tr>
                <td>${item.name}</td>
                <td>${item.strength}</td>
                <td>$${item.price}</td>
                <td><img src="${item.image}" alt="${item.name}" style="height: 50px;"></td>
                <td><button onclick="removeFromCart(${index})">Remove</button></td>
            </tr>
        `;
    });

    if (tableId === 'cart-table-cart') {
        const totalPriceElement = document.getElementById('total-price');
        totalPriceElement.textContent = '$' + calculateTotalPrice();
    }
}

function checkout() {
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const address = document.getElementById('address').value; // Get address value

    const total = calculateTotalPrice();

    if (!name || !email || !phone || !address) {
        alert('Please fill in all customer information.');
        return;
    }

    const data = {
        name,
        email,
        phone,
        address,
        total,
        cartItems // Include the updated cartItems array here
    };

    fetch('checkou.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        alert(result.message);
        cartItems = []; // Clear the cartItems array after successful checkout
        saveCartToLocalStorage();
        updateCartTable();
        document.getElementById('name').value = '';
        document.getElementById('email').value = '';
        document.getElementById('phone').value = '';
        document.getElementById('address').value = ''; // Clear the address input field
    })
    .catch(error => {
        alert('An error occurred. Please try again later.');
    });
}

function handleFormSubmit(event) {
    event.preventDefault();
    checkout();
}

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', handleFormSubmit);
    }
    loadCartFromLocalStorage();
    updateCartTable('cart-table-cart'); // Update cart table in cart.html
    updateCartTable('cart-table-disease'); // Update cart table in cold_flu.html
    updateCartTable();
});
function removeFromCart(index) {
    if (index >= 0 && index < cartItems.length) {
        const removedItem = cartItems.splice(index, 1)[0];
        alert(`Removed "${removedItem.name} - ${removedItem.strength}" from cart.`);
        updateCartTable('cart-table-cart');
        saveCartToLocalStorage(); // Save updated cart data to Local Storage
    }
}
fetch('checkout.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
})
