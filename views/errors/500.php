<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error del Servidor - ID Industrial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            color: white;
        }
        .error-card {
            background: rgba(255, 255, 255, 0.95);
            color: #333;
            border-radius: 20px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        .error-icon {
            font-size: 8rem;
            color: #dc3545;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="error-card">
                    <i class="fas fa-exclamation-triangle error-icon"></i>
                    <h1 class="display-4 fw-bold mb-3">500</h1>
                    <h3 class="mb-3">Error del Servidor</h3>
                    <p class="text-muted mb-4">
                        Ha ocurrido un error interno en el servidor. Nuestro equipo técnico 
                        ha sido notificado y está trabajando para solucionarlo.
                    </p>
                    <?php if (isset($message) && !empty($message)): ?>
                        <div class="alert alert-danger text-start">
                            <strong>Detalles técnicos:</strong><br>
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="<?php echo BASE_URL ?? '/'; ?>" class="btn btn-primary btn-lg me-md-2">
                            <i class="fas fa-home me-2"></i>
                            Ir al Inicio
                        </a>
                        <button onclick="history.back()" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>
                            Volver Atrás
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>