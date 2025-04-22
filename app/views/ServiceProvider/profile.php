<?php
require_once APPROOT . '/views/ServiceProvider/navbar_svp.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Service Provider</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/SVP/SVP_Profile.css">
</head>

<body>
    <?php $row = isset($data['row']) ? $data['row'] : null; ?>

    <div class="container">
        <!-- Profile Header -->
        <div class="profile-header">
            <h1><?php echo htmlspecialchars($row->first_name . ' ' . $row->last_name); ?></h1>
        </div>

        <!-- Profile Info -->
      <!-- Profile Info -->
<div class="profile-info">
    <div class="profile-image">
        <img src="<?php echo URLROOT . '/public/img/SVPpic/default_user.png'; ?>" alt="Profile Image">
    </div>

    <div class="rating">
        <span class="star">★</span><span class="star">★</span><span class="star">★</span>
        <span class="star">★</span><span class="star">☆</span>
    </div>
  <h3 style="text-align: center; font-size: 30px; font-weight: bold; color:rgb(54, 82, 172); margin-bottom: 40px;">Profile Information</h3>

<form method="POST" action="<?php echo URLROOT; ?>/ServiceProviderController/updateProfileFields" id="profile-form" style="max-width: 1200px; margin: 0 auto; padding: 30px; border-radius: 12px; background-color: #f9f9f9; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">

    <!-- Row 1: 4 Fields -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px; margin-bottom: 30px;">
        <div style="display: flex; flex-direction: column; font-size: 18px; font-weight: 500;">
            <strong>Full Name:</strong>
            <span><?php echo htmlspecialchars($row->first_name . ' ' . $row->last_name); ?></span>
        </div>
        <div style="display: flex; flex-direction: column; font-size: 18px; font-weight: 500;">
            <strong>Email:</strong>
            <span><?php echo htmlspecialchars($row->email); ?></span>
        </div>
        <div style="display: flex; flex-direction: column; font-size: 18px; font-weight: 500;">
            <strong>Contact Number:</strong>
            <span><?php echo htmlspecialchars($row->contact_number); ?></span>
        </div>
        <div style="display: flex; flex-direction: column; font-size: 18px; font-weight: 500;">
            <strong>Address:</strong>
            <span><?php echo htmlspecialchars($row->address); ?></span>
        </div>
    </div>

    <!-- Row 2: 3 Editable Fields + Buttons -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px; align-items: end;">
        <!-- Expertise -->
        <div style="display: flex; flex-direction: column; font-size: 18px; font-weight: 500;">
            <strong>Expertise:</strong>
            <span class="display-value" id="expertise-text"><?php echo htmlspecialchars($row->expertise); ?></span>
            <input type="text" name="expertise" id="expertise-input" class="edit-field" value="<?php echo htmlspecialchars($row->expertise); ?>" style="display:none; padding: 8px; border: 1px solid #ccc; border-radius: 8px;">
        </div>

        <!-- Service Areas -->
        <div style="display: flex; flex-direction: column; font-size: 18px; font-weight: 500;">
            <strong>Service Areas:</strong>
            <span class="display-value" id="service_areas-text"><?php echo htmlspecialchars($row->service_areas); ?></span>
            <input type="text" name="service_areas" id="service_areas-input" class="edit-field" value="<?php echo htmlspecialchars($row->service_areas); ?>" style="display:none; padding: 8px; border: 1px solid #ccc; border-radius: 8px;">
        </div>

        <!-- Working Hours -->
        <div style="display: flex; flex-direction: column; font-size: 18px; font-weight: 500;">
            <strong>Working Hours:</strong>
            <span class="display-value" id="working_hours-text"><?php echo htmlspecialchars($row->working_hours); ?></span>
            <input type="text" name="working_hours" id="working_hours-input" class="edit-field" value="<?php echo htmlspecialchars($row->working_hours); ?>" style="display:none; padding: 8px; border: 1px solid #ccc; border-radius: 8px;">
        </div>

        <!-- Buttons -->
<div style="display: flex; justify-content: flex-end; align-items: flex-end; gap: 10px; margin-top: auto;">
    <button type="button" id="edit-btn" class="update-button" style="
        padding: 10px 20px;
        width: 100%; 
        background-color: #2563eb;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;">✎ &nbsp; Edit</button>

    <button type="submit" id="save-btn" class="update-button" style="
        display: none;
        padding: 10px 20px;
        background-color: #2196F3;
        color: white;
         width: 100%;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;">💾 Save</button>

    <button type="button" id="cancel-btn" class="cancel-button" style="
        display: none;
        padding: 10px 20px;
        background-color: #f44336;
        color: white;
         width: 100%;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;">❎ Cancel</button>
</div>

    </div>
</form>

<!-- Button Hover Effects -->
<style>
    .update-button:hover {
        background-color: #45a049;
    }
    .cancel-button:hover {
        background-color: #d32f2f;
    }
</style>

</div>


        <div class="work-photos">
            <h3>Working Photos</h3>
            <div class="image-row">
                <?php
                $photo_dir = dirname(dirname(dirname(__DIR__))) . '/public/img/SVPpic/';
                $photo_url = URLROOT . '/public/img/SVPpic/';
                $work_photos = glob($photo_dir . 'w*.*');

                foreach ($work_photos as $photo_path) {
                    $photo_name = basename($photo_path); // Extracts just the filename
                    echo '<div class="image-tile"><img src="' . $photo_url . htmlspecialchars($photo_name) . '" alt="Work Photo"></div>';
                }
                ?>
            </div>
        </div>

 
    </div>

    <script>
    const editBtn = document.getElementById("edit-btn");
    const saveBtn = document.getElementById("save-btn");
    const cancelBtn = document.getElementById("cancel-btn");

    const fields = ["expertise", "service_areas", "working_hours"];

    editBtn.addEventListener("click", () => {
        fields.forEach(field => {
            document.getElementById(`${field}-text`).style.display = "none";
            document.getElementById(`${field}-input`).style.display = "inline-block";
        });
        editBtn.style.display = "none";
        saveBtn.style.display = "inline-block";
        cancelBtn.style.display = "inline-block";
    });

    cancelBtn.addEventListener("click", () => {
        fields.forEach(field => {
            document.getElementById(`${field}-text`).style.display = "inline-block";
            document.getElementById(`${field}-input`).style.display = "none";
        });
        editBtn.style.display = "inline-block";
        saveBtn.style.display = "none";
        cancelBtn.style.display = "none";
    });
</script>

</body>

</html>

<?php
require_once APPROOT . '/views/ServiceProvider/footer_svp.php';
?>