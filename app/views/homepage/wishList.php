<?php ?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Items - HomeGenie Store</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/navbar.css">  
    
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/footer.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/wishList.css">
</head>
<?php require_once APPROOT . '/views/navbar/navbar.php'; ?>
<body>

    <div class="container2">
    \
        <div class = "header5">
       
            <h1>Saved Items</h1>
            <a href="<?php echo URLROOT; ?>/HomeController/index" class="back-button">Back to Home</a>
        
        <section class="saved-items">
        
                <?php if (isset($data['items']) && is_array($data['items'])): ?>
                    <?php foreach ($data['items'] as $item): ?>
                        <div class="item">
                            <?php
                            echo '<img src="data:image/jpeg;base64,' . base64_encode($item->image_path) . '" alt="' . htmlspecialchars($item->item_name) . '">';
                            echo '<h3>' . htmlspecialchars($item->item_name) . '</h3>';
                            echo 'Rs. ' . htmlspecialchars($item->selling_price) . '';
                            echo '<div class="button-container">';
    
    
                            echo '<button type="submit" class="add-button">Add</button>';
    
    
    
                            echo '<button type="submit" class="save-button">Save</button>';
    
    
                            echo '</div>';
    
    
                            ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No items available.</p>
                <?php endif; ?>
            </section>
    </div>
    
    <?php require_once APPROOT . '/views/footer.php'; ?>
</body>
</html>
