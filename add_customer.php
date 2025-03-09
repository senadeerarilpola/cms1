<?php
// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $first_name = trim($_POST['first_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']) ?: null;
    $address = trim($_POST['address']);
    
    // Basic validation
    $errors = [];
    
    if (empty($first_name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($address)) {
        $errors[] = "Address is required";
    }
    
    // If no errors, insert customer
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO customers (first_name, email, phone, Address) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $first_name, $email, $phone, $address);
        
        if ($stmt->execute()) {
            // Redirect to customer list with success message
            header("Location: index.php?success=added");
            exit;
        } else {
            $errors[] = "Database error: " . $conn->error;
        }
        
        $stmt->close();
    }
}
?>

<div class="card">
    <div class="card-body">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <strong>Error!</strong>
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form method="post" action="">
            <div class="mb-3">
                <label for="first_name" class="form-label">Name *</label>
                <input type="text" class="form-control" id="first_name" name="first_name" required 
                       value="<?php echo isset($first_name) ? htmlspecialchars($first_name) : ''; ?>">
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email *</label>
                <input type="email" class="form-control" id="email" name="email" required
                       value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
            </div>
            
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="tel" class="form-control" id="phone" name="phone"
                       value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>">
                <div class="form-text">Optional</div>
            </div>
            
            <div class="mb-3">
                <label for="address" class="form-label">Address *</label>
                <textarea class="form-control" id="address" name="address" rows="3" required><?php echo isset($address) ? htmlspecialchars($address) : ''; ?></textarea>
            </div>
            
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Add Customer</button>
            </div>
        </form>
    </div>
</div>
