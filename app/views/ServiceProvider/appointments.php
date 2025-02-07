<?php
require_once APPROOT . '/views/ServiceProvider/navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background);
            color: var(--text);
            line-height: 1.5;
        } */

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .header h1 {
            font-size: 2rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .header svg {
            color: var(--primary);
        }

        .tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .tab-btn {
            flex: 1;
            padding: 0.75rem;
            border: 1px solid var(--border);
            background: var(--card-background);
            color: var(--text);
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .tab-btn:hover {
            background: var(--background);
        }

        .tab-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .appointments-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .appointment-card {
            background: var(--card-background);
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: var(--shadow);
            transition: all 0.2s;
        }

        .appointment-card:hover {
            box-shadow: var(--shadow-hover);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1rem;
        }

        .service-category {
            font-weight: 600;
            font-size: 1.125rem;
        }

        .appointment-id {
            background: var(--background);
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .card-content {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .info-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }

        .info-row svg {
            color: var(--primary);
            flex-shrink: 0;
        }

        .card-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .btn {
            flex: 1;
            padding: 0.5rem;
            border-radius: 0.375rem;
            border: 1px solid transparent;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.2s;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
        }

        .btn-outline {
            border-color: var(--border);
            background: transparent;
        }

        .btn-outline:hover {
            background: var(--background);
        }

        .table-container {
            background: var(--card-background);
            border-radius: 0.5rem;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        th {
            background: var(--background);
            font-weight: 600;
        }

        tr:hover {
            background: var(--background);
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .appointments-grid {
                grid-template-columns: 1fr;
            }

            .table-container {
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- <header class="header">
            <h1>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 7h-3a2 2 0 0 1-2-2V2"></path>
                    <path d="M9 2v3a2 2 0 0 1-2 2H4"></path>
                    <path d="M20 17h-3a2 2 0 0 0-2 2v3"></path>
                    <path d="M9 22v-3a2 2 0 0 0-2-2H4"></path>
                    <rect width="16" height="16" x="4" y="4"></rect>
                </svg>
                Appointments Dashboard
            </h1>
        </header> -->

        <div class="tabs">
            <button class="tab-btn active" data-tab="pending">Pending Appointments</button>
            <button class="tab-btn" data-tab="approved">Approved Appointments</button>
        </div>

        <div id="pending-appointments" class="tab-content active">
            <div class="appointments-grid"></div>
        </div>

        <div id="approved-appointments" class="tab-content">
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
                    <tbody id="approved-table-body"></tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Data
        const pendingAppointments = [
            {
                id: 10,
                customerId: 2,
                customerName: "Vineth Perera",
                serviceCategory: "Plumbing",
                description: "Unclog the bathroom drain",
                date: "2024-12-04",
                time: "11:30:00",
                location: "27 Lake Drive, Matara",
                status: "pending"
            },
            {
                id: 11,
                customerId: 4,
                customerName: "Janith Silva",
                serviceCategory: "Electrical",
                description: "Fix power socket",
                date: "2024-12-05",
                time: "14:00:00",
                location: "120 Beach Road, Galle",
                status: "pending"
            },
            {
                id: 12,
                customerId: 5,
                customerName: "Nimal Perera",
                serviceCategory: "Carpentry",
                description: "Fix door",
                date: "2024-12-06",
                time: "09:00:00",
                location: "45 Hill Street, Colombo",
                status: "pending"
            },
            {
                id: 13,
                customerId: 6,
                customerName: "Saman Kumara",
                serviceCategory: "Painting",
                description: "Paint living room",
                date: "2024-12-07",
                time: "10:00:00",
                location: "78 Flower Road, Kandy",
                status: "pending"
            },
            {
                id: 14,
                customerId: 7,
                customerName: "Ruwan Fernando",
                serviceCategory: "Cleaning",
                description: "Clean windows",
                date: "2024-12-08",
                time: "13:00:00",
                location: "90 Park Avenue, Negombo",
                status: "pending"
            }
        ];

        const approvedAppointments = [
            {
                id: 3,
                customerId: 1,
                customerName: "Kasun Fernando",
                appointmentDate: "2024-12-02 09:00:00",
                approvedDate: "2024-11-28"
            },
            {
                id: 7,
                customerId: 3,
                customerName: "Nimasha Dilrukshi",
                appointmentDate: "2024-12-03 15:00:00",
                approvedDate: "2024-11-29"
            },
            {
                id: 10,
                customerId: 4,
                customerName: "Amila Perera",
                appointmentDate: "2024-12-04 11:00:00",
                approvedDate: "2024-11-30"
            },
            {
                id: 13,
                customerId: 5,
                customerName: "Ruwan Silva",
                appointmentDate: "2024-12-05 14:00:00",
                approvedDate: "2024-12-01"
            },
            {
                id: 17,
                customerId: 6,
                customerName: "Chathura Jayasinghe",
                appointmentDate: "2024-12-06 10:00:00",
                approvedDate: "2024-12-02"
            }
        ];

        // Application Logic
        document.addEventListener('DOMContentLoaded', () => {
            // Tab switching functionality
            const tabs = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => t.classList.remove('active'));
                    tabContents.forEach(c => c.classList.remove('active'));
                    tab.classList.add('active');
                    document.getElementById(`${tab.dataset.tab}-appointments`).classList.add('active');
                });
            });

            // Render pending appointments
            const appointmentsGrid = document.querySelector('.appointments-grid');
            
            pendingAppointments.forEach(appointment => {
                const card = document.createElement('div');
                card.className = 'appointment-card';
                card.innerHTML = `
                    <div class="card-header">
                        <span class="service-category">${appointment.serviceCategory}</span>
                        <span class="appointment-id">ID: ${appointment.id}</span>
                    </div>
                    <div class="card-content">
                        <div class="info-row">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <span>${appointment.customerName}</span>
                            <span style="color: var(--text-secondary)">#${appointment.customerId}</span>
                        </div>
                        <div class="info-row">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
                                <line x1="16" x2="16" y1="2" y2="6"></line>
                                <line x1="8" x2="8" y1="2" y2="6"></line>
                                <line x1="3" x2="21" y1="10" y2="10"></line>
                            </svg>
                            <span>${appointment.date}</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <span>${appointment.time}</span>
                        </div>
                        <div class="info-row">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <span style="color: var(--text-secondary)">${appointment.location}</span>
                        </div>
                        <div class="info-row">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                            </svg>
                            <span style="color: var(--text-secondary)">${appointment.description}</span>
                        </div>
                        <div class="card-actions">
                            <button class="btn btn-primary" onclick="approveAppointment(${appointment.id})">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                                Approve
                            </button>
                            <button class="btn btn-outline" onclick="cancelAppointment(${appointment.id})">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="15" x2="9" y1="9" y2="15"></line>
                                    <line x1="9" x2="15" y1="9" y2="15"></line>
                                </svg>
                                Cancel
                            </button>
                        </div>
                    </div>
                `;
                appointmentsGrid.appendChild(card);
            });

            // Render approved appointments
            const approvedTableBody = document.getElementById('approved-table-body');
            
            approvedAppointments.forEach(appointment => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${appointment.id}</td>
                    <td>${appointment.customerName}</td>
                    <td>${appointment.appointmentDate}</td>
                    <td>${appointment.approvedDate}</td>
                `;
                approvedTableBody.appendChild(row);
            });
        });

        function approveAppointment(id) {
            alert(`Approving appointment ${id}`);
            // Add your approval logic here
        }

        function cancelAppointment(id) {
            alert(`Canceling appointment ${id}`);
            // Add your cancellation logic here
        }
    </script>
</body>
</html>

