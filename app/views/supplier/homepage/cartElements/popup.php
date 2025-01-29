<!-- popup.php -->
<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/popup.css">

<div class="popup-overlay">
    <div class="popup-content">
        <div class="popup-message"><?php echo $data['message']; ?></div>
        <button class="popup-button" onclick="window.location.href = '<?php echo $data['redirectUrl'] = URLROOT . '/StorePageController/index'; ?>';">OK</button>
    </div>
</div>

<script>
    // Show the popup
    document.querySelector('.popup-overlay').classList.add('show-popup');
</script>
