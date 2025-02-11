<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "Service provider ID not provided.";
    exit;
}

require_once '../db.php';

$providerId = $_GET['id'];
$query = "SELECT * FROM users WHERE id = :provider_id AND account_type_id = 2";
$stmt = $conn->prepare($query);
$stmt->bindParam(':provider_id', $providerId, PDO::PARAM_INT);
$stmt->execute();
$provider = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$provider) {
    echo "Service provider not found.";
    exit;
}

$providerName = $provider["first_name"] . " " . $provider["last_name"];
$spImage = $provider['profile_image'];
$spImagePath = "../register/uploads/" . $spImage;
if (!file_exists($spImagePath)) {
    echo "Profile image not found: " . htmlspecialchars($spImagePath);
    exit;
}

$query = "SELECT * FROM users WHERE id = :user_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User not found.";
    exit;
}
$customerName = $user["first_name"] . " " . $user["last_name"]; // Get the admin's name

$profileImage = $user['profile_image'];

$profileImagePath = "../register/uploads/" . $profileImage;
if (!file_exists($profileImagePath)) {
    echo "Profile image not found: " . htmlspecialchars($profileImagePath);
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $address = $_POST['address'];
    $msg = $_POST['msg'];
    $created_time = date('Y-m-d H:i:s');

    $query = "INSERT INTO appointment (cu_id, sp_id, date, time, cu_address, notes, created_time) VALUES (:cu_id, :sp_id, :date, :time, :cu_address, :notes, :created_time)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':cu_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->bindParam(':sp_id', $providerId, PDO::PARAM_INT);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':time', $time);
    $stmt->bindParam(':cu_address', $address);
    $stmt->bindParam(':notes', $msg);
    // $stmt->bindParam(':pay_method', $payment_method);
    $stmt->bindParam(':created_time', $created_time);

    if ($stmt->execute()) {
        echo "<script>alert('Appointment created successfully!');</script>";
    } else {
        echo "<script>alert('Failed to create appointment.');</script>";
    }
    header("Location: cu_sp_profile.php?id={$provider['id']}");
}

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
            align-items: center;
            gap: 1rem;
        }

        .info-item {
            display: flex;
            min-width: 50%;
            max-width: 50%;
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

        .service-type {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: var(--gray-100);
            border-radius: 15px;
            font-size: 1.1rem;
            color: var(--gray-500);
            margin-bottom: 0.5rem;
            margin-left: 0.5rem;

        }

        h1 {
            display: flex;
            align-items: center;
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
            <a href="#">Store</a>
            <a href="cu_about.php">About</a>
            <div class="profile-container">
                <span class="name"><?php echo htmlspecialchars($customerName); ?></span>
                <img src="<?php echo htmlspecialchars($profileImagePath); ?>" alt="Profile Picture"
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
                <img id="avatarImage" src="<?php echo htmlspecialchars($spImagePath); ?>" alt="Profile Picture">
            </div>
            <div class="profile-info">
                <h1 id="profileName"><?php echo htmlspecialchars($providerName); ?> <span
                        class="service-type"><?php echo htmlspecialchars($provider['expertise']); ?></span></h1>
                <p id="profileEmail"><?php echo htmlspecialchars($provider['email']); ?></p>
                <div class="edit-profile-btn" id="makeAppointmentBtn">
                    <i class='bx bx-calendar-plus'></i> Make an Appointment
                </div>
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
                            <p id="spPhone"><?php echo htmlspecialchars($provider['contact_number']); ?></p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class='bx bx-map'></i>
                        <div>
                            <label>Address</label>
                            <p id="spAddress"><?php echo htmlspecialchars($provider['address']); ?></p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="profile-section">
                <h2>Availability Details</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <i class='bx bx-calendar'></i>
                        <div>
                            <label>Working Hours</label>
                            <p id="spPhone"><?php echo htmlspecialchars($provider['working_hours']); ?></p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class='bx bx-location-plus'></i>
                        <div>
                            <label>Service Areas</label>
                            <p id="spAddress"><?php echo htmlspecialchars($provider['service_areas']); ?></p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="profile-section">
                <h2>Work Photos</h2>
                <div class="info-grid">
                    <div class="info-item">

                    </div>
            </section>
        </div>
    </section>

    <div id="appointmentModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAppointmentModal()">&times;</span>
            <h2>Make an Appointment</h2>
            <form action="" method="POST" autocomplete="off">
                <div class="field time-field">
                    <div class="input-field">
                        <input type="date" id="date" placeholder="Date" name="date" required>
                    </div>
                </div>
                <div class="field time-field">
                    <div class="input-field">
                        <input type="time" id="time" placeholder="Time" name="time" required>
                    </div>
                </div>
                <div class="field address-field">
                    <div class="input-field">
                        <input type="text" id="address" placeholder="No: Lane, City" name="address" required>
                    </div>
                </div>
                <div class="field textare-field">
                    <div class="input-field">
                        <textarea id="msg" placeholder="Additional note" name="msg" required></textarea>
                    </div>
                </div>
                <br>
                <div class="input-field button">
                    <input type="submit" value="Make Appointment">
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
        document.getElementById('makeAppointmentBtn').addEventListener('click', function () {
            document.getElementById('appointmentModal').style.display = 'block';
        });

        function closeAppointmentModal() {
            document.getElementById('appointmentModal').style.display = 'none';
        }

        window.onclick = function (event) {
            if (event.target == document.getElementById('appointmentModal')) {
                closeAppointmentModal();
            }
        }
    </script>

    <script src="../../js/script-index.js"></script>
    <script src="../../js/services.js"></script>

</body>

</html>