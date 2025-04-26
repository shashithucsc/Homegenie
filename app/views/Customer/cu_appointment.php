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
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style-appointment.css">

</head>

<body>
    <?php require_once APPROOT . '/views/Customer/loggedNavBar.php'; ?>

    <div class="appointments-container" style="margin-top: 100px;">
        <h1 class="section-title">My Appointments</h1>

        <div class="tabs">
            <div class="tab active" data-tab="pending">Pending Approval</div>
            <div class="tab" data-tab="approved">Pending Payment</div>
        </div>

        <!-- Upcoming Appointments Tab -->
        <div class="tab-content active" id="pending-tab">
            <section class="tab-section">
                <?php if(empty($data['p_appointments'])): ?>
                    <div class="no-appointments">
                        <p>You don't have any appointments yet.</p>
                        <a href="<?php echo URLROOT; ?>/CustomerController/bookAppointment" class="btn btn-pay"><i class='bx bx-calendar-plus'></i> Book an Appointment</a>
                    </div>
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
                                <div class="action-buttons">
                                    <span class="edit-btn" 
                                        onclick="openEditModal(
                                            <?php echo $p_appointment->appointment_id; ?>, 
                                            '<?php echo $p_appointment->appointment_date; ?>', 
                                            '<?php echo $p_appointment->appointment_time; ?>', 
                                            '<?php echo addslashes(htmlspecialchars($p_appointment->description)); ?>')">
                                        Reschedule
                                    </span>
                                    <span class="delete-btn" onclick="deleteAppointment(<?php echo $p_appointment->appointment_id; ?>)">
                                        Cancel
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
                        <div class="form-group">
                            <label for="editDate">Date:</label>
                            <input type="date" class="form-control" name="date" id="editDate" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="editTime">Time:</label>
                            <input type="time" class="form-control" name="time" id="editTime" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="editNotes">Notes:</label>
                            <textarea class="form-control" name="notes" id="editNotes" rows="4"></textarea>
                        </div>
                        
                        <div class="form-group" style="text-align: right; display:flex; flex-direction: column; gap: 10px;">
                            <button type="button" onclick="closeEditModal()" class="btn btn-secondary" style="margin-right: 10px;">Cancel</button>
                            <button type="submit" class="btn">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Completed Appointments Tab -->
        <div class="tab-content" id="approved-tab">
            <section class="tab-section">
                <?php if(empty($data['a_appointments'])): ?>
                    <div class="no-appointments">
                        <p>You don't have any appointments yet.</p>
                    </div>
                <?php else: ?>
                <div class="info-grid">
                    <?php foreach ($data['a_appointments'] as $a_appointment): ?>
                        <div class="info-item">
                            <i class='bx bx-calendar-check'></i>
                            <div class="content">
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
                                    <label>Notes:</label>
                                    <span><?php echo htmlspecialchars($a_appointment->description); ?></span>
                                </div>
                                <?php if(isset($a_appointment->quotation_details)): ?>
                                <div class="field">
                                    <label>Quotation Details:</label>
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
                                <div class="action-buttons">
                                    <form action="<?php echo URLROOT; ?>/CustomerController/payment/<?php echo $a_appointment->appointment_id; ?>" method="POST" class="payment-form">
                                        <input type="hidden" name="amount" value="<?php echo $a_appointment->cost; ?>">
                                        <button type="submit" class="btn btn-pay">
                                            Pay Now
                                        </button>
                                    </form>
                                    <span class="delete-btn" onclick="cancelAppointment(<?php echo $a_appointment->appointment_id; ?>)">
                                        Cancel
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

    <script>
        function openEditModal(id, date, time, notes) {
            document.getElementById('editId').value = id;
            document.getElementById('editDate').value = date;
            document.getElementById('editTime').value = time;
            document.getElementById('editNotes').value = notes.replace(/&amp;/g, '&').replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&quot;/g, '"');
            document.getElementById('editModal').style.display = "flex";
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