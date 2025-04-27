<?php
require_once APPROOT . '/views/ServiceProvider/navbar_svp.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/SVP/SVP_appointments.css">

</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Appointments Dashboard</h1>
            <p>Manage your service appointments efficiently</p>
        </div>

        <!-- Tab Buttons -->
        <div class="tabs">
            <button class="tab-btn active" data-tab="pending-tab">
                <i class="fas fa-clock"></i> Pending Appointments
            </button>
            <button class="tab-btn" data-tab="approved-tab">
                <i class="fas fa-check-circle"></i> Approved Appointments
            </button>
        </div>

        <!-- Filter Section -->
        <div class="filters-container" id="pending-filters">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" id="search-input" placeholder="Search appointments...">
            </div>
            <div class="district-filter">
                <select id="district-select">
                    <option value="">All Districts</option>
                </select>
            </div>
        </div>

        <!-- Pending Appointments -->
        <div id="pending-tab" class="tab-content active">
            <div class="pending-appointments" id="pending-appointments-grid">
                <?php 
                // Sort appointments by date and time
                usort($data['pendingAppointments'], function($a, $b) {
                    $dateA = strtotime($a->appointment_date . ' ' . $a->appointment_time);
                    $dateB = strtotime($b->appointment_date . ' ' . $b->appointment_time);
                    return $dateA - $dateB;
                });
                
                foreach ($data['pendingAppointments'] as $appointment): ?>
                    <div class="appointment-card"
                         id="appointment-<?= $appointment->appointment_id ?>"
                         data-description="<?= strtolower($appointment->description) ?>"
                         data-location="<?= strtolower($appointment->location) ?>">
                        <div class="appointment-header">
                            <span class="appointment-id">ID: <?= $appointment->appointment_id ?></span>
                        </div>
                        <div class="appointment-details">
                            <div class="info-row">
                                <i class="fas fa-calendar"></i>
                                <span><?= $appointment->appointment_date ?></span>
                            </div>
                            <div class="info-row">
                                <i class="fas fa-clock"></i>
                                <span><?= $appointment->appointment_time ?></span>
                            </div>
                            <div class="info-row">
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?= $appointment->location ?></span>
                            </div>
                            <div class="info-row">
                                <i class="fas fa-info-circle"></i>
                                <span><?= $appointment->description ?></span>
                            </div>
                        </div>
                        <div class="appointment-actions">
                            <button class="action-btn approve-btn" onclick="approveAppointment(<?= $appointment->appointment_id ?>)">
                                <i class="fas fa-check"></i> Approve
                            </button>
                            <button class="action-btn reject-btn" onclick="rejectAppointment(<?= $appointment->appointment_id ?>)">
                                <i class="fas fa-times"></i> Reject
                            </button>
                        </div>
                        <div class="appointment-status">Pending</div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Approved Appointments -->
        <div id="approved-tab" class="tab-content">
            <div class="approved-content-wrapper">
                <!-- Calendar Section -->
                <div class="calendar-container">
                    <div class="calendar-header">
                        <button id="prevMonth" class="calendar-nav-btn">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <h2 id="currentMonthYear"><?php echo date('F Y'); ?></h2>
                        <button id="nextMonth" class="calendar-nav-btn">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="calendar-grid">
                        <div class="calendar-weekdays">
                            <div>Sun</div>
                            <div>Mon</div>
                            <div>Tue</div>
                            <div>Wed</div>
                            <div>Thu</div>
                            <div>Fri</div>
                            <div>Sat</div>
                        </div>
                        <div id="calendarDays" class="calendar-days">
                            <!-- Calendar days will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
                
                <!-- Table Section -->
                <div class="table-container">
                    <?php if (!empty($data['approvedAppointments'])): ?>
                        <table class="approved-appointments-table">
                            <thead>
                                <tr>
                                    <th>Appointment ID</th>
                                    <th>Customer</th>
                                    <th>Date & Time & Place</th>
                                    <th>Details</th>
                                    <th>Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['approvedAppointments'] as $appointment): ?>
                                    <tr>
                                        <td>
                                            <div class="id-cell">
                                                #<?php echo $appointment->appointment_id; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="customer-cell">
                                                <div class="customer-name">
                                                    <i class="fas fa-user"></i>
                                                    <?php echo htmlspecialchars($appointment->customer_name); ?>
                                                </div>
                                                <div class="customer-contact">
                                                    <i class="fas fa-phone"></i>
                                                    <?php echo htmlspecialchars($appointment->contact_number); ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="datetime-location-cell">
                                                <div class="date">
                                                    <i class="fas fa-calendar"></i>
                                                    <?php echo date('F d, Y', strtotime($appointment->appointment_date)); ?>
                                                </div>
                                                <div class="time">
                                                    <i class="fas fa-clock"></i>
                                                    <?php echo $appointment->appointment_time; ?>
                                                </div>
                                                <div class="location">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <?php echo htmlspecialchars($appointment->location); ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="details-cell">
                                                <div class="description">
                                                    <i class="fas fa-info-circle"></i>
                                                    <span><?php echo htmlspecialchars($appointment->description); ?></span>
                                                </div>
                                                <div class="quotation">
                                                    <i class="fas fa-file-alt"></i>
                                                    <span><?php echo htmlspecialchars($appointment->quotation_details); ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="work-details-cell">
                                                <div class="hours">
                                                    <i class="fas fa-hourglass-half"></i>
                                                    <?php echo $appointment->work_hours ?? '0'; ?> hours
                                                </div>
                                                <div class="cost">
                                                    Rs: <?php echo number_format($appointment->cost, 2); ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="no-appointments">
                            <i class="fas fa-calendar-check"></i>
                            <p>No approved appointments found</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Modal -->
    <div id="confirm-modal" class="modal">
        <div class="modal-content" style="max-width: 400px; margin: 50px auto; background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); position: relative;">
            <div style="padding: 30px; text-align: center;">
                <p id="confirm-message" style="color: #374151; font-size: 18px; margin-bottom: 25px; line-height: 1.5;"></p>
                <div class="modal-buttons" style="display: flex; justify-content: center; gap: 15px;">
                    <button class="btn btn-primary" onclick="handleConfirm(true)" 
                        style="padding: 12px 24px; border: none; border-radius: 6px; background: #2563eb; color: white; cursor: pointer; font-weight: 500; min-width: 100px;">
                        <i class="fas fa-check"></i> Yes
                    </button>
                    <button class="btn btn-outline" onclick="handleConfirm(false)"
                        style="padding: 12px 24px; border: 1px solid #e5e7eb; border-radius: 6px; background: white; color: #4b5563; cursor: pointer; font-weight: 500; min-width: 100px;">
                        <i class="fas fa-times"></i> No
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Quotation Modal -->
    <div id="quotationModal" class="modal">
        <div class="modal-content" style="max-width: 600px; margin: 50px auto; background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); position: relative;">
            <span class="close" onclick="closeQuotationModal()" style="position: absolute; right: 20px; top: 15px; font-size: 24px; cursor: pointer; color: #666;">&times;</span>
            <div style="padding: 30px;">
                <h2 style="color: #2563eb; margin-bottom: 25px; text-align: center; font-size: 24px;">Create Quotation</h2>
                <form id="quotationForm" action="<?php echo URLROOT; ?>/ServiceProviderController/createQuotation" method="POST">
                    <input type="hidden" name="appointment_id" id="quotationAppointmentId">
                    <input type="hidden" name="service_provider_id" value="<?= $_SESSION['user_id'] ?>">
                    
                    <div class="form-group" style="margin-bottom: 20px; background: #f8fafc; padding: 15px; border-radius: 8px;">
                        <label style="display: block; color: #4b5563; font-weight: 500; margin-bottom: 10px;">Appointment Details:</label>
                        <div id="appointmentDetails" style="color: #374151;"></div>
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label for="quotation_details" style="display: block; color: #4b5563; font-weight: 500; margin-bottom: 8px;">Task Description:</label>
                        <textarea id="quotation_details" name="quotation_details" required 
                            style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 6px; min-height: 100px; resize: vertical;"
                            placeholder="Enter detailed description of the work to be done"></textarea>
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label for="work_hours" style="display: block; color: #4b5563; font-weight: 500; margin-bottom: 8px;">Estimated Time to Work (hours):</label>
                        <input type="number" id="work_hours" name="work_hours" required min="1" 
                            style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 6px;"
                            placeholder="Enter estimated hours">
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 25px;">
                        <label for="cost" style="display: block; color: #4b5563; font-weight: 500; margin-bottom: 8px;">Full Cost:</label>
                        <input type="number" id="cost" name="cost" readonly 
                            style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 6px; background: #f3f4f6;"
                            placeholder="Cost will be calculated automatically">
                    </div>
                    
                    <div class="form-actions" style="display: flex; justify-content: flex-end; gap: 15px;">
                        <button type="button" onclick="closeQuotationModal()" 
                            style="padding: 12px 24px; border: 1px solid #e5e7eb; border-radius: 6px; background: white; color: #4b5563; cursor: pointer; font-weight: 500;">
                            Cancel
                        </button>
                        <button type="submit" 
                            style="padding: 12px 24px; border: none; border-radius: 6px; background: #2563eb; color: white; cursor: pointer; font-weight: 500;">
                            Generate Quotation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Tabs
        document.querySelectorAll('.tab-btn').forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons and content
                document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

                // Add active class to clicked button and corresponding content
                button.classList.add('active');
                document.getElementById(button.dataset.tab).classList.add('active');

                // Show/hide filter section based on active tab
                const filtersContainer = document.getElementById('pending-filters');
                if (button.dataset.tab === 'pending-tab') {
                    filtersContainer.style.display = 'flex';
                } else {
                    filtersContainer.style.display = 'none';
                }
            });
        });

        // Approve / Reject Handlers
        function approveAppointment(id) {
            customConfirm('Do you want to create a quotation for this appointment?', confirmed => {
                if (confirmed) {
                    // Fetch appointment details
                    fetch('<?php echo URLROOT; ?>/ServiceProviderController/getAppointmentDetails/' + id)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                                document.getElementById('quotationAppointmentId').value = id;
                                document.getElementById('appointmentDetails').innerHTML = `
                                    <div style="margin-bottom: 8px;">
                                        <strong style="color: #2563eb;">Appointment ID:</strong> 
                                        <span>${data.appointment.appointment_id}</span>
                                    </div>
                                    <div style="margin-bottom: 8px;">
                                        <strong style="color: #2563eb;">Date:</strong> 
                                        <span>${data.appointment.appointment_date}</span>
                                    </div>
                                    <div style="margin-bottom: 8px;">
                                        <strong style="color: #2563eb;">Time:</strong> 
                                        <span>${data.appointment.appointment_time}</span>
                                    </div>
                                    <div style="margin-bottom: 8px;">
                                        <strong style="color: #2563eb;">Location:</strong> 
                                        <span>${data.appointment.location}</span>
                                    </div>
                                    <div>
                                        <strong style="color: #2563eb;">Description:</strong> 
                                        <span>${data.appointment.description}</span>
                                    </div>
                                `;
                                document.getElementById('quotationModal').style.display = 'block';
                                // Reset form fields
                                document.getElementById('quotation_details').value = '';
                                document.getElementById('work_hours').value = '';
                                document.getElementById('cost').value = '';
                        } else {
                                showToast('Error fetching appointment details', 'error');
                        }
                    });
                }
            });
        }

        function rejectAppointment(id) {
            customConfirm('Are you sure you want to reject this appointment?', confirmed => {
                if (confirmed) {
                    // Create a form element
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '<?php echo URLROOT; ?>/ServiceProviderController/rejectAppointment';
                    
                    // Create and append the appointment ID input
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'id';
                    input.value = id;
                    form.appendChild(input);
                    
                    // Append form to body and submit
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Custom Confirm Modal Logic
        let confirmCallback = null;
        function customConfirm(message, callback) {
            document.getElementById('confirm-message').textContent = message;
            document.getElementById('confirm-modal').style.display = 'flex';
            confirmCallback = callback;
        }

        function handleConfirm(result) {
            document.getElementById('confirm-modal').style.display = 'none';
            if (confirmCallback) confirmCallback(result);
            confirmCallback = null;
        }

        // Populate Districts
        const districts = [
            'Ampara', 'Anuradhapura', 'Badulla', 'Batticaloa', 'Colombo',
            'Galle', 'Gampaha', 'Hambantota', 'Jaffna', 'Kalutara',
            'Kandy', 'Kegalle', 'Kilinochchi', 'Kurunegala', 'Mannar',
            'Matale', 'Matara', 'Monaragala', 'Mullaitivu', 'Nuwara Eliya',
            'Polonnaruwa', 'Puttalam', 'Ratnapura', 'Trincomalee', 'Vavuniya'
        ];
        const districtSelect = document.getElementById('district-select');
        districts.forEach(d => {
            const option = document.createElement('option');
            option.value = d.toLowerCase();
            option.textContent = d;
            districtSelect.appendChild(option);
        });

        // Filtering Logic
        function filterAppointments() {
            const term = document.getElementById('search-input').value.toLowerCase();
            const district = districtSelect.value.toLowerCase();

            document.querySelectorAll('#pending-appointments-grid .appointment-card').forEach(card => {
                const desc = card.dataset.description;
                const loc = card.dataset.location;
                const matchesSearch = desc.includes(term) || loc.includes(term);
                const matchesDistrict = !district || loc.includes(district);
                card.style.display = matchesSearch && matchesDistrict ? 'block' : 'none';
            });
        }

        document.getElementById('search-input').addEventListener('input', filterAppointments);
        districtSelect.addEventListener('change', filterAppointments);

        function closeQuotationModal() {
            const modal = document.getElementById('quotationModal');
            if (modal) {
                modal.style.display = 'none';
            }
        }

        // Calculate cost based on work hours
        document.getElementById('work_hours').addEventListener('input', function() {
            const hourlyRate = <?= $data['hourlyRate'] ?? 0 ?>;
            const workHours = this.value;
            document.getElementById('cost').value = hourlyRate * workHours;
        });

        // Update the form submission to handle redirection
        document.getElementById('quotationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('quotationModal').style.display = 'none';
                    window.location.reload();
                } else {
                    showToast(data.message || 'Failed to create quotation', 'error');
                }
            })
            .catch(error => {
                showToast('An error occurred', 'error');
                console.error('Error:', error);
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const calendarDays = document.getElementById('calendarDays');
            const currentMonthYear = document.getElementById('currentMonthYear');
            const prevMonthBtn = document.getElementById('prevMonth');
            const nextMonthBtn = document.getElementById('nextMonth');
            const appointmentRows = document.querySelectorAll('.appointment-row');

            let currentDate = new Date();
            let appointments = <?php echo json_encode($data['approvedAppointments'] ?? []); ?>;
            let selectedDate = null;

            function generateCalendar() {
                calendarDays.innerHTML = '';
                
                const year = currentDate.getFullYear();
                const month = currentDate.getMonth();
                
                // Get first day of the month
                const firstDay = new Date(year, month, 1);
                const startingDay = firstDay.getDay();
                
                // Get last day of the month
                const lastDay = new Date(year, month + 1, 0);
                const totalDays = lastDay.getDate();
                
                // Get last day of previous month
                const prevLastDay = new Date(year, month, 0).getDate();
                
                // Update month and year display
                currentMonthYear.textContent = new Date(year, month).toLocaleString('default', { month: 'long', year: 'numeric' });
                
                // Add days from previous month
                for (let i = startingDay - 1; i >= 0; i--) {
                    const day = document.createElement('div');
                    day.className = 'calendar-day other-month';
                    day.textContent = prevLastDay - i;
                    calendarDays.appendChild(day);
                }
                
                // Add days of current month
                for (let i = 1; i <= totalDays; i++) {
                    const day = document.createElement('div');
                    day.className = 'calendar-day';
                    day.textContent = i;
                    
                    // Check if today
                    const today = new Date();
                    if (i === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                        day.classList.add('today');
                    }
                    
                    // Check if has appointment
                    const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                    const dayAppointments = appointments.filter(apt => apt.appointment_date === dateStr);
                    
                    if (dayAppointments.length > 0) {
                        day.classList.add('has-appointment');
                        day.dataset.date = dateStr;
                        
                        // Create popup for appointment IDs
                        const popup = document.createElement('div');
                        popup.className = 'appointment-popup';
                        popup.textContent = `Appointments: ${dayAppointments.map(apt => apt.appointment_id).join(', ')}`;
                        day.appendChild(popup);
                        
                        // Add click event to show/hide popup
                        day.addEventListener('click', () => {
                            // Hide all other popups
                            document.querySelectorAll('.appointment-popup').forEach(p => p.classList.remove('show'));
                            
                            // Show this popup
                            popup.classList.add('show');
                            
                            // Hide popup after 3 seconds
                            setTimeout(() => {
                                popup.classList.remove('show');
                            }, 3000);
                        });
                    }
                    
                    calendarDays.appendChild(day);
                }
                
                // Add days from next month
                const remainingDays = 42 - (startingDay + totalDays);
                for (let i = 1; i <= remainingDays; i++) {
                    const day = document.createElement('div');
                    day.className = 'calendar-day other-month';
                    day.textContent = i;
                    calendarDays.appendChild(day);
                }
            }
            
            prevMonthBtn.addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() - 1);
                generateCalendar();
            });
            
            nextMonthBtn.addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() + 1);
                generateCalendar();
            });
            
            // Initial calendar generation
            generateCalendar();
        });
    </script>
</body>
</html>

<?php
require_once APPROOT . '/views/ServiceProvider/footer_svp.php';
?>