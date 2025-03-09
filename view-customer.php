<?php
// Get customer ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$id) {
    header("Location: index.php?error=Invalid customer ID");
    exit;
}

// Fetch customer data
$stmt = $conn->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: index.php?error=Customer not found");
    exit;
}

$customer = $result->fetch_assoc();
$stmt->close();
?>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h4>Customer Information</h4>
                <table class="table">
                    <tr>
                        <th width="30%">ID:</th>
                        <td><?php echo $customer['id']; ?></td>
                    </tr>
                    <tr>
                        <th>Name:</th>
                        <td><?php echo htmlspecialchars($customer['first_name']); ?></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td><?php echo htmlspecialchars($customer['email']); ?></td>
                    </tr>
                    <tr>
                        <th>Phone:</th>
                        <td><?php echo $customer['phone'] ? htmlspecialchars($customer['phone']) : 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td><?php echo nl2br(htmlspecialchars($customer['Address'])); ?></td>
                    </tr>
                    <tr>
                        <th>Created:</th>
                        <td><?php echo date('F d, Y H:i:s', strtotime($customer['created_at'])); ?></td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="mt-4">
            <a href="?page=edit&id=<?php echo $customer['id']; ?>" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit Customer
            </a>
            <a href="delete_customer.php?id=<?php echo $customer['id']; ?>" class="btn btn-danger ms-2" 
               onclick="return confirm('Are you sure you want to delete this customer?');">
                <i class="bi bi-trash"></i> Delete Customer
            </a>
        </div>
    </div>
</div>
