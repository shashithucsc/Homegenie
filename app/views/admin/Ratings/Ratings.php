<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Ratings</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/supplierRatings.css">
    
</head>
<body>
<?php require APPROOT . '/views/admin/sidebar.php'; ?>
    <div class="supplier-ratings-container">
        <h1>Supplier Ratings</h1>
        <div class="supplier-review">
            <span class="supplier-reviewer">Bavindu Shamen</span>
            <div class="supplier-stars">⭐⭐⭐⭐</div>
            <p class="supplier-review-text">Supplier has been consistent and reliable in delivering high-quality products. His communication is excellent, and I look forward to working with him again.</p>
            <a href="#" class="supplier-read-more">Read more</a>
        </div>
        <div class="supplier-review">
            <span class="supplier-reviewer">Senuja Udugampola</span>
            <div class="supplier-stars">⭐⭐</div>
            <p class="supplier-review-text">Unfortunately, the service from Senuja did not meet expectations. There were delays, and the product quality was below par.</p>
            <a href="#" class="supplier-read-more">Read more</a>
        </div>
        <div class="supplier-review">
            <span class="supplier-reviewer">Lalitra Indupa</span>
            <div class="supplier-stars">⭐⭐⭐⭐⭐</div>
            <p class="supplier-review-text">Absolutely outstanding! Supplier is a top-notch supplier with excellent quality products and impeccable service. Highly recommended!</p>
            <a href="#" class="supplier-read-more">Read more</a>
        </div>
        <div class="supplier-review">
            <span class="supplier-reviewer">Shashith Rashmika</span>
            <div class="supplier-stars">⭐⭐⭐⭐⭐</div>
            <p class="supplier-review-text">Supplier has exceeded all expectations with his exceptional service and premium quality products. A pleasure to work with!</p>
            <a href="#" class="supplier-read-more">Read more</a>
        </div>
    </div>
</body>
</html>
