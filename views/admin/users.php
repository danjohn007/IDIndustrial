<?php 
$title = 'Gestión de Usuarios - Panel Administrativo';
$page_title = 'Gestión de Usuarios';
ob_start(); 
?>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-users me-2"></i>
                    Lista de Usuarios (<?php echo count($users); ?>)
                </h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fas fa-plus me-1"></i>
                    Nuevo Usuario
                </button>
            </div>
            <div class="card-body">
                <?php if (!empty($users)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre Completo</th>
                                    <th>Usuario</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Fecha de Registro</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?php echo $user['id']; ?></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($user['full_name']); ?></strong>
                                        </td>
                                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                                        <td>
                                            <a href="mailto:<?php echo htmlspecialchars($user['email']); ?>">
                                                <?php echo htmlspecialchars($user['email']); ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php
                                            $role_classes = [
                                                'admin' => 'danger',
                                                'operator' => 'info'
                                            ];
                                            $role_texts = [
                                                'admin' => 'Administrador',
                                                'operator' => 'Operador'
                                            ];
                                            $class = $role_classes[$user['role']] ?? 'secondary';
                                            $text = $role_texts[$user['role']] ?? ucfirst($user['role']);
                                            ?>
                                            <span class="badge bg-<?php echo $class; ?>"><?php echo $text; ?></span>
                                        </td>
                                        <td><?php echo Helper::formatDate($user['created_at'], 'd/m/Y'); ?></td>
                                        <td>
                                            <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#editUserModal"
                                                            data-id="<?php echo $user['id']; ?>"
                                                            data-full-name="<?php echo htmlspecialchars($user['full_name']); ?>"
                                                            data-username="<?php echo htmlspecialchars($user['username']); ?>"
                                                            data-email="<?php echo htmlspecialchars($user['email']); ?>"
                                                            data-role="<?php echo $user['role']; ?>"
                                                            title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                                            onclick="confirmDelete(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['full_name']); ?>')"
                                                            title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            <?php else: ?>
                                                <span class="badge bg-warning">Usuario Actual</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No hay usuarios registrados</h5>
                        <p class="text-muted">Agregue usuarios para gestionar el sistema</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?php echo BASE_URL; ?>admin/create-user">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="add_full_name" class="form-label">Nombre Completo *</label>
                        <input type="text" class="form-control" id="add_full_name" name="full_name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="add_username" class="form-label">Usuario *</label>
                        <input type="text" class="form-control" id="add_username" name="username" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="add_email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="add_email" name="email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="add_password" class="form-label">Contraseña *</label>
                        <input type="password" class="form-control" id="add_password" name="password" required>
                        <div class="form-text">Mínimo 6 caracteres</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="add_role" class="form-label">Rol *</label>
                        <select class="form-select" id="add_role" name="role" required>
                            <option value="operator">Operador</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Crear Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?php echo BASE_URL; ?>admin/update-user">
                <div class="modal-body">
                    <input type="hidden" id="edit_user_id" name="id">
                    
                    <div class="mb-3">
                        <label for="edit_full_name" class="form-label">Nombre Completo *</label>
                        <input type="text" class="form-control" id="edit_full_name" name="full_name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_username" class="form-label">Usuario *</label>
                        <input type="text" class="form-control" id="edit_username" name="username" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_password" class="form-label">Nueva Contraseña</label>
                        <input type="password" class="form-control" id="edit_password" name="password">
                        <div class="form-text">Dejar en blanco para mantener la contraseña actual</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_role" class="form-label">Rol *</label>
                        <select class="form-select" id="edit_role" name="role" required>
                            <option value="operator">Operador</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Manejo del modal de edición
document.addEventListener('DOMContentLoaded', function() {
    const editUserModal = document.getElementById('editUserModal');
    if (editUserModal) {
        editUserModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            
            document.getElementById('edit_user_id').value = button.getAttribute('data-id');
            document.getElementById('edit_full_name').value = button.getAttribute('data-full-name');
            document.getElementById('edit_username').value = button.getAttribute('data-username');
            document.getElementById('edit_email').value = button.getAttribute('data-email');
            document.getElementById('edit_role').value = button.getAttribute('data-role');
            document.getElementById('edit_password').value = '';
        });
    }
});

// Confirmación de eliminación
function confirmDelete(userId, userName) {
    if (confirm(`¿Está seguro de que desea eliminar al usuario "${userName}"? Esta acción no se puede deshacer.`)) {
        // Crear formulario dinámico para eliminar
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?php echo BASE_URL; ?>admin/delete-user';
        
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'id';
        input.value = userId;
        
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>