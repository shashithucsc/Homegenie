<?php
$user_name = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$profile_pic = isset($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : 'default.png';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$email = isset($_SESSION['email']) ? $_SESSION['email'] : null;

// Service provider data
$provider = $data['serviceProvider'];
$providerName = $provider->first_name . ' ' . $provider->last_name;
$spImagePath = URLROOT . '/public/register/uploads/' . $provider->profile_image;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Provider Profile - HomeGenie</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/navigationbar.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style-services.css">
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
        .container {
            max-width: 800px;
            margin: 2rem auto;
            margin-top: 100px;
            padding: 2rem;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        
        h2 {
            color: #2563eb;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #4b5563;
        }
        
        input, select, textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        input:focus, select:focus, textarea:focus {
            border-color: #2563eb;
            outline: none;
        }
        .btn-submit {
            background: #2563eb;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 1rem;
            transition: background 0.3s;
        }
        
        .btn-submit:hover {
            background: #1e40af;
        }
        
        .provider-info {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: #f3f4f6;
            border-radius: 5px;
        }
        .provider-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 1rem;
        }
        
        .provider-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .provider-name {
            font-weight: 600;
            color: #1f2937;
        }
        
        .provider-expertise {
            color: #6b7280;
            font-size: 0.875rem;
        }

    </style>
</head>

<body>
    <?php require_once APPROOT . '/views/Customer/loggedNavBar.php'; ?>

    <section class="container">
        <div class="profile-header">
            <div class="profile-avatar">
                <img id="avatarImage" src="<?php echo htmlspecialchars($spImagePath); ?>" alt="Profile Picture">
            </div>
            <div class="profile-info">
                <h1 id="profileName"><?php echo htmlspecialchars($providerName); ?> 
                    <span class="service-type"><?php echo htmlspecialchars($provider->expertise); ?></span>
                </h1>
                <p id="profileEmail"><?php echo htmlspecialchars($provider->email); ?></p>
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
                            <p id="spPhone"><?php echo htmlspecialchars($provider->contact_number); ?></p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class='bx bx-map'></i>
                        <div>
                            <div style="display: flex">
                                <p id="spStreet"><?php echo htmlspecialchars($provider->street); ?> , </p><p id="spDistrict"><?php echo htmlspecialchars($provider->district); ?> , </p><p id="spProvince"><?php echo htmlspecialchars($provider->province); ?> .</p>
                            </div>
                            <!-- <div>
                                <label>Distric</label>
                                <p id="spDistrict"><?php echo htmlspecialchars($provider->district); ?></p>
                            </div>
                            <div>
                                <label>Province</label>
                                <p id="spProvince"><?php echo htmlspecialchars($provider->province); ?></p>
                            </div> -->
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
                            <p id="spPhone"><?php echo htmlspecialchars($provider->working_hours); ?></p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class='bx bx-location-plus'></i>
                        <div>
                            <label>Service Areas</label>
                            <p id="spAddress"><?php echo htmlspecialchars($provider->service_areas); ?></p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="profile-section">
                <h2>Work Photos</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <?php if (!empty($provider->work_photos)): ?>
                            <?php $work_photos = explode(",", $provider->work_photos); ?>
                            <?php foreach ($work_photos as $photo): ?>
                                <div class="image-tile">
                                    <img src="<?php echo URLROOT; ?>/public/img/SVPpic/<?php echo htmlspecialchars(trim($photo)); ?>" alt="Work Photo">
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No work photos available</p>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </div>
    </section>

    <div id="appointmentModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAppointmentModal()">&times;</span>
            <h2>Make an Appointment</h2>
            <form action="<?php echo URLROOT; ?>/CustomerController/createAppointment" method="POST">
            <?php if (!$provider): ?>
            <div class="form-group">
                <label for="service_provider">Service Provider</label>
                <select id="service_provider" name="sp_id" required>
                    <option value="">Select a Service Provider</option>
                    <?php foreach($data['serviceProviders'] as $sp): ?>
                    <option value="<?php echo $sp->user_id; ?>">
                        <?php echo htmlspecialchars($sp->first_name . ' ' . $sp->last_name . ' (' . $sp->expertise . ')'); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php else: ?>
            <input type="hidden" name="sp_id" value="<?php echo $provider->user_id; ?>">
            <?php endif; ?>
            
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" id="date" name="date" required min="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="form-group">
                <label for="time">Time</label>
                <input type="time" id="time" name="time" required>
            </div>
            
            <div class="form-group">
                <label for="address">Your Address</label>
                <input type="text" id="address" name="address" required placeholder="Enter your complete address">
            </div>
            
            <div class="form-group">
                <label for="msg">Additional Notes</label>
                <textarea id="msg" name="msg" rows="4" placeholder="Describe any specific requirements or details about your service needs"></textarea>
            </div>
            
            <button type="submit" class="btn-submit">Schedule Appointment</button>
        </form>
              
        </div>
    </div>

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
    <script src="<?php echo URLROOT; ?>/public/js/script-index.js"></script>

</body>

</html>