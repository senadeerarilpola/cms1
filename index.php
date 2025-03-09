<?php
require_once 'db_connect.php';

// Initialize variables
$page = isset($_GET['page']) ? $_GET['page'] : 'list';
$alert = '';

// Check for success/error messages
if (isset($_GET['success'])) {
    $message = '';
    switch ($_GET['success']) {
        case 'added':
            $message = 'Customer added successfully.';
            break;
        case 'updated':
            $message = 'Customer updated successfully.';
            break;
        case 'deleted':
            $message = 'Customer deleted successfully.';
            break;
    }
    $alert = '<div class="alert alert-success">' . $message . '</div>';
} elseif (isset($_GET['error'])) {
    $alert = '<div class="alert alert-danger">An error occurred: ' . $_GET['error'] . '</div>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supiri Customer Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
        body {
            padding-top: 20px;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 1200px;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Supiri Customer Management</h2>
            </div>
            <div class="card-body">
                <?php echo $alert; ?>
                
                <div class="page-header">
                    <h3><?php echo ucfirst($page); ?> Customers</h3>
                    <?php if ($page == 'list'): ?>
                        <a href="?page=add" class="btn btn-success"><i class="bi bi-plus-circle"></i> Add New Customer</a>
                    <?php else: ?>
                        <a href="index.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back to List</a>
                    <?php endif; ?>
                </div>
                
                <?php
                // Include the appropriate page
                switch ($page) {
                    case 'add':
                        include 'add_customer.php';
                        break;
                    case 'edit':
                        include 'edit_customer.php';
                        break;
                    case 'view':
                        include 'view_customer.php';
                        break;
                    default:
                        include 'list_customers.php';
                }
                ?>
            </div>
        </div>
        <footer class="text-center mt-4 text-muted">
            <p>&copy; <?php echo date('Y'); ?> Supiri Customer Management System</p>
        </footer>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.display = 'none';
            });
        }, 5000);
    </script>
</body>
</html>
