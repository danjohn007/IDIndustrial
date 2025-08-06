<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo APP_NAME; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            width: 100%;
            max-width: 400px;
        }
        
        .login-header {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .login-header h1 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        .login-header p {
            opacity: 0.9;
            margin: 0;
            font-size: 0.95rem;
        }
        
        .login-body {
            padding: 2rem;
        }
        
        .form-floating {
            margin-bottom: 1rem;
        }
        
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        
        .btn-login {
            background: linear-gradient(135deg, #3498db, #2980b9);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .btn-login:hover {
            background: linear-gradient(135deg, #2980b9, #21618c);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(52, 152, 219, 0.3);
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            margin-bottom: 1rem;
        }
        
        .company-logo {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
        }
        
        .form-check-input:checked {
            background-color: #3498db;
            border-color: #3498db;
        }
        
        .text-muted {
            font-size: 0.875rem;
        }
        
        .login-footer {
            text-align: center;
            padding: 1rem 2rem 2rem;
            color: #6c757d;
            font-size: 0.875rem;
        }
        
        .input-group-text {
            background: transparent;
            border-radius: 10px 0 0 10px;
            border-color: #e9ecef;
        }
        
        @media (max-width: 576px) {
            .login-card {
                margin: 1rem;
                border-radius: 15px;
            }
            
            .login-header, .login-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="company-logo">
                    <i class="fas fa-industry"></i>
                </div>
                <h1>ID INDUSTRIAL</h1>
                <p>Sistema de Solicitud de Servicios</p>
            </div>
            
            <div class="login-body">
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="login.php">
                    <div class="form-floating">
                        <input type="email" class="form-control" id="email" name="email" 
                               placeholder="correo@ejemplo.com" required 
                               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                        <label for="email">
                            <i class="fas fa-envelope me-2"></i>Correo Electrónico
                        </label>
                    </div>
                    
                    <div class="form-floating">
                        <input type="password" class="form-control" id="password" name="password" 
                               placeholder="Contraseña" required>
                        <label for="password">
                            <i class="fas fa-lock me-2"></i>Contraseña
                        </label>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label text-muted" for="remember">
                            Recordar sesión
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                    </button>
                </form>
            </div>
            
            <div class="login-footer">
                <p class="mb-0">
                    <i class="fas fa-shield-alt me-1"></i>
                    Acceso seguro protegido
                </p>
                <small class="text-muted">
                    &copy; <?php echo date('Y'); ?> ID INDUSTRIAL. Todos los derechos reservados.
                </small>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Efectos visuales adicionales
        document.addEventListener('DOMContentLoaded', function() {
            // Animación de entrada
            const loginCard = document.querySelector('.login-card');
            loginCard.style.opacity = '0';
            loginCard.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                loginCard.style.transition = 'all 0.6s ease';
                loginCard.style.opacity = '1';
                loginCard.style.transform = 'translateY(0)';
            }, 100);
            
            // Focus automático en el primer campo vacío
            const emailField = document.getElementById('email');
            const passwordField = document.getElementById('password');
            
            if (!emailField.value) {
                emailField.focus();
            } else {
                passwordField.focus();
            }
            
            // Validación en tiempo real
            const form = document.querySelector('form');
            const submitBtn = document.querySelector('.btn-login');
            
            function validateForm() {
                const email = emailField.value.trim();
                const password = passwordField.value.trim();
                
                if (email && password && email.includes('@')) {
                    submitBtn.disabled = false;
                    submitBtn.style.opacity = '1';
                } else {
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.6';
                }
            }
            
            emailField.addEventListener('input', validateForm);
            passwordField.addEventListener('input', validateForm);
            
            // Validación inicial
            validateForm();
            
            // Efecto de loading al enviar
            form.addEventListener('submit', function() {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Iniciando...';
                submitBtn.disabled = true;
            });
        });
        
        // Credenciales de demostración (solo para desarrollo)
        <?php if (defined('APP_DEBUG') && APP_DEBUG): ?>
        console.log('Credenciales de demostración:');
        console.log('Admin: admin@idindustrial.com.mx / password');
        console.log('Técnico: juan.perez@idindustrial.com.mx / password');
        <?php endif; ?>
    </script>
</body>
</html>