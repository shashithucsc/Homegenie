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
    <title>My Appointments - HomeGenie</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/navigationbar.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        .appointments-container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .section-title {
            color: #0f5132;
            margin-bottom: 20px;
            font-size: 24px;
            border-bottom: 2px solid #0f5132;
            padding-bottom: 10px;
        }
        
        .tab-heading {
            color: #0f5132;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e2f0e9;
        }

        .tabs {
            display: flex;
            margin-bottom: 20px;
        }

        .tab {
            padding: 10px 20px;
            background-color: #e9ecef;
            cursor: pointer;
            border-radius: 5px 5px 0 0;
            margin-right: 5px;
        }

        .tab.active {
            background-color: #0f5132;
            color: white;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .appointment-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
        }

        .appointment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .provider-info {
            display: flex;
            align-items: center;
        }

        .provider-img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 15px;
            object-fit: cover;
        }

        .date-badge {
            background-color: #e2f0e9;
            color: #0f5132;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .appointment-details {
            margin-bottom: 20px;
        }

        .detail-item {
            margin-bottom: 10px;
            display: flex;
        }

        .detail-item i {
            color: #0f5132;
            margin-right: 10px;
            font-size: 18px;
            width: 20px;
        }

        .appointment-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 10px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .btn-reschedule {
            background-color: #e2f0e9;
            color: #0f5132;
        }

        .btn-cancel {
            background-color: #f8d7da;
            color: #842029;
        }

        .btn-rate {
            background-color: #ffc107;
            color: #333;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .no-appointments {
            text-align: center;
            padding: 40px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .no-appointments a.btn {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
        }

        /* Rating Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            padding: 25px;
        }

        .close {
            float: right;
            font-size: 24px;
            cursor: pointer;
            color: #777;
        }

        .rating-stars {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .rating-star {
            font-size: 30px;
            color: #ccc;
            cursor: pointer;
            margin: 0 5px;
            transition: color 0.2s;
        }

        .rating-star.active {
            color: #ffc107;
        }
    </style>
</head>

<body>
    <?php require_once APPROOT . '/views/Customer/loggedNavBar.php'; ?>

    <div class="appointments-container">
        <h1 class="section-title">My Appointments</h1>

        <div class="tabs">
            <div class="tab active" data-tab="pending">Pending Approval</div>
            <div class="tab" data-tab="approved">Pending Payment</div>
        </div>

        <!-- Upcoming Appointments Tab -->
        <div class="tab-content active" id="pending-tab">
            <!-- <h3 class="tab-heading">Upcoming Appointments</h3> -->
            
            <section class="tab-section">
                <!-- <h2>Appointments History</h2> -->
                <?php if(empty($data['p_appointments'])): ?>
                    <p>You don't have any appointments yet.</p>
                <?php else: ?>
                <div class="info-grid">
                    <?php foreach ($data['p_appointments'] as $p_appointment): ?>
                        <div class="info-item">
                            <i class='bx bx-task'></i>
                            <div>
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
                                    <label>Notes:</label><br>
                                    <span><?php echo htmlspecialchars($p_appointment->description); ?></span>
                                </div>
                                <div class="field">
                                    <span class="edit-btn" 
                                        onclick="openEditModal(
                                            <?php echo $p_appointment->appointment_id; ?>, 
                                            '<?php echo $p_appointment->appointment_date; ?>', 
                                            '<?php echo $p_appointment->appointment_time; ?>', 
                                            '<?php echo addslashes(htmlspecialchars($p_appointment->description)); ?>')">
                                        Reschedule Appointment
                                        <i class='bx bx-edit-alt'></i>
                                    </span>
                                    <span class="delete-btn" onclick="deleteAppointment(<?php echo $p_appointment->appointment_id; ?>)">Cancel Appointment
                                        <i class='bx bx-trash'></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
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
        </div>

        <!-- Completed Appointments Tab -->
        <div class="tab-content" id="approved-tab">
            <!-- <h3 class="tab-heading">Completed Appointments</h3> -->
            <section class="tab-section">
                <!-- <h2>Appointments History</h2> -->
                <?php if(empty($data['a_appointments'])): ?>
                    <p>You don't have any appointments yet.</p>
                <?php else: ?>
                <div class="info-grid">
                    <!-- <?php
                        print_r($data['a_appointments']);
                    ?> -->
                    <?php foreach ($data['a_appointments'] as $a_appointment): ?>
                        <div class="info-item">
                            <i class='bx bx-task'></i>
                            <div>
                                <div class="field">
                                    <label>Service Provider:</label>
                                    <span><?php echo htmlspecialchars($a_appointment->sp_first_name . ' ' . $a_appointment->sp_last_name); ?></span>
                                </div>
                                <div class="field">
                                    <label>Date:</label>
                                    <span><?php echo htmlspecialchars($a_appointment->appointment_date); ?></span>
                                </div>
                                <div class="field">
                                    <label>Time:</label>
                                    <span><?php echo htmlspecialchars($a_appointment->appointment_time); ?></span>
                                </div>
                                <div class="field">
                                    <label>Notes:</label><br>
                                    <span><?php echo htmlspecialchars($a_appointment->description); ?></span>
                                </div>
                                <?php if(isset($a_appointment->quotation_details)): ?>
                                <div class="field">
                                    <label>Quotation Details:</label><br>
                                    <span><?php echo htmlspecialchars($a_appointment->quotation_details); ?></span>
                                </div>
                                <div class="field">
                                    <label>Work Hours:</label>
                                    <span><?php echo htmlspecialchars($a_appointment->work_hours); ?> hours</span>
                                </div>
                                <div class="field">
                                    <label>Cost:</label>
                                    <span>$<?php echo number_format($a_appointment->cost, 2); ?></span>
                                </div>
                                <?php endif; ?>
                                <div class="field">
                                    <form action="<?php echo URLROOT; ?>/CustomerController/payment/<?php echo $a_appointment->appointment_id; ?>" method="POST">
                                        <input type="hidden" name="amount" value="<?php echo $a_appointment->cost; ?>">
                                        <button type="submit" class="btn btn-pay">Pay Now</button>
                                    </form>
                                    <span class="delete-btn" onclick="cancelAppointment(<?php echo $a_appointment->appointment_id; ?>)">Cancel
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
    </div>

    <!-- Rating Modal -->
    <!-- <div id="ratingModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeRatingModal()">&times;</span>
            <h2>Rate your experience</h2>
            <p id="ratingProviderName">How was your experience with this service provider?</p>
            
            <div class="rating-stars">
                <i class='bx bx-star rating-star' data-value="1"></i>
                <i class='bx bx-star rating-star' data-value="2"></i>
                <i class='bx bx-star rating-star' data-value="3"></i>
                <i class='bx bx-star rating-star' data-value="4"></i>
                <i class='bx bx-star rating-star' data-value="5"></i>
            </div>
            
            <form id="ratingForm" method="POST" action="<?php echo URLROOT; ?>/CustomerController/rateProvider">
                <input type="hidden" id="appointmentId" name="appointment_id" value="">
                <input type="hidden" id="ratingValue" name="rating" value="">
                <textarea name="review" placeholder="Write your review here (optional)" rows="4" style="width: 100%; margin-bottom: 15px; padding: 10px; border-radius: 5px; border: 1px solid #ddd;"></textarea>
                <button type="submit" class="btn btn-rate" style="width: 100%;">Submit Rating</button>
            </form>
        </div>
    </div> -->

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
    </script>
    <script src="<?php echo URLROOT; ?>/public/js/script-index.js"></script>

    <script>
        // Tab switching functionality
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const tabId = tab.getAttribute('data-tab');
                
                // Remove active class from all tabs and contents
                tabs.forEach(t => t.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab and corresponding content
                tab.classList.add('active');
                document.getElementById(tabId + '-tab').classList.add('active');
            });
        });
    </script>
    <script src="<?php echo URLROOT; ?>/public/js/script-index.js"></script>

</body>

</html>