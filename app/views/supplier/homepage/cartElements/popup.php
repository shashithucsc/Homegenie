<!-- popup.php -->
<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/popup.css">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<div class="popup-overlay">
    <div class="popup-content">
        <i class='bx bx-check-circle' style='color:#4A90E2; font-size: 48px; margin-bottom: 15px;'></i>
        <div class="popup-message"><?php echo $data['message']; ?></div>
        <button class="popup-button" onclick="window.location.href = '<?php echo $data['redirectUrl']; ?>';">
            <i class='bx bx-check'></i> OK
        </button>
    </div>
</div>

<script>
    document.querySelector('.popup-overlay').classList.add('show-popup');
</script>
