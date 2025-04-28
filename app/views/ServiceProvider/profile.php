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
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/SVP/SVP_profile.css">
</head>

<body>
    <div class="container">

        <div class="profile-sections">
            <!-- Profile Card -->
            <div class="profile-card">
                <div class="profile-image">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($data['user']->profile_image); ?>" alt="Profile Image">
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
                                <input type="number" name="hourly_rate" value="<?php echo htmlspecialchars($data['provider']->hourly_rate); ?>" min="0" step="0.01">
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Service Areas</div>
                                <select name="service_areas[]" multiple>
                                    <?php
                                    $districts = [
                                        "Colombo",
                                        "Gampaha",
                                        "Kalutara",
                                        "Kandy",
                                        "Matale",
                                        "Nuwara Eliya",
                                        "Galle",
                                        "Matara",
                                        "Hambantota",
                                        "Jaffna",
                                        "Kilinochchi",
                                        "Mannar",
                                        "Vavuniya",
                                        "Mullaitivu",
                                        "Batticaloa",
                                        "Ampara",
                                        "Trincomalee",
                                        "Kurunegala",
                                        "Puttalam",
                                        "Anuradhapura",
                                        "Polonnaruwa",
                                        "Badulla",
                                        "Monaragala",
                                        "Ratnapura",
                                        "Kegalle"
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
                                <div class="detail-value">Rs. <?php echo number_format($data['provider']->hourly_rate, 2); ?></div>
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

        
    </script>
</body>

</html>

<?php
require_once APPROOT . '/views/ServiceProvider/footer_svp.php';
?>