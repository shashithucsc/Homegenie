<?php
$user_name = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$profile_pic = isset($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : 'default.png';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Get appointments from the data
$appointments = isset($data['appointments']) ? $data['appointments'] : [];

// Separate appointments into upcoming and completed
$upcomingAppointments = [];
$completedAppointments = [];

foreach ($appointments as $appointment) {
    // Check if appointment is in the past or marked as completed
    $appointmentDate = strtotime($appointment->date . ' ' . $appointment->time);
    $isCompleted = isset($appointment->status) && $appointment->status === 'completed';
    
    if ($isCompleted || $appointmentDate < time()) {
        $completedAppointments[] = $appointment;
    } else {
        $upcomingAppointments[] = $appointment;
    }
}
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
            <div class="tab active" data-tab="upcoming">Upcoming Appointments</div>
            <div class="tab" data-tab="completed">Completed Appointments</div>
        </div>

        <!-- Upcoming Appointments Tab -->
        <div class="tab-content active" id="upcoming-tab">
            <?php if (empty($upcomingAppointments)): ?>
                <div class="no-appointments">
                    <h3>No upcoming appointments</h3>
                    <p>You haven't scheduled any appointments yet.</p>
                    <a href="<?php echo URLROOT; ?>/HomeController/services" class="btn btn-reschedule">Find Services</a>
                </div>
            <?php else: ?>
                <?php foreach ($upcomingAppointments as $appointment): ?>
                    <div class="appointment-card">
                        <div class="appointment-header">
                            <div class="provider-info">
                                <img src="<?php echo URLROOT; ?>/public/register/uploads/<?php echo htmlspecialchars($appointment->profile_image ?? 'default.jpg'); ?>" alt="Provider" class="provider-img">
                                <div>
                                    <h3><?php echo htmlspecialchars($appointment->provider_name ?? 'Service Provider'); ?></h3>
                                    <p><?php echo htmlspecialchars($appointment->expertise ?? 'General Service'); ?></p>
                                </div>
                            </div>
                            <div class="date-badge">
                                <?php echo date('M d, Y', strtotime($appointment->date)); ?> at 
                                <?php echo date('h:i A', strtotime($appointment->time)); ?>
                            </div>
                        </div>
                        
                        <div class="appointment-details">
                            <div class="detail-item">
                                <i class='bx bx-map'></i>
                                <span><?php echo htmlspecialchars($appointment->location ?? 'Location not specified'); ?></span>
                            </div>
                            <div class="detail-item">
                                <i class='bx bx-note'></i>
                                <span><?php echo htmlspecialchars($appointment->notes ?? 'No additional notes'); ?></span>
                            </div>
                        </div>
                        
                        <div class="appointment-actions">
                            <a href="<?php echo URLROOT; ?>/HomeController/SPProfile/<?php echo htmlspecialchars($appointment->provider_id); ?>" class="btn btn-reschedule">
                                <i class='bx bx-user'></i> View Provider
                            </a>
                            <a href="<?php echo URLROOT; ?>/CustomerController/rescheduleAppointment/<?php echo $appointment->appointment_id; ?>" class="btn btn-reschedule">
                                <i class='bx bx-calendar-edit'></i> Reschedule
                            </a>
                            <button class="btn btn-cancel" onclick="confirmCancelAppointment(<?php echo $appointment->appointment_id; ?>)">
                                <i class='bx bx-x-circle'></i> Cancel
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Completed Appointments Tab -->
        <div class="tab-content" id="completed-tab">
            <?php if (empty($completedAppointments)): ?>
                <div class="no-appointments">
                    <h3>No completed appointments</h3>
                    <p>Your completed service appointments will appear here.</p>
                </div>
            <?php else: ?>
                <?php foreach ($completedAppointments as $appointment): ?>
                    <div class="appointment-card">
                        <div class="appointment-header">
                            <div class="provider-info">
                                <img src="<?php echo URLROOT; ?>/public/register/uploads/<?php echo htmlspecialchars($appointment->profile_image ?? 'default.jpg'); ?>" alt="Provider" class="provider-img">
                                <div>
                                    <h3><?php echo htmlspecialchars($appointment->provider_name ?? 'Service Provider'); ?></h3>
                                    <p><?php echo htmlspecialchars($appointment->expertise ?? 'General Service'); ?></p>
                                </div>
                            </div>
                            <div class="date-badge">
                                Completed: <?php echo date('M d, Y', strtotime($appointment->date)); ?>
                            </div>
                        </div>
                        
                        <div class="appointment-details">
                            <div class="detail-item">
                                <i class='bx bx-map'></i>
                                <span><?php echo htmlspecialchars($appointment->location ?? 'Location not specified'); ?></span>
                            </div>
                            <div class="detail-item">
                                <i class='bx bx-note'></i>
                                <span><?php echo htmlspecialchars($appointment->notes ?? 'No additional notes'); ?></span>
                            </div>
                            
                            <?php if (isset($appointment->rating) && $appointment->rating > 0): ?>
                                <div class="detail-item">
                                    <i class='bx bx-star'></i>
                                    <span>Your rating: 
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <i class='bx <?php echo $i <= $appointment->rating ? 'bxs-star' : 'bx-star'; ?>'></i>
                                        <?php endfor; ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="appointment-actions">
                            <a href="<?php echo URLROOT; ?>/HomeController/SPProfile/<?php echo htmlspecialchars($appointment->provider_id); ?>" class="btn btn-reschedule">
                                <i class='bx bx-user'></i> View Provider
                            </a>
                            <?php if (!isset($appointment->rating) || $appointment->rating == 0): ?>
                                <button class="btn btn-rate" onclick="openRatingModal(<?php echo $appointment->appointment_id; ?>, '<?php echo htmlspecialchars($appointment->provider_name ?? 'Service Provider'); ?>')">
                                    <i class='bx bx-star'></i> Rate Service
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Rating Modal -->
    <div id="ratingModal" class="modal">
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
    </div>

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

        // Confirm cancel appointment
        function confirmCancelAppointment(appointmentId) {
            if (confirm("Are you sure you want to cancel this appointment?")) {
                window.location.href = `<?php echo URLROOT; ?>/CustomerController/cancelAppointment/${appointmentId}`;
            }
        }

        // Rating functionality
        const ratingModal = document.getElementById('ratingModal');
        const ratingStars = document.querySelectorAll('.rating-star');
        const ratingValueInput = document.getElementById('ratingValue');
        const appointmentIdInput = document.getElementById('appointmentId');
        const providerNameElement = document.getElementById('ratingProviderName');

        // Open rating modal
        function openRatingModal(appointmentId, providerName) {
            appointmentIdInput.value = appointmentId;
            providerNameElement.innerText = `How was your experience with ${providerName}?`;
            ratingModal.style.display = 'flex';
        }

        // Close rating modal
        function closeRatingModal() {
            ratingModal.style.display = 'none';
            resetStars();
        }

        // Click outside to close modal
        window.onclick = function(event) {
            if (event.target == ratingModal) {
                closeRatingModal();
            }
        }

        // Reset stars
        function resetStars() {
            ratingStars.forEach(star => {
                star.classList.remove('active');
                star.classList.remove('bxs-star');
                star.classList.add('bx-star');
            });
            ratingValueInput.value = '';
        }

        // Star rating functionality
        ratingStars.forEach(star => {
            star.addEventListener('mouseover', function() {
                const ratingValue = parseInt(this.getAttribute('data-value'));
                
                resetStars();
                
                for(let i = 0; i < ratingValue; i++) {
                    ratingStars[i].classList.add('active');
                    ratingStars[i].classList.remove('bx-star');
                    ratingStars[i].classList.add('bxs-star');
                }
            });
            
            star.addEventListener('click', function() {
                const ratingValue = parseInt(this.getAttribute('data-value'));
                ratingValueInput.value = ratingValue;
            });
        });
    </script>

</body>

</html>