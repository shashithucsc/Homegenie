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

    <style>
        .container {
            max-width: 800px;
            margin: 2rem auto;
            margin-top: 100px;
            padding: 1rem;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        /* Profile Header */
        .profile-header {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid #2563eb;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-info h1 {
            margin: 0 0 0.5rem;
            font-size: 1.8rem;
        }

        .profile-info p {
            color: #6b7280;
            margin: 0 0 1rem;
        }

        .edit-profile-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .edit-profile-btn:hover {
            background: #1e40af;
            transform: translateY(-2px);
        }

        /* Profile Sections */
        .profile-section {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .profile-section h2 {
            margin: 0 0 1.5rem;
            font-size: 1.4rem;
            /* color: red; */
        }

        .info-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 40px 60px;
            justify-content: flex-start;
            align-items: flex-start;
            padding: 10px;
        }

        .info-item {
            display: flex;
            min-width: 40%;
            max-width: 40%;
            align-items: center;
            gap: 1rem;
        }

        .info-item i {
            color: #2563eb;
            font-size: 2rem;
            /* margin-top: 0.25rem; */
        }

        .info-item label {
            color: #6b7280;
            /* font-size: 0.875rem; */
            /* display: block; */
            margin-bottom: 0.25rem;
        }

        .field {
            margin-left: 5px;
        }

        .field i {
            font-size: 1.2rem;
        }

        .edit-btn,
        .delete-btn {
            cursor: pointer;
            color: #2563eb;
            margin-left: 10px;
        }

        .edit-btn:hover,
        .delete-btn:hover {
            color: #1e40af;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 10px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php require_once APPROOT . '/views/Customer/loggedNavBar.php'; ?>
    <?php $user = isset($data['user']) ? $data['user'] : null; // Changed 'row' to 'user' ?>
    <section class="container">
        <div class="profile-header">
            <div class="profile-avatar">
                <?php if(!empty($data['customer']->profile_image)): ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($data['customer']->profile_image); ?>" alt="Profile Picture">
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
                <h2>Appointments History</h2>
                <?php if(empty($data['appointments'])): ?>
                    <p>You don't have any appointments yet.</p>
                <?php else: ?>
                <div class="info-grid">
                    <?php foreach ($data['appointments'] as $appointment): ?>
                        <div class="info-item">
                            <i class='bx bx-task'></i>
                            <div>
                                <div class="field">
                                    <label>Service Provider:</label>
                                    <span><?php echo htmlspecialchars($appointment->sp_first_name . ' ' . $appointment->sp_last_name); ?></span>
                                </div>
                                <div class="field">
                                    <label>Date:</label>
                                    <span><?php echo htmlspecialchars($appointment->appointment_date); ?></span>
                                </div>
                                <div class="field">
                                    <label>Time:</label>
                                    <span><?php echo htmlspecialchars($appointment->appointment_time); ?></span>
                                </div>
                                <div class="field">
                                    <label>Notes:</label><br>
                                    <span><?php echo htmlspecialchars($appointment->description); ?></span>
                                </div>
                                <div class="field">
                                    <span class="edit-btn" 
                                        onclick="openEditModal(
                                            <?php echo $appointment->appointment_id; ?>, 
                                            '<?php echo $appointment->appointment_date; ?>', 
                                            '<?php echo $appointment->appointment_time; ?>', 
                                            '<?php echo addslashes(htmlspecialchars($appointment->description)); ?>')">
                                        <i class='bx bx-edit-alt'></i>
                                    </span>
                                    <span class="delete-btn" 
                                        onclick="deleteAppointment(<?php echo $appointment->appointment_id; ?>)">
                                        <i class='bx bx-trash'></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </section>
        </div>
    </section>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit Appointment</h2>
            <form id="editForm" method="POST" action="<?php echo URLROOT; ?>/CustomerController/editAppointment">
                <input type="hidden" name="id" id="editId">
                <div class="form-group" style="margin-bottom: 15px;">
                    <label for="editDate">Date:</label>
                    <input type="date" class="form-control" name="date" id="editDate" required style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #ddd;">
                </div>
                
                <div class="form-group" style="margin-bottom: 15px;">
                    <label for="editTime">Time:</label>
                    <input type="time" class="form-control" name="time" id="editTime" required style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #ddd;">
                </div>
                
                <div class="form-group" style="margin-bottom: 15px;">
                    <label for="editNotes">Notes:</label>
                    <textarea class="form-control" name="notes" id="editNotes" rows="4" style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #ddd;"></textarea>
                </div>
                
                <div class="form-group" style="text-align: right;">
                    <button type="button" onclick="closeEditModal()" style="padding: 8px 15px; margin-right: 10px; border-radius: 5px; border: none; background: #6c757d; color: white;">Cancel</button>
                    <button type="submit" style="padding: 8px 15px; border-radius: 5px; border: none; background: #2563eb; color: white;">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div id="editProfileModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditProfileModal()">&times;</span>
            <h2>Edit Profile</h2>
            <form action="<?php echo URLROOT; ?>/CustomerController/updateProfile" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="fname">First Name</label>
                    <input type="text" id="fname" name="fname" value="<?php echo $data['customer']->first_name; ?>" required>
                </div>
                <div class="form-group">
                    <label for="lname">Last Name</label>
                    <input type="text" id="lname" name="lname" value="<?php echo $data['customer']->last_name; ?>" required>
                </div>
                <div class="form-group">
                    <label for="contact_number">Contact Number</label>
                    <input type="text" id="contact_number" name="contact_number" value="<?php echo $data['customer']->contact_number; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo $data['customer']->email; ?>" required>
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
                        <!-- Add more districts -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="province">Province</label>
                    <select id="province" name="province" required>
                        <option value="">-- Select Province --</option>
                        <option value="Western">Western</option>
                        <option value="Central">Central</option>
                        <option value="Southern">Southern</option>
                        <option value="Uva">Uva</option>
                        <option value="Sabaragamuwa">Sabaragamuwa</option>
                        <option value="North Western">North Western</option>
                        <option value="North Central">North Central</option>
                        <option value="Northern">Northern</option>
                        <option value="Eastern">Eastern</option>
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

    <footer>
        <div class="footer-content">
            <div class="footer-section brand">
                <h3>Home<span>Genie</span></h3>
                <p>Connecting homes with quality services and products</p>
                <div class="social-links">
                    <a href="#"><i class='bx bxl-facebook'></i></a>
                    <a href="#"><i class='bx bxl-twitter'></i></a>
                    <a href="#"><i class='bx bxl-instagram'></i></a>
                    <a href="#"><i class='bx bxl-linkedin'></i></a>
                    <a href="#"><i class='bx bxl-github'></i></a>
                </div>
            </div>
            <div class="footer-section links">
                <h3>Quick Links</h3>
                <div class="two-column-links">
                    <div>
                        <a href="cu_home.php">Home</a>
                        <a href="services.php">Services</a>
                        <a href="../../../supplier/HomeController.php">Store</a>
                        <a href="cu_about.php">About</a>
                    </div>
                    <div>
                        <a href="#privacy">Privacy Policy</a>
                        <a href="#terms">Terms of Service</a>
                        <a href="cu_faq.php">FAQ</a>
                        <a href="cu_contact.php">Contact Us</a>
                    </div>
                </div>
            </div>
            <div class="footer-section contact">
                <h3>Contact Us</h3>
                <div class="contact-info">
                    <p><i class='bx bx-phone'></i> (+94) 700000000</p>
                    <p><i class="bx bx-envelope"></i> info@homegenie.com</p>
                    <p><i class="bx bx-map"></i> No.123, Colombo Road, Galle.</p>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 HomeGenie. All rights reserved.</p>
        </div>
    </footer>

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
        window.onclick = function(event) {
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
        window.onclick = function(event) {
            if (event.target == document.getElementById('editProfileModal')) {
                closeEditProfileModal();
            }
        }
    </script>
    <script src="<?php echo URLROOT; ?>/public/js/script-index.js"></script>
</body>
</html>