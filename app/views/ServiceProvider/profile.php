<?php
require_once APPROOT . '/views/ServiceProvider/navbar_svp.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Service Provider</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --background: #f9fafb;
            --card-background: #ffffff;
            --text: #111827;
            --text-secondary: #6b7280;
            --border: #e5e7eb;
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-hover: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background);
            color: var(--text);
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Profile Header */
        .profile-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .profile-header h1 {
            color: var(--primary);
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .profile-header p {
            color: var(--text-secondary);
            font-size: 1.1rem;
        }

        /* Profile Sections */
        .profile-sections {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
        }

        /* Profile Card */
        .profile-card {
            background: var(--card-background);
            border-radius: 12px;
            box-shadow: var(--shadow);
            padding: 30px;
            text-align: center;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin: 0 auto 20px;
            overflow: hidden;
            border: 4px solid var(--primary);
        }

        .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .rating {
            color: #ffc107;
            font-size: 1.2rem;
            margin: 15px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .rating i {
            margin: 0 2px;
        }

        .rating .rating-number {
            color: var(--text);
            font-size: 1rem;
            margin-left: 8px;
            font-weight: 500;
        }

        .rating .fa-star,
        .rating .fa-star-half-alt {
            color: #ffc107;
        }

        .rating .far.fa-star {
            color: #e4e5e9;
        }

        /* Details Card */
        .details-card {
            background: var(--card-background);
            border-radius: 12px;
            box-shadow: var(--shadow);
            padding: 30px;
        }

        .section-title {
            color: var(--primary);
            font-size: 1.5rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--border);
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .detail-item {
            margin-bottom: 15px;
        }

        .detail-label {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .detail-value {
            font-weight: 500;
            font-size: 1.1rem;
        }

        /* ID Verification Section */
        .id-verification {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid var(--border);
        }

        .id-images {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        .id-image {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .id-image img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        /* Work Photos Section */
        .work-photos {
            margin-top: 30px;
        }

        .photos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .photo-item {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease;
        }

        .photo-item:hover {
            transform: translateY(-5px);
        }

        .photo-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        /* Edit Button */
        .edit-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--primary);
            color: var(--card-background);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: var(--shadow-hover);
            transition: all 0.3s ease;
        }

        .edit-button:hover {
            background: var(--primary-hover);
            transform: scale(1.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .profile-sections {
                grid-template-columns: 1fr;
            }

            .details-grid {
                grid-template-columns: 1fr;
            }

            .id-images {
                grid-template-columns: 1fr;
            }
        }

        /* Add these styles to your existing CSS */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .edit-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .edit-btn:hover {
            background: var(--primary-hover);
        }

        .edit-mode {
            display: block !important;
        }

        .view-mode {
            display: block;
        }

        .edit-mode + .view-mode {
            display: none;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .save-btn, .cancel-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .save-btn {
            background: var(--primary);
            color: white;
        }

        .cancel-btn {
            background: var(--text-secondary);
            color: white;
        }

        .photo-upload {
            margin-bottom: 20px;
            padding: 20px;
            border: 2px dashed var(--border);
            border-radius: 8px;
            text-align: center;
        }

        .upload-btn {
            margin-top: 10px;
            background: var(--primary);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .delete-photo {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 0, 0, 0.8);
            color: white;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .photo-item:hover .delete-photo {
            opacity: 1;
        }

        .quotation-stats {
            margin-top: 20px;
            padding: 15px;
            border-top: 1px solid var(--border);
            background-color: rgba(37, 99, 235, 0.1); /* Semi-transparent dark blue */
            border-radius: 8px;
            margin: 20px 15px;
        }

        .stats-title {
            text-align: center;
            color: var(--primary);
            font-size: 1.1rem;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .stats-container {
            display: flex;
            justify-content: space-around;
        }

        .stat-item {
            text-align: center;
            display: flex;
            flex-direction: column;
            gap: 5px;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 6px;
            min-width: 80px;
        }

        .stat-number {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary);
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        /* Job Status Statistics */
        .job-stats {
            margin-top: 20px;
            padding: 15px;
            border-top: 1px solid var(--border);
            background-color: rgba(37, 99, 235, 0.1); /* Semi-transparent dark blue */
            border-radius: 8px;
            margin: 20px 15px;
        }

        .job-stats .stats-title {
            text-align: center;
            color: var(--primary);
            font-size: 1.1rem;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .job-stats .stats-container {
            display: flex;
            justify-content: space-around;
        }

        .job-stats .stat-item {
            text-align: center;
            display: flex;
            flex-direction: column;
            gap: 5px;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 6px;
            min-width: 80px;
        }

        .job-stats .stat-number {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary);
        }

        .job-stats .stat-label {
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        /* Professional Information Highlight */
        .details-grid .detail-item {
            background-color: rgba(37, 99, 235, 0.1);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .details-grid .detail-label {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 8px;
        }

        .details-grid .detail-value {
            color: var(--text);
            font-weight: 500;
        }

        .details-grid input,
        .details-grid select,
        .details-grid textarea {
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(37, 99, 235, 0.2);
            border-radius: 6px;
            padding: 8px 12px;
            width: 100%;
            color: var(--text);
        }

        .details-grid input:focus,
        .details-grid select:focus,
        .details-grid textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
        }

        /* Remove the specific hourly rate styles since they're now part of the general styles */
        .hourly-rate-value,
        .hourly-rate-input {
            background-color: transparent;
            padding: 0;
            border-radius: 0;
            font-weight: inherit;
            color: inherit;
        }

        .hourly-rate-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="profile-header">
            <h1>Service Provider Profile</h1>
            <p>Manage your professional information and settings</p>
        </div>

        <div class="profile-sections">
            <!-- Profile Card -->
            <div class="profile-card">
                <div class="profile-image">
                    <img src="<?php echo URLROOT . '/public/img/SVPpic/' . $data['user']->profile_image; ?>" alt="Profile Image">
                </div>
                <div class="rating">
                    <?php
                    $rating = $data['average_rating'];
                    $full_stars = floor($rating);
                    $half_star = $rating - $full_stars >= 0.5;
                    $empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);
                    
                    // Display full stars
                    for ($i = 0; $i < $full_stars; $i++) {
                        echo '<i class="fas fa-star"></i>';
                    }
                    
                    // Display half star if needed
                    if ($half_star) {
                        echo '<i class="fas fa-star-half-alt"></i>';
                    }
                    
                    // Display empty stars
                    for ($i = 0; $i < $empty_stars; $i++) {
                        echo '<i class="far fa-star"></i>';
                    }
                    
                    // Display rating number
                    echo '<span class="rating-number">' . number_format($rating, 1) . '</span>';
                    ?>
                </div>
                <h2><?php echo htmlspecialchars($data['user']->first_name . ' ' . $data['user']->last_name); ?></h2>
                <p class="text-secondary"><?php echo htmlspecialchars($data['provider']->expertise); ?></p>
                
                <!-- Quotation Statistics -->
                <div class="quotation-stats">
                    <h3 class="stats-title">Quotation Summary</h3>
                    <div class="stats-container">
                        <div class="stat-item">
                            <span class="stat-number"><?php echo $data['quotation_stats']->approved_count; ?></span>
                            <span class="stat-label">Approved</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number"><?php echo $data['quotation_stats']->pending_count; ?></span>
                            <span class="stat-label">Pending</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number"><?php echo $data['quotation_stats']->rejected_count; ?></span>
                            <span class="stat-label">Rejected</span>
                        </div>
                    </div>
                </div>

                <!-- Job Status Statistics -->
                <div class="job-stats">
                    <h3 class="stats-title">Job Summary</h3>
                    <div class="stats-container">
                        <div class="stat-item">
                            <span class="stat-number"><?php echo $data['job_stats']->completed_jobs; ?></span>
                            <span class="stat-label">Completed</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number"><?php echo $data['job_stats']->pending_jobs; ?></span>
                            <span class="stat-label">In Progress</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details Card -->
            <div class="details-card">
                <h3 class="section-title">Personal Information</h3>
                <div class="details-grid">
                    <div class="detail-item">
                        <div class="detail-label">Full Name</div>
                        <div class="detail-value"><?php echo htmlspecialchars($data['user']->first_name . ' ' . $data['user']->last_name); ?></div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Email</div>
                        <div class="detail-value"><?php echo htmlspecialchars($data['user']->email); ?></div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Contact Number</div>
                        <div class="detail-value"><?php echo htmlspecialchars($data['user']->contact_number); ?></div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Address</div>
                        <div class="detail-value"><?php 
                            echo htmlspecialchars(
                                $data['user']->street . ', ' . 
                                $data['user']->district . ', ' . 
                                $data['user']->province
                            ); 
                        ?></div>
                    </div>
                </div>

                <!-- Professional Information Section -->
                <div class="professional-info">
                    <div class="section-header">
                        <h3 class="section-title">Professional Information</h3>
                        <button class="edit-btn" onclick="toggleEditMode('professional')">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    </div>

                    <form id="professional-form" action="<?php echo URLROOT; ?>/ServiceProviderController/updateProfessionalInfo" method="POST" style="display: none;">
                        <div class="details-grid">
                            <div class="detail-item">
                                <div class="detail-label">Expertise</div>
                                <input type="text" name="expertise" value="<?php echo htmlspecialchars($data['provider']->expertise); ?>">
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Working Hours</div>
                                <input type="text" name="working_hours" value="<?php echo htmlspecialchars($data['provider']->working_hours); ?>">
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Hourly Rate</div>
                                <input type="number" name="hourly_rate" value="<?php echo htmlspecialchars($data['provider']->hourly_rate); ?>" min="0" step="0.01" class="hourly-rate-input">
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Service Areas</div>
                                <select name="service_areas[]" multiple>
                            <?php
                            $districts = [
                                        "Colombo", "Gampaha", "Kalutara", "Kandy", "Matale",
                                        "Nuwara Eliya", "Galle", "Matara", "Hambantota", "Jaffna",
                                        "Kilinochchi", "Mannar", "Vavuniya", "Mullaitivu", "Batticaloa",
                                        "Ampara", "Trincomalee", "Kurunegala", "Puttalam", "Anuradhapura",
                                        "Polonnaruwa", "Badulla", "Monaragala", "Ratnapura", "Kegalle"
                                    ];
                                    $selected_districts = explode(',', $data['provider']->service_areas);
                            foreach ($districts as $district) {
                                $selected = in_array(trim($district), $selected_districts) ? 'selected' : '';
                                echo "<option value=\"$district\" $selected>$district</option>";
                            }
                            ?>
                        </select>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Description</div>
                                <textarea name="description"><?php echo htmlspecialchars($data['provider']->description); ?></textarea>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="save-btn">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                            <button type="button" class="cancel-btn" onclick="toggleEditMode('professional')">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                        </div>
                    </form>

                    <div id="professional-view">
                        <div class="details-grid">
                            <div class="detail-item">
                                <div class="detail-label">Expertise</div>
                                <div class="detail-value"><?php echo htmlspecialchars($data['provider']->expertise); ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Working Hours</div>
                                <div class="detail-value"><?php echo htmlspecialchars($data['provider']->working_hours); ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Hourly Rate</div>
                                <div class="hourly-rate-value">$<?php echo number_format($data['provider']->hourly_rate, 2); ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Service Areas</div>
                                <div class="detail-value"><?php echo htmlspecialchars($data['provider']->service_areas); ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Description</div>
                                <div class="detail-value"><?php echo htmlspecialchars($data['provider']->description); ?></div>
                            </div>
                        </div>
                    </div>
                    </div>

                <!-- ID Verification Section -->
                <div class="id-verification">
                    <h3 class="section-title">ID Verification</h3>
                    <div class="id-images">
                        <div class="id-image">
                            <img src="<?php echo URLROOT . '/public/img/SVPpic/' . $data['provider']->id_front; ?>" alt="ID Front">
                            <p class="detail-label">Front</p>
                        </div>
                        <div class="id-image">
                            <img src="<?php echo URLROOT . '/public/img/SVPpic/' . $data['provider']->id_back; ?>" alt="ID Back">
                            <p class="detail-label">Back</p>
                        </div>
                    </div>
                    </div>

                <!-- Work Photos Section -->
                <div class="work-photos">
                    <div class="section-header">
                        <h3 class="section-title">Work Photos</h3>
                        <button class="edit-btn" onclick="toggleEditMode('photos')">
                            <i class="fas fa-edit"></i> Manage Photos
                        </button>
                    </div>

                    <form id="photos-form" action="<?php echo URLROOT; ?>/ServiceProviderController/updateWorkPhotos" method="POST" enctype="multipart/form-data" style="display: none;">
                        <div class="photo-upload">
                            <input type="file" name="work_photos[]" multiple accept="image/*">
                            <button type="submit" class="upload-btn">
                                <i class="fas fa-upload"></i> Upload New Photos
                            </button>
                </div>
            </form>

                    <div id="photos-view">
                        <div class="photos-grid">
                            <?php
                            if (!empty($data['provider']->work_photos)) {
                                $photos = explode(',', $data['provider']->work_photos);
                                foreach ($photos as $index => $photo) {
                                    if (!empty($photo)) {
                                        echo '<div class="photo-item">
                                                <img src="' . URLROOT . '/public/img/SVPpic/' . htmlspecialchars($photo) . '" alt="Work Photo">
                                                <button class="delete-photo" onclick="deletePhoto(' . $index . ')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                              </div>';
                                    }
                                }
                            } else {
                                echo '<p class="no-photos">No work photos uploaded yet.</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleEditMode(section) {
            const form = document.getElementById(section + '-form');
            const view = document.getElementById(section + '-view');
            const editBtn = form.previousElementSibling.querySelector('.edit-btn');

            if (form.style.display === 'none') {
                form.style.display = 'block';
                view.style.display = 'none';
                editBtn.innerHTML = '<i class="fas fa-times"></i> Cancel';
            } else {
                form.style.display = 'none';
                view.style.display = 'block';
                editBtn.innerHTML = '<i class="fas fa-edit"></i> Edit';
            }
        }

        function deletePhoto(photoIndex) {
            if (confirm('Are you sure you want to delete this photo?')) {
                fetch('<?php echo URLROOT; ?>/ServiceProviderController/deleteWorkPhoto', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'photo_index=' + photoIndex
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error deleting photo');
                    }
                });
            }
        }
</script>
</body>

</html>

<?php
require_once APPROOT . '/views/ServiceProvider/footer_svp.php';
?>