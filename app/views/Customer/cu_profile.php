<?php
$user_name = isset($customer->first_name) ? $customer->first_name . ' ' . $customer->last_name : 'Guest';
$profile_pic = isset($customer->profile_image) ? $customer->profile_image : 'default.png';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - HomeGenie</title>
    <link rel="stylesheet" href="../../css/appointment.css">
    <link rel="stylesheet" href="../../css/style-index.css">
    <!-- <link rel="stylesheet" href="../../css/style-profile.css"> -->
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
<nav>
        <a href="cu_home.php" class="nav-brand">Home<span>Genie</span></a>
        <div class="nav-links">
            <a href="cu_home.php">Home</a>
            <a href="services.php">Services</a>
            <a href="../../../supplier/HomeController.php">Store</a>
            <a href="cu_about.php">About</a>
            <div class="profile-container">
                <span class="name"><?php echo htmlspecialchars($user_name); ?></span>
                <img src="<?php echo htmlspecialchars($profile_pic); ?>" alt="Profile Picture"
                    class="profile-image">
                <div class="profile-dropdown">
                    <a href="cu_profile.php"><i class='bx bx-user'></i> My Profile</a>
                    <!-- <a href="cu_appointments.php"><i class='bx bx-paperclip'></i> My Appointments</a> -->
                    <!-- <a href="cu_settings.php"><i class='bx bx-cog'></i> Settings</a> -->
                    <a href="../login/logout.php"><i class='bx bx-log-out'></i> Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="container">
        <div class="profile-header">
            <div class="profile-avatar">
                <img id="avatarImage" src="<?php echo htmlspecialchars($profile_pic); ?>" alt="Profile Picture">
            </div>
            <div class="profile-info">
                <h1 id="profileName"><?php echo htmlspecialchars($user_name); ?></h1>
                <p id="profileEmail"><?php echo htmlspecialchars($customer->email); ?></p>
                <a href="cu_settings.php" class="edit-profile-btn">
                    <i class='bx bx-edit-alt'></i> Edit Profile
                </a>
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
                            <p id="profilePhone"><?php echo htmlspecialchars($customer->contact_number); ?></p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class='bx bx-map'></i>
                        <div>
                            <label>Address</label>
                            <p id="profileAddress"><?php echo htmlspecialchars($customer->address); ?></p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="profile-section">
                <h2>Appointments History</h2>
                <div class="info-grid">
                    <?php if (isset($appointments) && is_array($appointments)): ?>
                        <?php foreach ($appointments as $appointment): ?>
                            <div class="info-item">
                                <i class='bx bx-task'></i>
                                <div>
                                    <div class="field">
                                        <label>Service Provider :</label>
                                        <span id="sp_id"><?php echo htmlspecialchars($appointment['sp_first_name'] . ' ' . $appointment['sp_last_name']); ?></span>
                                    </div>
                                    <div class="field">
                                        <label>Date :</label>
                                        <span id="date"><?php echo htmlspecialchars($appointment['date']); ?></span>
                                    </div>
                                    <div class="field">
                                        <label>Time :</label>
                                        <span id="time"><?php echo htmlspecialchars($appointment['time']); ?></span>
                                    </div>
                                    <div class="field">
                                        <label>Notes :</label><br>
                                        <span id="notes"><?php echo htmlspecialchars($appointment['notes']); ?></span>
                                    </div>
                                    <div class="field">
                                        <span class="edit-btn" onclick="openEditModal(<?php echo $appointment['id']; ?>, '<?php echo $appointment['date']; ?>', '<?php echo $appointment['time']; ?>', '<?php echo htmlspecialchars($appointment['notes']); ?>')"><i class='bx bx-edit-alt'></i></span>
                                        <span class="delete-btn" onclick="deleteAppointment(<?php echo $appointment['id']; ?>)"><i class='bx bx-trash'></i></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No appointments found.</p>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </section>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit Appointment</h2>
            <form id="editForm" method="POST" action="edit_appointment.php">
                <input type="hidden" name="id" id="editId">
                <div class="field time-field">
                    <div class="input-field">
                        <input type="date" name="date" id="editDate" required>
                    </div>
                </div>
                <div class="field time-field">
                    <div class="input-field">
                        <input type="time" name="time" id="editTime" required>
                    </div>
                </div>
                <div class="field textare-field">
                    <div class="input-field">
                        <textarea name="notes" id="editNotes" required></textarea>
                    </div>
                </div>
                <div class="input-field button">
                    <button type="submit">Save Changes</button>
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
            document.getElementById('editNotes').value = notes;
            document.getElementById('editModal').style.display = "block";
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = "none";
        }

        function deleteAppointment(id) {
            if (confirm('Are you sure you want to delete this appointment?')) {
                window.location.href = 'delete_appointment.php?id=' + id;
            }
        }

        window.onclick = function (event) {
            if (event.target == document.getElementById('editModal')) {
                closeEditModal();
            }
        }
    </script>
    <script src="../../js/script-index.js"></script>
    <script src="../../js/services.js"></script>

</body>

</html>