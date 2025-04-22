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
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/SVP/SVP_appointments.css">
</head>
<body>
    <div class="container">
        <!-- Tab Buttons -->
        <div class="tabs">
            <button class="tab-btn active" data-tab="pending-tab">Pending Appointments</button>
            <button class="tab-btn" data-tab="approved-tab">Approved Appointments</button>
        </div>

        <!-- Filter Section -->
        <style>
            .filters-container {
                display: flex;
                gap: 1.5rem;
                padding: 1.5rem;
                background: #f8f9fa;
                border-radius: 12px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
                margin-bottom: 2rem;
            }
            .search-bar {
                flex: 1;
                position: relative;
            }
            .search-bar input {
                width: 100%;
                padding: 12px 16px 12px 48px;
                border: 2px solid #e9ecef;
                border-radius: 8px;
                font-size: 1rem;
                background: white url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="%239299a6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>') no-repeat 16px center;
                background-size: 20px;
            }
            .search-bar input:focus {
                outline: none;
                border-color: #4dabf7;
                box-shadow: 0 0 0 3px rgba(77, 171, 247, 0.15);
            }
            .district-filter {
                position: relative;
                min-width: 200px;
            }
            .district-filter select {
                width: 100%;
                padding: 12px 16px;
                border: 2px solid #e9ecef;
                border-radius: 8px;
                font-size: 1rem;
                appearance: none;
                background: white url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="%239299a6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>') no-repeat right 16px center;
                background-size: 16px;
            }
            @media (max-width: 768px) {
                .filters-container {
                    flex-direction: column;
                }
            }
        </style>

        <!-- Pending Appointments -->
        <div id="pending-tab" class="tab-content active">
            <div class="filters-container">
                <div class="search-bar">
                    <input type="text" id="search-input" placeholder="Search by description or location...">
                </div>
                <div class="district-filter">
                    <select id="district-select">
                        <option value="">All Districts</option>
                    </select>
                </div>
            </div>

            <div class="appointments-grid" id="pending-appointments-grid">
                <?php foreach ($data['pendingAppointments'] as $appointment): ?>
                    <div class="appointment-card"
                         id="appointment-<?= $appointment->appointment_id ?>"
                         data-description="<?= strtolower($appointment->description) ?>"
                         data-location="<?= strtolower($appointment->location) ?>">
                        <div class="card-header">
                            <span class="service-category"><?= $appointment->service_category ?></span>
                            <span class="appointment-id">ID: <?= $appointment->appointment_id ?></span>
                        </div>
                        <div class="card-content">
                            <div class="info-row">
                                <span><?= $appointment->appointment_date ?></span>
                                <span><?= $appointment->appointment_time ?></span>
                            </div>
                            <div class="info-row">
                                <span><?= $appointment->location ?></span>
                            </div>
                            <div class="info-row">
                                <span><?= $appointment->description ?></span>
                            </div>
                            <div class="card-actions">
                                <button class="btn btn-primary" onclick="approveAppointment(<?= $appointment->appointment_id ?>)">Approve</button>
                                <button class="btn btn-outline" onclick="cancelAppointment(<?= $appointment->appointment_id ?>)">Cancel</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Approved Appointments -->
        <div id="approved-tab" class="tab-content">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Appointment Date</th>
                            <th>Approved Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['approvedAppointments'] as $appointment): ?>
                            <tr>
                                <td><?= $appointment->appointment_id ?></td>
                                <td><?= $appointment->customer_id ?></td>
                                <td><?= $appointment->appointment_date ?></td>
                                <td><?= $appointment->updated_at ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Confirm Modal -->
    <div id="confirm-modal" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.4); z-index: 10000; align-items: center; justify-content: center;">
        <div style="background: white; padding: 20px 30px; border-radius: 10px; text-align: center; font-family: Inter, sans-serif;">
            <p id="confirm-message">Are you sure?</p>
            <button onclick="handleConfirm(true)" style="background-color: #28a745; color: white; padding: 8px 16px; border: none; border-radius: 5px; margin-right: 10px;">Yes</button>
            <button onclick="handleConfirm(false)" style="background-color: #dc3545; color: white; padding: 8px 16px; border: none; border-radius: 5px;">No</button>
        </div>
    </div>

    <script>
        // Tabs
        document.querySelectorAll('.tab-btn').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

                button.classList.add('active');
                document.getElementById(button.dataset.tab).classList.add('active');
            });
        });

        // Approve / Cancel Handlers
        function approveAppointment(id) {
            customConfirm('Are you sure you want to approve this appointment?', confirmed => {
                if (confirmed) {
                    fetch('<?php echo URLROOT; ?>/ServiceProviderController/approveAppointment', {
                        method: 'POST',
                        body: new URLSearchParams({ id })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) showToast('Appointment approved!');
                        else showToast('Error approving appointment', 'error');
                        setTimeout(() => location.reload(), 300);
                    });
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

        // Toast (implement your own or add a placeholder)
        function showToast(msg, type = 'success') {
            alert(msg); // Placeholder
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

                const matchesSearch = !term || desc.includes(term) || loc.includes(term);
                const matchesDistrict = !district || loc.includes(district);

                card.style.display = (matchesSearch && matchesDistrict) ? 'block' : 'none';
            });
        }

        document.getElementById('search-input').addEventListener('input', filterAppointments);
        document.getElementById('district-select').addEventListener('change', filterAppointments);
    </script>
</body>
</html>


<?php
require_once APPROOT . '/views/ServiceProvider/footer_svp.php';
?>