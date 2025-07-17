document.addEventListener("DOMContentLoaded", function () {
    let cartItems = JSON.parse(localStorage.getItem("cart")) || [];

    function renderCart() {
        const cartContainer = document.getElementById("cart-items");
        cartContainer.innerHTML = "";

        let subtotal = 0;
        cartItems.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;

            const cartItem = `
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="${item.image}" class="img-fluid rounded-start" alt="${item.title}">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">${item.title}</h5>
                                <p class="card-text">${item.description}</p>
                                <p class="card-text"><small class="text-muted">Precio: S/${item.price.toFixed(2)}</small></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <label for="cantidad${index}" class="form-label">Cantidad:</label>
                                        <input type="number" id="cantidad${index}" class="form-control" value="${item.quantity}" min="1" data-index="${index}">
                                    </div>
                                    <button class="btn btn-danger" data-index="${index}">Eliminar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            cartContainer.insertAdjacentHTML("beforeend", cartItem);
        });

        document.getElementById("cart-subtotal").innerText = `Subtotal: S/${subtotal.toFixed(2)}`;
        const shipping = 10.00;
        document.getElementById("cart-shipping").innerText = `Envío: S/${shipping.toFixed(2)}`;
        document.getElementById("cart-total").innerText = `Total: S/${(subtotal + shipping).toFixed(2)}`;
    }

    function updateCart() {
        localStorage.setItem("cart", JSON.stringify(cartItems));
        renderCart();
    }

    document.getElementById("cart-items").addEventListener("change", function (e) {
        if (e.target.tagName === "INPUT" && e.target.type === "number") {
            const index = e.target.getAttribute("data-index");
            cartItems[index].quantity = parseInt(e.target.value, 10);
            updateCart();
        }
    });

    document.getElementById("cart-items").addEventListener("click", function (e) {
        if (e.target.tagName === "BUTTON" && e.target.classList.contains("btn-danger")) {
            const index = e.target.getAttribute("data-index");
            cartItems.splice(index, 1);
            updateCart();
        }
    });

    document.querySelectorAll(".add-to-cart").forEach(button => {
        button.addEventListener("click", function () {
            const product = {
                title: this.getAttribute("data-title"),
                description: this.getAttribute("data-description"),
                price: parseFloat(this.getAttribute("data-price")),
                image: this.getAttribute("data-image"),
                quantity: 1
            };

            const existingProductIndex = cartItems.findIndex(item => item.title === product.title);
            if (existingProductIndex >= 0) {
                cartItems[existingProductIndex].quantity++;
            } else {
                cartItems.push(product);
            }

            updateCart();
        });
    });

    renderCart();
});
