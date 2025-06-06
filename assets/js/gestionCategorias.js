// Módulo principal de la aplicación para gestión de categorías
const CategoryManager = (() => {
    // Datos de categorías
    let categories = [];
    let editingCategoryId = null;
    let categoryToDelete = null;
    
    // Referencias a elementos DOM
    const DOM = {
        categoryForm: document.getElementById('category-form'),
        categoryNameInput: document.getElementById('category-name'),
        categoryIdInput: document.getElementById('category-id'),
        submitBtn: document.getElementById('submit-btn'),
        cancelEditBtn: document.getElementById('cancel-edit'),
        categoryTableBody: document.getElementById('category-table-body'),
        emptyState: document.getElementById('empty-state'),
        totalCategories: document.getElementById('total-categories'),
        confirmDeleteBtn: document.getElementById('confirm-delete')
    };
    
    // Inicializar la aplicación
    const init = () => {
        renderCategoryList(categories);
        updateStats();
        setupEventListeners();
    };
    
    // Configurar event listeners
    const setupEventListeners = () => {
        DOM.categoryForm.addEventListener('submit', handleFormSubmit);
        DOM.cancelEditBtn.addEventListener('click', cancelEdit);
        DOM.confirmDeleteBtn.addEventListener('click', deleteCategory);
    };
    
    // Renderizar lista de categorías
    const renderCategoryList = (categoryList = categories) => {
        DOM.categoryTableBody.innerHTML = '';
        
        if (categoryList.length === 0) {
            DOM.emptyState.style.display = 'block';
            return;
        }
        
        DOM.emptyState.style.display = 'none';
        
        categoryList.forEach(category => {
            const tr = document.createElement('tr');
            
            tr.innerHTML = `
                <td>${category.name}</td>
                <td>
                    <button class="btn btn-warning btn-sm edit-category-btn" data-id="${category.id}">
                        <i class="fas fa-edit"></i> Editar
                    </button>
                    <button class="btn btn-danger btn-sm delete-category-btn" data-id="${category.id}">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </td>
            `;
            
            DOM.categoryTableBody.appendChild(tr);
        });
        
        addDynamicEventListeners();
    };
    
    // Agregar eventos a elementos dinámicos
    const addDynamicEventListeners = () => {
        document.querySelectorAll('.edit-category-btn').forEach(btn => {
            btn.addEventListener('click', () => editCategory(btn.dataset.id));
        });
        
        document.querySelectorAll('.delete-category-btn').forEach(btn => {
            btn.addEventListener('click', () => confirmDelete(btn.dataset.id));
        });
    };
    
    // Actualizar estadísticas
    const updateStats = () => {
        DOM.totalCategories.textContent = categories.length;
    };
    
    // Manejar envío del formulario
    const handleFormSubmit = e => {
        e.preventDefault();
        
        if (!DOM.categoryNameInput.value.trim()) {
            alert("Por favor ingresa un nombre de categoría.");
            return;
        }
        
        const categoryData = {
            id: editingCategoryId || Date.now().toString(),
            name: DOM.categoryNameInput.value.trim()
        };
        
        if (editingCategoryId) {
            updateCategory(categoryData);
        } else {
            createCategory(categoryData);
        }
        
        resetForm();
    };
    
    // Crear una nueva categoría
    const createCategory = category => {
        categories.push(category);
        renderCategoryList(categories);
        updateStats();
    };
    
    // Actualizar categoría existente
    const updateCategory = updatedCategory => {
        categories = categories.map(category => category.id === updatedCategory.id ? updatedCategory : category);
        renderCategoryList(categories);
        updateStats();
        cancelEdit();
    };
    
    // Editar categoría
    const editCategory = categoryId => {
        const category = categories.find(c => c.id === categoryId);
        
        if (category) {
            DOM.categoryIdInput.value = category.id;
            DOM.categoryNameInput.value = category.name;
            
            document.getElementById('form-title').textContent = 'Editar Categoría';
            DOM.submitBtn.innerHTML = '<i class="fas fa-save me-2"></i> Guardar Cambios';
            DOM.cancelEditBtn.style.display = 'block';
            editingCategoryId = category.id;
        }
    };
    
    // Cancelar edición
    const cancelEdit = () => {
        resetForm();
        document.getElementById('form-title').textContent = 'Agregar Nueva Categoría';
        DOM.submitBtn.innerHTML = '<i class="fas fa-plus me-2"></i> Agregar Categoría';
        DOM.cancelEditBtn.style.display = 'none';
        editingCategoryId = null;
    };
    
    // Resetear formulario
    const resetForm = () => {
        DOM.categoryForm.reset();
    };
    
    // Confirmar eliminación
    const confirmDelete = categoryId => {
        categoryToDelete = categoryId;
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    };
    
    // Eliminar categoría
    const deleteCategory = () => {
        categories = categories.filter(category => category.id !== categoryToDelete);
        renderCategoryList(categories);
        updateStats();
        bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
        categoryToDelete = null;
    };
    
    return {
        init
    };
})();

// Iniciar la aplicación cuando el DOM esté cargado
document.addEventListener('DOMContentLoaded', () => {
    CategoryManager.init();
});
