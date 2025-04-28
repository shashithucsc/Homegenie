<?php
$user_name = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$profile_pic = isset($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : 'default.png';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$email = isset($_SESSION['email']) ? $_SESSION['email'] : null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - HomeGenie</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/navigationbar.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style-profile.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php require_once APPROOT . '/views/Customer/loggedNavBar.php'; ?>
    <?php $user = isset($data['user']) ? $data['user'] : null; ?>
    <section class="container">
        <div class="profile-header">
            <div class="profile-avatar">
                <?php if (!empty($data['customer']->profile_image)): ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($data['customer']->profile_image); ?>"
                        alt="Profile Picture">
                <?php else: ?>
                    <img src="<?php echo URLROOT; ?>/public/images/default-profile.png" alt="Default Profile Picture">
                <?php endif; ?>
            </div>
            <div class="profile-info">
                <h1><?php echo $data['customer']->first_name . ' ' . $data['customer']->last_name; ?></h1>
                <p><?php echo $data['customer']->email; ?></p>
                <button onclick="openEditProfileModal()" class="edit-profile-btn">
                    <i class='bx bx-edit-alt'></i> Edit Profile
                </button>
            </div>
        </div>

        <div class="profile-content">
            <section class="profile-section">
                <h2>Contact Information</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <i class='bx bx-phone'></i>
                        <div>
                            <label>Phone</label>
                            <!-- Directly access $data['customer'] -->
                            <p id="profilePhone">
                                <?php
                                if (!empty($data['customer']) && isset($data['customer']->contact_number)) {
                                    echo htmlspecialchars($data['customer']->contact_number);
                                } else {
                                    echo 'N/A';
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class='bx bx-map'></i>
                        <div>
                            <label>Address</label>
                            <!-- Directly access $data['customer'] -->
                            <p id="profileAddress">
                                <?php
                                echo htmlspecialchars($data['customer']->street . ', ' . $data['customer']->district . ', ' . $data['customer']->province);
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="profile-section">
                <h2>Ongoing Appointments</h2>
                <?php if (empty($data['p_appointments'])): ?>
                    <p>You don't have any appointments yet.</p>
                <?php else: ?>
                    <div class="info-grid">
                        <?php foreach ($data['p_appointments'] as $p_appointment): ?>
                            <div class="info-item">
                                <i class='bx bx-calendar-check'></i>
                                <div class="content">
                                    <div class="field">
                                        <label>Service Provider:</label>
                                        <span><?php echo htmlspecialchars($p_appointment->sp_first_name . ' ' . $p_appointment->sp_last_name); ?></span>
                                    </div>
                                    <div class="field">
                                        <label>Date:</label>
                                        <span><?php echo htmlspecialchars($p_appointment->appointment_date); ?></span>
                                    </div>
                                    <div class="field">
                                        <label>Time:</label>
                                        <span><?php echo htmlspecialchars($p_appointment->appointment_time); ?></span>
                                    </div>
                                    <div class="field">
                                        <label>Notes:</label>
                                        <span><?php echo htmlspecialchars($p_appointment->description); ?></span>
                                    </div>
                                    <?php if (isset($p_appointment->quotation_details)): ?>
                                        <div class="field">
                                            <label>Quotation Details:</label>
                                            <span><?php echo htmlspecialchars($p_appointment->quotation_details); ?></span>
                                        </div>
                                        <div class="field">
                                            <label>Work Hours:</label>
                                            <span><?php echo htmlspecialchars($p_appointment->work_hours); ?> hours</span>
                                        </div>
                                        <div class="field">
                                            <label>Cost:</label>
                                            <span>$<?php echo number_format($p_appointment->cost, 2); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="action-buttons">
                                        <button type="button" class="btn btn-pay"
                                            onclick="openRatingModal(<?php echo $p_appointment->appointment_id; ?>)">
                                            Mark as Finished
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
            <section class="profile-section">
                <h2>Completed Appointments</h2>
                <?php if (empty($data['f_appointments'])): ?>
                    <p>You don't have any appointments yet.</p>
                <?php else: ?>
                    <div class="info-grid">
                        <?php foreach ($data['f_appointments'] as $f_appointment): ?>
                            <div class="info-item">
                                <i class='bx bx-calendar-check'></i>
                                <div class="content">
                                    <div class="field">
                                        <label>Service Provider:</label>
                                        <span><?php echo htmlspecialchars($f_appointment->sp_first_name . ' ' . $f_appointment->sp_last_name); ?></span>
                                    </div>
                                    <div class="field">
                                        <label>Date:</label>
                                        <span><?php echo htmlspecialchars($f_appointment->appointment_date); ?></span>
                                    </div>
                                    <div class="field">
                                        <label>Time:</label>
                                        <span><?php echo htmlspecialchars($f_appointment->appointment_time); ?></span>
                                    </div>
                                    <div class="field">
                                        <label>Notes:</label>
                                        <span><?php echo htmlspecialchars($f_appointment->description); ?></span>
                                    </div>
                                    <?php if (isset($f_appointment->quotation_details)): ?>
                                        <div class="field">
                                            <label>Quotation Details:</label>
                                            <span><?php echo htmlspecialchars($f_appointment->quotation_details); ?></span>
                                        </div>
                                        <div class="field">
                                            <label>Work Hours:</label>
                                            <span><?php echo htmlspecialchars($f_appointment->work_hours); ?> hours</span>
                                        </div>
                                        <div class="field">
                                            <label>Cost:</label>
                                            <span>$<?php echo number_format($f_appointment->cost, 2); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </section>

    <!-- Edit Profile Modal -->
    <div id="editProfileModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditProfileModal()">&times;</span>
            <h2>Edit Profile</h2>
            <form action="<?php echo URLROOT; ?>/CustomerController/updateProfile" method="POST"
                enctype="multipart/form-data">
                <div class="form-group">
                    <label for="fname">First Name</label>
                    <input type="text" id="fname" name="fname" value="<?php echo $data['customer']->first_name; ?>"
                        required>
                </div>
                <div class="form-group">
                    <label for="lname">Last Name</label>
                    <input type="text" id="lname" name="lname" value="<?php echo $data['customer']->last_name; ?>"
                        required>
                </div>
                <div class="form-group">
                    <label for="contact_number">Contact Number</label>
                    <input type="text" id="contact_number" name="contact_number"
                        value="<?php echo $data['customer']->contact_number; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo $data['customer']->email; ?>"
                        required>
                </div>
                <div class="form-group">
                    <label for="street">Street</label>
                    <input type="text" id="street" name="street" value="<?php echo $data['customer']->street; ?>">
                </div>
                <div class="form-group">
                    <label for="district">District</label>
                    <select id="district" name="district" required>
                        <option value="">-- Select District --</option>
                        <option value="Ampara">Ampara</option>
                        <option value="Anuradhapura">Anuradhapura</option>
                        <option value="Badulla">Badulla</option>
                        <option value="Batticaloa">Batticaloa</option>
                        <option value="Colombo">Colombo</option>
                        <option value="Galle">Galle</option>
                        <option value="Gampaha">Gampaha</option>
                        <option value="Hambantota">Hambantota</option>
                        <option value="Jaffna">Jaffna</option>
                        <option value="Kalutara">Kalutara</option>
                        <option value="Kandy">Kandy</option>
                        <option value="Kegalle">Kegalle</option>
                        <option value="Kilinochchi">Kilinochchi</option>
                        <option value="Kurunegala">Kurunegala</option>
                        <option value="Mannar">Mannar</option>
                        <option value="Matale">Matale</option>
                        <option value="Matara">Matara</option>
                        <option value="Monaragala">Monaragala</option>
                        <option value="Mullaitivu">Mullaitivu</option>
                        <option value="Nuwara Eliya">Nuwara Eliya</option>
                        <option value="Polonnaruwa">Polonnaruwa</option>
                        <option value="Puttalam">Puttalam</option>
                        <option value="Ratnapura">Ratnapura</option>
                        <option value="Trincomalee">Trincomalee</option>
                        <option value="Vavuniya">Vavuniya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="profile_image">Profile Image</label>
                    <input type="file" id="profile_image" name="profile_image" accept="image/jpeg,image/png,image/gif">
                    <small>Accepted formats: JPG, JPEG, PNG, GIF</small>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" onclick="closeEditProfileModal()" class="btn btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Rating Modal -->
    <div id="ratingModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeRatingModal()">&times;</span>
            <h2>Rate Your Appointment</h2>
            <form id="ratingForm" method="POST">
                <div class="rating-container">
                    <div class="star-rating">
                        <input type="radio" id="star1" name="rating" value="1">
                        <label for="star1" title="1 star"><i class='bx bxs-star'></i></label>
                        <input type="radio" id="star2" name="rating" value="2">
                        <label for="star2" title="2 stars"><i class='bx bxs-star'></i></label>
                        <input type="radio" id="star3" name="rating" value="3">
                        <label for="star3" title="3 stars"><i class='bx bxs-star'></i></label>
                        <input type="radio" id="star4" name="rating" value="4">
                        <label for="star4" title="4 stars"><i class='bx bxs-star'></i></label>
                        <input type="radio" id="star5" name="rating" value="5">
                        <label for="star5" title="5 stars"><i class='bx bxs-star'></i></label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="comment">Comment</label>
                    <textarea id="comment" name="comment" rows="4"></textarea>
                </div>
                <div class="form-group" style="text-align: right; margin-top: 20px;">
                    <button type="button" onclick="closeRatingModal()"
                        style="padding: 8px 15px; margin-right: 10px; border-radius: 5px; border: none; background: #6c757d; color: white;">Cancel</button>
                    <button type="submit"
                        style="padding: 8px 15px; border-radius: 5px; border: none; background: #2563eb; color: white;">Submit
                        Rating</button>
                </div>
            </form>
        </div>
    </div>



    <script>
        function openEditModal(id, date, time, notes) {
            document.getElementById('editId').value = id;
            document.getElementById('editDate').value = date;
            document.getElementById('editTime').value = time;
            document.getElementById('editNotes').value = notes.replace(/&amp;/g, '&').replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&quot;/g, '"');
            document.getElementById('editModal').style.display = "block";
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = "none";
        }

        function deleteAppointment(id) {
            if (confirm('Are you sure you want to delete this appointment?')) {
                window.location.href = '<?php echo URLROOT; ?>/CustomerController/deleteAppointment/' + id;
            }
        }

        // Close modal when clicking outside of it
        window.onclick = function (event) {
            if (event.target == document.getElementById('editModal')) {
                closeEditModal();
            }
        }

        function openEditProfileModal() {
            document.getElementById('editProfileModal').style.display = 'block';
        }

        function closeEditProfileModal() {
            document.getElementById('editProfileModal').style.display = 'none';
        }

        // Close modal when clicking outside of it
        window.onclick = function (event) {
            if (event.target == document.getElementById('editProfileModal')) {
                closeEditProfileModal();
            }
        }

        function openRatingModal(appointmentId) {
            document.getElementById('ratingModal').style.display = "block";
            document.getElementById('ratingForm').action = "<?php echo URLROOT; ?>/CustomerController/rateAppointment/" + appointmentId;
        }

        function closeRatingModal() {
            document.getElementById('ratingModal').style.display = "none";
        }

        // Close modal when clicking outside of it
        window.onclick = function (event) {
            if (event.target == document.getElementById('ratingModal')) {
                closeRatingModal();
            }
        }

        // Star rating functionality
        document.addEventListener('DOMContentLoaded', function () {
            const stars = document.querySelectorAll('.star-rating input');
            const labels = document.querySelectorAll('.star-rating label');

            // Add hover effect
            labels.forEach((label, index) => {
                label.addEventListener('mouseover', function () {
                    for (let i = 0; i <= index; i++) {
                        labels[i].style.color = '#ffcc00';
                    }
                });

                label.addEventListener('mouseout', function () {
                    const checkedStar = document.querySelector('.star-rating input:checked');
                    if (checkedStar) {
                        const checkedIndex = Array.from(stars).indexOf(checkedStar);
                        for (let i = 0; i <= checkedIndex; i++) {
                            labels[i].style.color = '#ffcc00';
                        }
                        for (let i = checkedIndex + 1; i < labels.length; i++) {
                            labels[i].style.color = '#ccc';
                        }
                    } else {
                        labels.forEach(l => l.style.color = '#ccc');
                    }
                });
            });

            // Update stars when a rating is selected
            stars.forEach((star, index) => {
                star.addEventListener('change', function () {
                    for (let i = 0; i <= index; i++) {
                        labels[i].style.color = '#ffcc00';
                    }
                    for (let i = index + 1; i < labels.length; i++) {
                        labels[i].style.color = '#ccc';
                    }
                });
            });
        });
    </script>
    <script src="<?php echo URLROOT; ?>/public/js/script-index.js"></script>
</body>

</html>