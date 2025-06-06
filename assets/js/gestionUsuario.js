// Módulo principal de la aplicación
        const UserManager = (() => {
            // Datos de usuarios
            let users = [];
            let editingUserId = null;
            let userToDelete = null;
            
            // Referencias a elementos DOM
            const DOM = {
                userForm: document.getElementById('user-form'),
                nameInput: document.getElementById('name'),
                emailInput: document.getElementById('email'),
                roleSelect: document.getElementById('role'),
                userIdInput: document.getElementById('user-id'),
                submitBtn: document.getElementById('submit-btn'),
                cancelEditBtn: document.getElementById('cancel-edit'),
                searchInput: document.getElementById('search-input'),
                userTableBody: document.getElementById('user-table-body'),
                emptyState: document.getElementById('empty-state'),
                formAlert: document.getElementById('form-alert'),
                totalUsers: document.getElementById('total-users'),
                adminUsers: document.getElementById('admin-users'),
                clientUsers: document.getElementById('client-users'),
                inactiveUsers: document.getElementById('inactive-users'),
                confirmDeleteBtn: document.getElementById('confirm-delete')
            };
            
            // Inicializar la aplicación
            const init = () => {
                renderUserList(users);
                updateStats();
                setupEventListeners();
            };
            
            // Configurar event listeners
            const setupEventListeners = () => {
                DOM.userForm.addEventListener('submit', handleFormSubmit);
                DOM.cancelEditBtn.addEventListener('click', cancelEdit);
                DOM.searchInput.addEventListener('input', handleSearch);
                DOM.confirmDeleteBtn.addEventListener('click', deleteUser);
            };
            
            // Renderizar lista de usuarios
            const renderUserList = (userList = users) => {
                DOM.userTableBody.innerHTML = '';
                
                if (userList.length === 0) {
                    DOM.emptyState.style.display = 'block';
                    return;
                }
                
                DOM.emptyState.style.display = 'none';
                
                userList.forEach(user => {
                    const tr = document.createElement('tr');
                    const initials = user.name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
                    const statusClass = user.status === 'inactive' ? 'text-muted' : '';
                    
                    tr.innerHTML = `
                        <td>
                            <div class="user-info ${statusClass}">
                                <div class="user-avatar">${initials}</div>
                                <div>${user.name}</div>
                            </div>
                        </td>
                        <td class="${statusClass}">${user.email}</td>
                        <td>
                            <span class="role-badge ${user.role === 'admin' ? 'badge-admin' : 'badge-user'}">
                                ${user.role === 'admin' ? 'Administrador' : 'Cliente'}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn btn-warning btn-sm edit-user-btn" data-id="${user.id}">
                                    <i class="fas fa-edit"></i> <span>Editar</span>
                                </button>
                                <button class="btn btn-danger btn-sm delete-user-btn" data-id="${user.id}">
                                    <i class="fas fa-trash"></i> <span>Eliminar</span>
                                </button>
                            </div>
                        </td>
                    `;
                    
                    DOM.userTableBody.appendChild(tr);
                });
                
                // Agregar eventos a los botones dinámicos
                addDynamicEventListeners();
            };
            
            // Agregar eventos a elementos dinámicos
            const addDynamicEventListeners = () => {
                document.querySelectorAll('.edit-user-btn').forEach(btn => {
                    btn.addEventListener('click', () => editUser(btn.dataset.id));
                });
                
                document.querySelectorAll('.delete-user-btn').forEach(btn => {
                    btn.addEventListener('click', () => confirmDelete(btn.dataset.id));
                });
            };
            
            // Manejar búsqueda
            const handleSearch = () => {
                const searchTerm = DOM.searchInput.value.toLowerCase();
                
                if (!searchTerm) {
                    renderUserList(users);
                    return;
                }
                
                const filteredUsers = users.filter(user => 
                    user.name.toLowerCase().includes(searchTerm) || 
                    user.email.toLowerCase().includes(searchTerm)
                );
                
                renderUserList(filteredUsers);
            };
            
            // Actualizar estadísticas
            const updateStats = () => {
                DOM.totalUsers.textContent = users.length;
                DOM.adminUsers.textContent = users.filter(u => u.role === 'admin').length;
                DOM.clientUsers.textContent = users.filter(u => u.role === 'user').length;
                DOM.inactiveUsers.textContent = users.filter(u => u.status === 'inactive').length;
            };
            
            // Manejar envío del formulario
            const handleFormSubmit = e => {
                e.preventDefault();
                
                if (!validateForm()) return;
                
                const userData = {
                    id: editingUserId || Date.now().toString(),
                    name: DOM.nameInput.value.trim(),
                    email: DOM.emailInput.value.trim(),
                    role: DOM.roleSelect.value,
                    status: "active",
                    date: new Date().toISOString()
                };
                
                if (editingUserId) {
                    updateUser(userData);
                } else {
                    createUser(userData);
                }
                
                resetForm();
            };
            
            // Validar formulario
            const validateForm = () => {
                DOM.formAlert.innerHTML = '';
                let isValid = true;
                
                if (!DOM.nameInput.value.trim()) {
                    showAlert('Por favor ingresa un nombre', 'danger');
                    isValid = false;
                }
                
                if (!DOM.emailInput.value.trim()) {
                    showAlert('Por favor ingresa un correo electrónico', 'danger');
                    isValid = false;
                } else {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(DOM.emailInput.value)) {
                        showAlert('Por favor ingresa un correo electrónico válido', 'danger');
                        isValid = false;
                    }
                }
                
                return isValid;
            };
            
            // Crear un nuevo usuario
            const createUser = user => {
                users.push(user);
                renderUserList(users);
                updateStats();
                showAlert('Usuario creado exitosamente!', 'success');
                scrollToTable();
            };
            
            // Actualizar usuario existente
            const updateUser = updatedUser => {
                users = users.map(user => user.id === updatedUser.id ? updatedUser : user);
                renderUserList(users);
                updateStats();
                showAlert('Usuario actualizado exitosamente!', 'success');
                cancelEdit();
            };
            
            // Editar usuario
            const editUser = userId => {
                const user = users.find(u => u.id === userId);
                
                if (user) {
                    DOM.userIdInput.value = user.id;
                    DOM.nameInput.value = user.name;
                    DOM.emailInput.value = user.email;
                    DOM.roleSelect.value = user.role;
                    
                    document.getElementById('form-title').textContent = 'Editar Usuario';
                    DOM.submitBtn.innerHTML = '<i class="fas fa-save me-2"></i> Guardar Cambios';
                    DOM.cancelEditBtn.style.display = 'block';
                    editingUserId = user.id;
                    
                    scrollToForm();
                }
            };
            
            // Cancelar edición
            const cancelEdit = () => {
                resetForm();
                document.getElementById('form-title').textContent = 'Agregar Nuevo Usuario';
                DOM.submitBtn.innerHTML = '<i class="fas fa-plus me-2"></i> Agregar Usuario';
                DOM.cancelEditBtn.style.display = 'none';
                editingUserId = null;
            };
            
            // Resetear formulario
            const resetForm = () => {
                DOM.userForm.reset();
                DOM.userIdInput.value = '';
                DOM.formAlert.innerHTML = '';
            };
            
            // Confirmar eliminación
            const confirmDelete = userId => {
                userToDelete = userId;
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                deleteModal.show();
            };
            
            // Eliminar usuario
            const deleteUser = () => {
                users = users.filter(user => user.id !== userToDelete);
                renderUserList(users);
                updateStats();
                showAlert('Usuario eliminado exitosamente!', 'success');
                
                bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
                userToDelete = null;
            };
            
            // Mostrar alerta
            const showAlert = (message, type) => {
                DOM.formAlert.innerHTML = `
                    <div class="alert alert-${type} alert-dismissible fade show">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                
                setTimeout(() => {
                    const alert = DOM.formAlert.querySelector('.alert');
                    if (alert) {
                        alert.classList.remove('show');
                        setTimeout(() => DOM.formAlert.innerHTML = '', 150);
                    }
                }, 3000);
            };
            
            // Scroll a la tabla
            const scrollToTable = () => {
                setTimeout(() => {
                    document.querySelector('.table-container').scrollIntoView({
                        behavior: 'smooth'
                    });
                }, 300);
            };
            
            // Scroll al formulario
            const scrollToForm = () => {
                document.querySelector('.card-effect.p-4').scrollIntoView({
                    behavior: 'smooth'
                });
            };
            
            // API pública
            return {
                init
            };
        })();
        
        // Iniciar la aplicación cuando el DOM esté cargado
        document.addEventListener('DOMContentLoaded', () => {
            UserManager.init();
        });