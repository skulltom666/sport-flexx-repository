// scripts.js

document.addEventListener('DOMContentLoaded', function () {
    const productForm = document.getElementById('product-form');
    const productList = document.getElementById('product-list');
    const categorySelect = document.getElementById('product-category');
    let products = [];
    let editingProductIndex = null;

    productForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const name = document.getElementById('product-name').value;
        const description = document.getElementById('product-description').value;
        const price = document.getElementById('product-price').value;
        const stock = document.getElementById('product-stock').value;
        const category = document.getElementById('product-category').value;

        if (editingProductIndex !== null) {
            // Edit product
            products[editingProductIndex] = { name, description, price, stock, category };
            editingProductIndex = null;
            document.getElementById('form-title').textContent = 'Agregar Producto';
        } else {
            // Add new product
            products.push({ name, description, price, stock, category });
        }

        // Reset form
        productForm.reset();

        // Render products
        renderProducts();
    });

    function renderProducts() {
        productList.innerHTML = '';
        products.forEach((product, index) => {
            const col = document.createElement('div');
            col.classList.add('col');
            col.innerHTML = `
                <div class="card">
                    <img src="path/to/image" class="card-img-top" alt="${product.name}">
                    <div class="card-body">
                        <h5 class="card-title">${product.name}</h5>
                        <p class="card-text">${product.description}</p>
                        <p><strong>Precio:</strong> S/${product.price}</p>
                        <p><strong>Stock:</strong> ${product.stock}</p>
                        <p><strong>Categoría:</strong> ${product.category}</p>
                        <div class="actions">
                            <button class="edit btn btn-primary" data-index="${index}">Editar</button>
                            <button class="delete btn btn-danger" data-index="${index}">Eliminar</button>
                        </div>
                    </div>
                </div>
            `;
            productList.appendChild(col);
        });

        // Add event listeners for edit and delete buttons
        document.querySelectorAll('.edit').forEach(button => {
            button.addEventListener('click', function () {
                const index = this.getAttribute('data-index');
                editProduct(index);
            });
        });

        document.querySelectorAll('.delete').forEach(button => {
            button.addEventListener('click', function () {
                const index = this.getAttribute('data-index');
                deleteProduct(index);
            });
        });
    }

    function editProduct(index) {
        const product = products[index];
        document.getElementById('product-name').value = product.name;
        document.getElementById('product-description').value = product.description;
        document.getElementById('product-price').value = product.price;
        document.getElementById('product-stock').value = product.stock;
        document.getElementById('product-category').value = product.category;
        editingProductIndex = index;
        document.getElementById('form-title').textContent = 'Editar Producto';
    }

    function deleteProduct(index) {
        products.splice(index, 1);
        renderProducts();
    }

    // Initial render
    renderProducts();
});
