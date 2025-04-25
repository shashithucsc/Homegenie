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
    <style>
        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --background: #f9fafb;
            --card-background: #ffffff;
            --text: #111827;
            --text-secondary: #6b7280;
            --border: #e5e7eb;
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-hover: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background);
            color: var(--text);
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Header Section */
        .page-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .page-header h1 {
            color: var(--primary);
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .page-header p {
            color: var(--text-secondary);
            font-size: 1.1rem;
        }

        /* Tabs */
        .tabs {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            border-bottom: 2px solid var(--border);
            padding-bottom: 10px;
        }

        .tab-btn {
            padding: 12px 24px;
            border: none;
            background: none;
            color: var(--text-secondary);
            font-weight: 600;
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
        }

        .tab-btn.active {
            color: var(--primary);
        }

        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: var(--primary);
        }

        /* Filter Section */
        .filters-container {
            background: var(--card-background);
            padding: 20px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .search-bar {
            flex: 1;
            position: relative;
        }

        .search-bar input {
            width: 100%;
            padding: 12px 16px 12px 40px;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .search-bar input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .search-bar i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
        }

        .district-filter {
            min-width: 200px;
        }

        .district-filter select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-size: 1rem;
            appearance: none;
            background: var(--card-background) url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="%236b7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>') no-repeat right 16px center;
            background-size: 16px;
        }

        /* Appointment Cards */
        .appointments-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .appointment-card {
            background: var(--card-background);
            border-radius: 12px;
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .appointment-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .card-header {
            background: var(--primary);
            color: var(--card-background);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .service-category {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .appointment-id {
            background: rgba(255,255,255,0.2);
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .card-content {
            padding: 20px;
        }

        .info-row {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-row i {
            color: var(--primary);
            width: 20px;
            text-align: center;
        }

        .card-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: var(--primary);
            color: var(--card-background);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
        }

        .btn-outline {
            background: var(--card-background);
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-outline:hover {
            background: var(--background);
        }

        /* Approved Appointments Table */
        .table-container {
            background: var(--card-background);
            border-radius: 12px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: var(--primary);
            color: var(--card-background);
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid var(--border);
        }

        tr:hover {
            background: var(--background);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-content {
            background: var(--card-background);
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            max-width: 400px;
            width: 90%;
        }

        .modal-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }

        /* Tab Content */
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .filters-container {
                flex-direction: column;
            }
            
            .district-filter {
                width: 100%;
            }
            
            .appointments-grid {
                grid-template-columns: 1fr;
            }
        }

        .appointment-card {
            background: var(--card-background);
            border-radius: 12px;
            box-shadow: var(--shadow);
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }

        .appointment-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border);
        }

        .card-header h3 {
            color: var(--primary);
            margin: 0;
            font-size: 1.2rem;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .status-badge.approved {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .card-body {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .info-group {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .info-group i {
            color: var(--primary);
            font-size: 1.2rem;
            margin-top: 5px;
        }

        .info-group label {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 5px;
            display: block;
        }

        .info-group p {
            margin: 0;
            color: var(--text);
            font-size: 1rem;
            line-height: 1.4;
        }

        .card-footer {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid var(--border);
            text-align: right;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
        }

        .no-appointments {
            text-align: center;
            padding: 40px;
            background: var(--card-background);
            border-radius: 12px;
            box-shadow: var(--shadow);
        }

        .no-appointments i {
            font-size: 3rem;
            color: var(--text-secondary);
            margin-bottom: 20px;
        }

        .no-appointments p {
            color: var(--text-secondary);
            font-size: 1.1rem;
            margin: 0;
        }

        @media (max-width: 768px) {
            .card-body {
                grid-template-columns: 1fr;
            }
            
            .info-group {
                flex-direction: column;
                gap: 5px;
            }
            
            .info-group i {
                margin-top: 0;
            }
        }
    </style>
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
            <div class="appointments-grid" id="pending-appointments-grid">
                <?php foreach ($data['pendingAppointments'] as $appointment): ?>
                    <div class="appointment-card"
                         id="appointment-<?= $appointment->appointment_id ?>"
                         data-description="<?= strtolower($appointment->description) ?>"
                         data-location="<?= strtolower($appointment->location) ?>">
                        <div class="card-header">
                            <!-- <span class="service-category"><?= $appointment->service_category ?></span> -->
                            <span class="appointment-id">ID: <?= $appointment->appointment_id ?></span>
                        </div>
                        <div class="card-content">
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
                            <div class="card-actions">
                                <button class="btn btn-primary" onclick="approveAppointment(<?= $appointment->appointment_id ?>)">
                                    <i class="fas fa-check"></i> Approve
                                </button>
                                <button class="btn btn-outline" onclick="cancelAppointment(<?= $appointment->appointment_id ?>)">
                                    <i class="fas fa-times"></i> Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Approved Appointments -->
        <div id="approved-tab" class="tab-content">
            <div class="appointments-grid">
                <?php if (!empty($data['approvedAppointments'])): ?>
                    <?php foreach ($data['approvedAppointments'] as $appointment): ?>
                        <div class="appointment-card approved">
                            <div class="card-header">
                                <h3>Appointment #<?php echo $appointment->appointment_id; ?></h3>
                                <span class="status-badge approved">Approved</span>
                            </div>
                            
                            <div class="card-body">
                                <div class="info-group">
                                    <i class="fas fa-user"></i>
                                    <div>
                                        <label>Customer ID</label>
                                        <p><?php echo htmlspecialchars($appointment->customer_id); ?></p>
                                    </div>
                                </div>
                                
                                <!-- <div class="info-group">
                                    <i class="fas fa-tasks"></i>
                                    <div>
                                        <label>Service Category</label>
                                        <p><?php echo htmlspecialchars($appointment->service_category); ?></p>
                                    </div>
                                </div> -->
                                
                                <div class="info-group">
                                    <i class="fas fa-comment"></i>
                                    <div>
                                        <label>Description</label>
                                        <p><?php echo htmlspecialchars($appointment->description); ?></p>
                                    </div>
                                </div>
                                
                                <div class="info-group">
                                    <i class="fas fa-calendar"></i>
                                    <div>
                                        <label>Appointment Date</label>
                                        <p><?php echo date('F d, Y', strtotime($appointment->appointment_date)); ?></p>
                                    </div>
                                </div>
                                
                                <div class="info-group">
                                    <i class="fas fa-clock"></i>
                                    <div>
                                        <label>Appointment Time</label>
                                        <p><?php echo htmlspecialchars($appointment->appointment_time); ?></p>
                                    </div>
                                </div>
                                
                                <div class="info-group">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <div>
                                        <label>Location</label>
                                        <p><?php echo htmlspecialchars($appointment->location); ?></p>
                                    </div>
                                </div>
                                
                                <div class="info-group">
                                    <i class="fas fa-info-circle"></i>
                                    <div>
                                        <label>Status</label>
                                        <p><?php echo htmlspecialchars($appointment->status); ?></p>
                                    </div>
                                </div>
                                
                                <div class="info-group">
                                    <i class="fas fa-calendar-plus"></i>
                                    <div>
                                        <label>Created At</label>
                                        <p><?php echo date('F d, Y H:i', strtotime($appointment->created_at)); ?></p>
                                    </div>
                                </div>
                                
                                <div class="info-group">
                                    <i class="fas fa-calendar-check"></i>
                                    <div>
                                        <label>Last Updated</label>
                                        <p><?php echo date('F d, Y H:i', strtotime($appointment->updated_at)); ?></p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-footer">
                                <button class="btn btn-primary" onclick="generateQuotation(<?php echo $appointment->appointment_id; ?>)">
                                    <i class="fas fa-file-invoice"></i> Generate Quotation
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-appointments">
                        <i class="fas fa-calendar-check"></i>
                        <p>No approved appointments found</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Confirm Modal -->
    <div id="confirm-modal" class="modal">
        <div class="modal-content">
            <p id="confirm-message">Are you sure?</p>
            <div class="modal-buttons">
                <button class="btn btn-primary" onclick="handleConfirm(true)">
                    <i class="fas fa-check"></i> Yes
                </button>
                <button class="btn btn-outline" onclick="handleConfirm(false)">
                    <i class="fas fa-times"></i> No
                </button>
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

        // Approve / Cancel Handlers
        function approveAppointment(id) {
            customConfirm('Do you want to create a quotation for this appointment?', confirmed => {
                if (confirmed) {
                    fetch('<?php echo URLROOT; ?>/ServiceProviderController/approveAppointment', {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: new URLSearchParams({ id })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = data.redirect;
                        } else {
                            showToast('Error creating quotation', 'error');
                        }
                    });
                } else {
                    showToast('Create quotation to accept the appointment.', 'info');
                }
            });
        }

        function cancelAppointment(id) {
            customConfirm('Are you sure you want to cancel this appointment?', confirmed => {
                if (confirmed) {
                    fetch('<?php echo URLROOT; ?>/ServiceProviderController/cancelAppointment', {
                        method: 'POST',
                        body: new URLSearchParams({ id })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) showToast('Appointment canceled!');
                        else showToast('Error canceling appointment', 'error');
                        setTimeout(() => location.reload(), 300);
                    });
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

        function generateQuotation(appointmentId) {
            window.location.href = '<?php echo URLROOT; ?>/ServiceProviderController/quotationAdd?appointment_id=' + appointmentId;
        }
    </script>
</body>
</html>

<?php
require_once APPROOT . '/views/ServiceProvider/footer_svp.php';
?>