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
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-top: 20px;
        }

        .approved-appointments-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .approved-appointments-table thead th {
            background: #f8fafc;
            color: #1e293b;
            font-weight: 600;
            padding: 16px 20px;
            text-align: left;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .approved-appointments-table tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid #f1f5f9;
        }

        .approved-appointments-table tbody tr:hover {
            background-color: #f8fafc;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .approved-appointments-table td {
            padding: 20px;
            vertical-align: middle;
            color: #334155;
        }

        .approved-appointments-table .id-cell {
            font-weight: 600;
            color: #2563eb;
        }

        .approved-appointments-table .datetime-cell {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .approved-appointments-table .date {
            font-weight: 600;
            color: #1e293b;
            font-size: 1rem;
        }

        .approved-appointments-table .time {
            color: #64748b;
            font-size: 0.9rem;
        }

        .approved-appointments-table .location-cell {
            font-weight: 500;
            color: #1e293b;
        }

        .approved-appointments-table .description-cell {
            color: #475569;
            line-height: 1.5;
        }

        .approved-appointments-table .hours-cell {
            font-weight: 500;
            color: #2563eb;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            overflow-y: auto;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            animation: modalFadeIn 0.3s ease-out;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-group input:focus, .form-group textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
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

        /* Approved Appointments Card Styles */
        .appointment-card.approved {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: 1px solid #e9ecef;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .appointment-card.approved:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .appointment-card.approved .card-header {
            background: #28a745;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 8px 8px 0 0;
        }

        .appointment-card.approved .status-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .appointment-card.approved .quotation-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .appointment-card.approved .card-body {
            padding: 20px;
        }

        .appointment-card.approved .info-group {
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .appointment-card.approved .info-group i {
            color: #28a745;
            font-size: 1.1rem;
            margin-top: 3px;
        }

        .appointment-card.approved .main-info {
            flex-direction: column;
            gap: 5px;
        }

        .appointment-card.approved .date {
            font-size: 1.1rem;
            font-weight: 600;
            color: #212529;
        }

        .appointment-card.approved .time {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .appointment-card.approved .location,
        .appointment-card.approved .description {
            color: #495057;
            font-size: 0.95rem;
            line-height: 1.4;
        }

        .appointment-card.approved .card-footer {
            padding: 15px;
            border-top: 1px solid #e9ecef;
            text-align: right;
        }

        .appointment-card.approved .btn-primary {
            background: #28a745;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.3s ease;
        }

        .appointment-card.approved .btn-primary:hover {
            background: #218838;
        }

        /* Responsive Table */
        @media (max-width: 768px) {
            .approved-appointments-table {
                display: block;
                overflow-x: auto;
            }
            
            .approved-appointments-table td {
                padding: 15px;
            }
        }

        /* Calendar Styles */
        .calendar-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            padding: 25px;
            width: 350px;
            flex-shrink: 0;
            border: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f1f5f9;
        }

        .calendar-header h2 {
            color: #1e293b;
            font-size: 1.4rem;
            font-weight: 700;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .calendar-nav-btn {
            background: #f8fafc;
            border: none;
            border-radius: 10px;
            padding: 10px 15px;
            cursor: pointer;
            color: #64748b;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .calendar-grid {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .calendar-weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            margin-bottom: 5px;
        }

        .calendar-weekdays div {
            text-align: center;
            font-weight: 700;
            color: #64748b;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 8px 0;
        }

        .calendar-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            font-size: 0.95rem;
            font-weight: 500;
            background: #f8fafc;
            border: 1px solid transparent;
            min-width: 40px;
            min-height: 40px;
            margin: 0;
        }

        .calendar-day:hover {
            background: #e2e8f0;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .calendar-day.today {
            background: #dbeafe;
            color: #1d4ed8;
            font-weight: 700;
            border: 2px solid #60a5fa;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.1);
        }

        .calendar-day.has-appointment {
            background: #dcfce7;
            color: #15803d;
            font-weight: 600;
            border: 2px solid #86efac;
            box-shadow: 0 4px 6px rgba(34, 197, 94, 0.1);
            position: relative;
        }

        .calendar-day.has-appointment::after {
            content: '';
            position: absolute;
            bottom: 6px;
            width: 6px;
            height: 6px;
            background: #15803d;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(34, 197, 94, 0.2);
        }

        .calendar-day.has-appointment .appointment-tooltip {
            position: absolute;
            bottom: -30px;
            left: 50%;
            transform: translateX(-50%);
            background: #15803d;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
            z-index: 10;
        }

        .calendar-day.has-appointment:hover .appointment-tooltip {
            opacity: 1;
        }

        .calendar-day.other-month {
            color: #94a3b8;
            background: #f1f5f9;
            opacity: 0.7;
        }

        .calendar-day.selected {
            background: #2563eb;
            color: white;
            font-weight: 700;
            border: 2px solid #60a5fa;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
            transform: scale(1.1);
            z-index: 1;
        }

        /* Animation for calendar day selection */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .calendar-day.selected {
            animation: pulse 0.3s ease;
        }

        /* Layout Styles */
        .approved-content-wrapper {
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }

        .table-container {
            flex: 1;
            min-width: 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .approved-content-wrapper {
                flex-direction: column;
            }
            
            .calendar-container {
                width: 100%;
                margin-bottom: 20px;
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
                                <button class="btn btn-danger" onclick="rejectAppointment(<?= $appointment->appointment_id ?>)">
                                    <i class="fas fa-times"></i> Reject
                                </button>
                            </div>
                        </div>
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
                                    <th>ID</th>
                                    <th>Description</th>
                                    <th>Location</th>
                                    <th>Date & Time</th>
                                    <th>Work Hours</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['approvedAppointments'] as $appointment): ?>
                                    <tr class="appointment-row" data-date="<?php echo $appointment->appointment_date; ?>">
                                        <td>
                                            <div class="id-cell">
                                                #<?php echo $appointment->appointment_id; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="description-cell">
                                                <?php echo htmlspecialchars($appointment->description); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="location-cell">
                                                <?php echo htmlspecialchars($appointment->location); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="datetime-cell">
                                                <div class="date"><?php echo date('F d, Y', strtotime($appointment->appointment_date)); ?></div>
                                                <div class="time"><?php echo $appointment->appointment_time; ?></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="hours-cell">
                                                <?php echo $appointment->work_hours ?? '0'; ?> hours
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
            document.getElementById('quotationModal').style.display = 'none';
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
                    showToast('Quotation created successfully!', 'success');
                    closeQuotationModal();
                    // Redirect to quotations tab after a short delay
                    setTimeout(() => {
                        window.location.href = '<?php echo URLROOT; ?>/ServiceProviderController/quotation';
                    }, 1000);
                } else {
                    showToast(data.message || 'Failed to create quotation', 'error');
                }
            })
            .catch(error => {
                showToast('An error occurred', 'error');
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
                        
                        // Create tooltip with appointment IDs
                        const tooltip = document.createElement('div');
                        tooltip.className = 'appointment-tooltip';
                        tooltip.textContent = `Appointments: ${dayAppointments.map(apt => apt.appointment_id).join(', ')}`;
                        day.appendChild(tooltip);
                    }
                    
                    // Add click event
                    day.addEventListener('click', () => {
                        if (day.classList.contains('has-appointment')) {
                            // Remove previous selection
                            document.querySelectorAll('.calendar-day.selected').forEach(el => {
                                el.classList.remove('selected');
                            });
                            document.querySelectorAll('.appointment-row.highlighted').forEach(el => {
                                el.classList.remove('highlighted');
                            });
                            
                            // Add new selection
                            day.classList.add('selected');
                            selectedDate = dateStr;
                            
                            // Highlight corresponding rows
                            appointmentRows.forEach(row => {
                                if (row.dataset.date === dateStr) {
                                    row.classList.add('highlighted');
                                    row.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                }
                            });
                        }
                    });
                    
                    calendarDays.appendChild(day);
                }
                
                // Add days from next month
                const remainingDays = 42 - (startingDay + totalDays); // 6 rows * 7 days
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