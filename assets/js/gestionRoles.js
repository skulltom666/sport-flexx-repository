// Módulo principal de la aplicación para gestión de roles y permisos
const RoleManager = (() => {
    // Datos de roles
    let roles = [];
    let editingRoleId = null;
    let roleToDelete = null;
    
    // Referencias a elementos DOM
    const DOM = {
        roleForm: document.getElementById('role-form'),
        roleNameInput: document.getElementById('role-name'),
        permissionsSelect: document.getElementById('permissions'),
        roleIdInput: document.getElementById('role-id'),
        submitBtn: document.getElementById('submit-btn'),
        cancelEditBtn: document.getElementById('cancel-edit'),
        roleTableBody: document.getElementById('role-table-body'),
        emptyState: document.getElementById('empty-state'),
        totalRoles: document.getElementById('total-roles'),
        totalPermissions: document.getElementById('total-permissions'),
        confirmDeleteBtn: document.getElementById('confirm-delete')
    };
    
    // Inicializar la aplicación
    const init = () => {
        renderRoleList(roles);
        updateStats();
        setupEventListeners();
    };
    
    // Configurar event listeners
    const setupEventListeners = () => {
        DOM.roleForm.addEventListener('submit', handleFormSubmit);
        DOM.cancelEditBtn.addEventListener('click', cancelEdit);
        DOM.confirmDeleteBtn.addEventListener('click', deleteRole);
    };
    
    // Renderizar lista de roles
    const renderRoleList = (roleList = roles) => {
        DOM.roleTableBody.innerHTML = '';
        
        if (roleList.length === 0) {
            DOM.emptyState.style.display = 'block';
            return;
        }
        
        DOM.emptyState.style.display = 'none';
        
        roleList.forEach(role => {
            const tr = document.createElement('tr');
            
            tr.innerHTML = `
                <td>${role.name}</td>
                <td>${role.permissions.join(', ')}</td>
                <td>
                    <button class="btn btn-warning btn-sm edit-role-btn" data-id="${role.id}">
                        <i class="fas fa-edit"></i> Editar
                    </button>
                    <button class="btn btn-danger btn-sm delete-role-btn" data-id="${role.id}">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </td>
            `;
            
            DOM.roleTableBody.appendChild(tr);
        });
        
        addDynamicEventListeners();
    };
    
    // Agregar eventos a elementos dinámicos
    const addDynamicEventListeners = () => {
        document.querySelectorAll('.edit-role-btn').forEach(btn => {
            btn.addEventListener('click', () => editRole(btn.dataset.id));
        });
        
        document.querySelectorAll('.delete-role-btn').forEach(btn => {
            btn.addEventListener('click', () => confirmDelete(btn.dataset.id));
        });
    };
    
    // Actualizar estadísticas
    const updateStats = () => {
        DOM.totalRoles.textContent = roles.length;
        DOM.totalPermissions.textContent = roles.reduce((acc, role) => acc + role.permissions.length, 0);
    };
    
    // Manejar envío del formulario
    const handleFormSubmit = e => {
        e.preventDefault();
        
        const selectedPermissions = Array.from(DOM.permissionsSelect.selectedOptions).map(option => option.value);
        
        if (!DOM.roleNameInput.value.trim()) {
            alert("Por favor ingresa un nombre de rol.");
            return;
        }
        
        const roleData = {
            id: editingRoleId || Date.now().toString(),
            name: DOM.roleNameInput.value.trim(),
            permissions: selectedPermissions
        };
        
        if (editingRoleId) {
            updateRole(roleData);
        } else {
            createRole(roleData);
        }
        
        resetForm();
    };
    
    // Crear un nuevo rol
    const createRole = role => {
        roles.push(role);
        renderRoleList(roles);
        updateStats();
    };
    
    // Actualizar rol existente
    const updateRole = updatedRole => {
        roles = roles.map(role => role.id === updatedRole.id ? updatedRole : role);
        renderRoleList(roles);
        updateStats();
        cancelEdit();
    };
    
    // Editar rol
    const editRole = roleId => {
        const role = roles.find(r => r.id === roleId);
        
        if (role) {
            DOM.roleIdInput.value = role.id;
            DOM.roleNameInput.value = role.name;
            Array.from(DOM.permissionsSelect.options).forEach(option => {
                if (role.permissions.includes(option.value)) {
                    option.selected = true;
                }
            });
            
            document.getElementById('form-title').textContent = 'Editar Rol';
            DOM.submitBtn.innerHTML = '<i class="fas fa-save me-2"></i> Guardar Cambios';
            DOM.cancelEditBtn.style.display = 'block';
            editingRoleId = role.id;
        }
    };
    
    // Cancelar edición
    const cancelEdit = () => {
        resetForm();
        document.getElementById('form-title').textContent = 'Agregar Nuevo Rol';
        DOM.submitBtn.innerHTML = '<i class="fas fa-plus me-2"></i> Agregar Rol';
        DOM.cancelEditBtn.style.display = 'none';
        editingRoleId = null;
    };
    
    // Resetear formulario
    const resetForm = () => {
        DOM.roleForm.reset();
    };
    
    // Confirmar eliminación
    const confirmDelete = roleId => {
        roleToDelete = roleId;
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    };
    
    // Eliminar rol
    const deleteRole = () => {
        roles = roles.filter(role => role.id !== roleToDelete);
        renderRoleList(roles);
        updateStats();
        bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
        roleToDelete = null;
    };
    
    return {
        init
    };
})();

// Iniciar la aplicación cuando el DOM esté cargado
document.addEventListener('DOMContentLoaded', () => {
    RoleManager.init();
});
