#!/bin/bash

# Test script for ID Industrial System
echo "=== Testing ID Industrial System ==="
echo

# Test 1: Check PHP syntax
echo "1. Testing PHP syntax..."
php -l index.php && echo "✓ Main index.php syntax OK"
php -l public/index.php && echo "✓ Public index.php syntax OK"
php -l public/login.php && echo "✓ Login.php syntax OK"
php -l public/dashboard.php && echo "✓ Dashboard.php syntax OK"

# Test 2: Check required files exist
echo
echo "2. Checking required files..."
files=(
    "config/config.php"
    "config/database.php"
    "classes/Database.php"
    "models/Usuario.php"
    "models/Solicitud.php"
    "controllers/AuthController.php"
    "controllers/SolicitudController.php"
    "controllers/DashboardController.php"
    "views/auth/login.php"
    "views/solicitud/form.php"
    "views/dashboard/index.php"
    "database/schema.sql"
    "public/index.php"
    "public/login.php"
    "public/dashboard.php"
    "public/logout.php"
    "public/api_ingresos.php"
)

for file in "${files[@]}"; do
    if [ -f "$file" ]; then
        echo "✓ $file exists"
    else
        echo "✗ $file missing"
    fi
done

# Test 3: Check directory structure
echo
echo "3. Checking directory structure..."
dirs=("config" "classes" "models" "controllers" "views" "public" "database" "assets" "uploads")

for dir in "${dirs[@]}"; do
    if [ -d "$dir" ]; then
        echo "✓ $dir/ directory exists"
    else
        echo "✗ $dir/ directory missing"
    fi
done

# Test 4: Database connection test (if possible)
echo
echo "4. Testing database configuration..."
if [ -f "test_connection.php" ]; then
    echo "Database test available at test_connection.php"
    echo "Note: Database connection will fail without proper MySQL setup"
else
    echo "✗ test_connection.php not found"
fi

echo
echo "=== Test completed ==="
echo "Note: For full testing, set up MySQL database with schema.sql"