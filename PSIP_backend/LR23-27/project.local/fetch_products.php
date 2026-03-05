<?php
session_start();
require_once 'db.php';

$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$sort = $_GET['sort'] ?? 'name_asc';

$sql = "SELECT p.*, c.name as cat_name 
        FROM products p 
        LEFT JOIN id_product_type c ON p.id_product_type = c.id_product_type 
        WHERE 1=1";
$params = [];

if ($search) {
    $sql .= " AND p.name LIKE ?";
    $params[] = "%$search%";
}
if ($category) {
    $sql .= " AND p.id_product_type = ?";
    $params[] = $category;
}

switch ($sort) {
    case 'price_asc': $sql .= " ORDER BY p.price ASC"; break;
    case 'price_desc': $sql .= " ORDER BY p.price DESC"; break;
    default: $sql .= " ORDER BY p.name ASC"; break;
}

/** @var PDO $pdo */
$stmt = $pdo->prepare($sql);
$stmt->execute($params);


while ($row = $stmt->fetch()) {
    ?>
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px;">
            <div class="product-card-img-container" style="height: 200px; overflow: hidden;">
                <img src="img/products/<?php echo $row['img']; ?>"
                     style="width: 100%; height: 100%; object-fit: cover;" alt="product">
            </div>

            <div class="card-body p-3 d-flex flex-column">
                <h6 class="fw-bold product-card-title" style="height: 3em; overflow: hidden;">
                    <?php echo htmlspecialchars($row['name']); ?>
                </h6>

                <div class="mb-3">
                    <span class="fw-bold text-primary fs-5"><?php echo $row['price']; ?> BYN</span>
                </div>

                <div class="mt-auto">
                    <button onclick="addToCart(<?= $row['id_products'] ?>)" class="btn btn-primary">
                        В корзину
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>