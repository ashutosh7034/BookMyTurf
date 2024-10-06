<?php
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT f.*, c.name as category FROM facility_list f INNER JOIN category_list c ON f.category_id = c.id WHERE f.id = '{$_GET['id']}'");
    $facility = $qry->fetch_assoc();
}
?>

<div class="card">
    <div class="card-header">
        <h3>Facility Details</h3>
    </div>
    <div class="card-body">
        <h5>Name: <?= $facility['name']; ?></h5>
        <p>Description: <?= $facility['description']; ?></p>
        <p>Price: <?= number_format($facility['price'], 2); ?></p>
        <p>Status: <?= $facility['status'] == 1 ? 'Active' : 'Inactive'; ?></p>
        <img src="<?= $facility['image_path']; ?>" alt="Facility Image" style="width: 100%; max-height: 300px;">
    </div>
</div>
