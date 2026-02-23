<?php
// view_medicines.php
session_start();
if(!isset($_SESSION['user_id']) && isset($_COOKIE['user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['username'] = $_COOKIE['username'];
}

// Redirect to login if neither session nor cookie exists
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// DB Connection
$servername = "sql307.infinityfree.com"; 
$username   = "if0_39907338";       
$password   = "Sunil6646";          
$dbname     = "if0_39907338_student";  

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

// Handle Update Request (Edit Form Submission)
if(isset($_POST['update_medicine'])) {
    $id = intval($_POST['id']);
    $name = $_POST['medicine_name'];
    $batch = $_POST['batch_name'];
    $qty = intval($_POST['quantity']);
    $expiry = $_POST['expiry_date'];
    $supplier = $_POST['supplier'];

    $conn->query("UPDATE medicines SET medicine_name='$name', batch_name='$batch', quantity=$qty, expiry_date='$expiry', supplier='$supplier' WHERE id=$id");
    header("Location: view_medicines.php");
    exit();
}

// Handle Direct Delete Request (no confirmation)
if(isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $conn->query("DELETE FROM medicines WHERE id=$delete_id");
    exit();
}

// Fetch medicines from DB
$result = $conn->query("SELECT id, medicine_name, batch_name, quantity, expiry_date, supplier FROM medicines");
$medicines = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $medicines[] = $row;
    }
} else {
    // Sample medicines if DB is empty
    $medicines = [
        ["id"=>1,"medicine_name"=>"Paracetamol 500mg","batch_name"=>"BATCH001","quantity"=>100,"expiry_date"=>"2025-10-20","supplier"=>"Sun Pharma"],
        ["id"=>2,"medicine_name"=>"Amoxicillin 250mg","batch_name"=>"BATCH002","quantity"=>50,"expiry_date"=>"2025-11-05","supplier"=>"Cipla Ltd"],
        ["id"=>3,"medicine_name"=>"Ibuprofen 400mg","batch_name"=>"BATCH003","quantity"=>200,"expiry_date"=>"2026-03-10","supplier"=>"Dr. Reddy Labs"],
        ["id"=>4,"medicine_name"=>"Cough Syrup","batch_name"=>"BATCH004","quantity"=>75,"expiry_date"=>"2025-09-15","supplier"=>"Mankind Pharma"],
        ["id"=>5,"medicine_name"=>"Vitamin C Tablets","batch_name"=>"BATCH005","quantity"=>150,"expiry_date"=>"2026-01-05","supplier"=>"Zydus Healthcare"],
        ["id"=>6,"medicine_name"=>"Aspirin 100mg","batch_name"=>"BATCH006","quantity"=>80,"expiry_date"=>"2025-10-30","supplier"=>"Bayer"],
        ["id"=>7,"medicine_name"=>"Cetirizine 10mg","batch_name"=>"BATCH007","quantity"=>120,"expiry_date"=>"2025-12-15","supplier"=>"GlaxoSmithKline"],
        ["id"=>8,"medicine_name"=>"Metformin 500mg","batch_name"=>"BATCH008","quantity"=>90,"expiry_date"=>"2026-02-20","supplier"=>"Sun Pharma"],
        ["id"=>9,"medicine_name"=>"Omeprazole 20mg","batch_name"=>"BATCH009","quantity"=>60,"expiry_date"=>"2025-09-25","supplier"=>"Cipla Ltd"],
        ["id"=>10,"medicine_name"=>"Diclofenac 50mg","batch_name"=>"BATCH010","quantity"=>110,"expiry_date"=>"2025-11-20","supplier"=>"Dr. Reddy Labs"]
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>View Medicines</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
body { font-family: Arial, sans-serif; background:#f4f4f9; padding:20px; }
h2 { text-align:center; color:#2575fc; margin-bottom:20px; }
table { width:100%; border-collapse:collapse; background:#fff; box-shadow:0 4px 10px rgba(0,0,0,0.1); }
th, td { padding:12px; border:1px solid #ddd; text-align:center; }
th { background:#2575fc; color:white; }
tr:hover { background:#f1f1f1; }
tr.expired { background:#ffcccc; }
tr.near-expiry { background:#fff4cc; }
.action-btn { padding:5px 10px; margin:2px; border:none; border-radius:5px; cursor:pointer; text-decoration:none; color:white; display:inline-flex; align-items:center; gap:5px; }
.edit { background:#4caf50; }
.delete { background:#f44336; }
.edit:hover { background:#45a049; }
.delete:hover { background:#d32f2f; }
form.edit-form { display:none; margin-top:20px; background:#fff; padding:15px; border-radius:8px; box-shadow:0 4px 10px rgba(0,0,0,0.1); max-width:500px; margin-left:auto; margin-right:auto; }
form.edit-form input { width:100%; padding:8px; margin:8px 0; }
form.edit-form button { background:#2575fc; color:white; padding:10px 15px; border:none; border-radius:5px; cursor:pointer; }
form.edit-form button:hover { background:#6a11cb; }
.bottom-buttons { text-align:center; margin-top:25px; display:flex; justify-content:center; gap:15px; }
.bottom-buttons a { padding:10px 20px; background:#2575fc; color:white; border-radius:6px; text-decoration:none; }
.bottom-buttons a:hover { background:#6a11cb; }
.add-btn { background:#4caf50 !important; }
.add-btn:hover { background:#45a049 !important; }
</style>
<script>
function openEditForm(id, name, batch, qty, expiry, supplier) {
    document.getElementById('edit-form').style.display = 'block';
    document.getElementById('edit-id').value = id;
    document.getElementById('edit-name').value = name;
    document.getElementById('edit-batch').value = batch;
    document.getElementById('edit-qty').value = qty;
    document.getElementById('edit-expiry').value = expiry;
    document.getElementById('edit-supplier').value = supplier;
    window.scrollTo(0, document.body.scrollHeight);
}

// Direct delete without confirmation
function deleteMedicine(id, row) {
    $.ajax({
        url: 'view_medicines.php',
        type: 'GET',
        data: { delete_id: id },
        success: function() {
            $(row).closest('tr').remove();
        },
        error: function() {
            alert('Error deleting medicine.');
        }
    });
}
</script>
</head>
<body>

<h2>All Medicines</h2>

<table>
<tr>
  <th>ID</th>
  <th>Medicine Name</th>
  <th>Batch Name</th>
  <th>Quantity</th>
  <th>Expiry Date</th>
  <th>Supplier</th>
  <th>Actions</th>
  <th>Status</th>
</tr>

<?php
$today = new DateTime();
foreach ($medicines as $row):
    $expiry = new DateTime($row['expiry_date']);
    $diff = (int)$today->diff($expiry)->format("%r%a");
    $rowClass = '';
    $status = '';

    if ($expiry < $today) {
        $rowClass = 'expired';
        $status = 'Expired';
    } elseif ($diff <= 30) {
        $rowClass = 'near-expiry';
        $status = 'Near Expiry';
    } else {
        $status = 'Good';
    }
?>
<tr class="<?= $rowClass ?>">
  <td><?= htmlspecialchars($row['id']) ?></td>
  <td><?= htmlspecialchars($row['medicine_name']) ?></td>
  <td><?= htmlspecialchars($row['batch_name']) ?></td>
  <td><?= htmlspecialchars($row['quantity']) ?></td>
  <td><?= htmlspecialchars($row['expiry_date']) ?></td>
  <td><?= htmlspecialchars($row['supplier']) ?></td>
  <td>
    <button class="action-btn edit" onclick="openEditForm('<?= $row['id'] ?>','<?= $row['medicine_name'] ?>','<?= $row['batch_name'] ?>','<?= $row['quantity'] ?>','<?= $row['expiry_date'] ?>','<?= $row['supplier'] ?>')">
        <i class="fas fa-pen"></i> Edit
    </button>
    <button class="action-btn delete" onclick="deleteMedicine('<?= $row['id'] ?>', this)">
        <i class="fas fa-trash"></i> Delete
    </button>
  </td>
  <td><?= $status ?></td>
</tr>
<?php endforeach; ?>
</table>

<!-- ✅ Centered Buttons Below Table -->
<div class="bottom-buttons">
    <a href="add_medicine.php" class="add-btn"><i class="fas fa-plus"></i> Add Medicine</a>
    <a href="dashboard.php"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
</div>

<!-- Edit Form -->
<form method="post" class="edit-form" id="edit-form">
    <h3>Edit Medicine</h3>
    <input type="hidden" name="id" id="edit-id">
    <label>Medicine Name:</label>
    <input type="text" name="medicine_name" id="edit-name" required>
    <label>Batch Name:</label>
    <input type="text" name="batch_name" id="edit-batch" required>
    <label>Quantity:</label>
    <input type="number" name="quantity" id="edit-qty" required>
    <label>Expiry Date:</label>
    <input type="date" name="expiry_date" id="edit-expiry" required>
    <label>Supplier:</label>
    <input type="text" name="supplier" id="edit-supplier" required>
    <button type="submit" name="update_medicine">Update Medicine</button>
</form>

</body>
</html>
