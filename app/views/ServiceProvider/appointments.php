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

        /* Updated Table Styles */
        .table-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: auto;
            margin-top: 20px;
            max-width: 100%;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .approved-appointments-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.9rem;
            background: white;
            border-radius: 16px;
            overflow: hidden;
        }

        .approved-appointments-table thead th {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.9) 0%, rgba(29, 78, 216, 0.9) 100%);
            color: white;
            font-weight: 600;
            padding: 16px;
            text-align: left;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
            position: sticky;
            top: 0;
            z-index: 1;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
        }

        .approved-appointments-table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f1f5f9;
        }

        .approved-appointments-table tbody tr:hover {
            background-color: #f8fafc;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .approved-appointments-table td {
            padding: 16px;
            vertical-align: middle;
            color: #334155;
            white-space: nowrap;
        }

        .approved-appointments-table .id-cell {
            font-weight: 600;
            color: #2563eb;
            font-size: 0.9rem;
            background: rgba(37, 99, 235, 0.1);
            padding: 8px 12px;
            border-radius: 6px;
            display: inline-block;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.1);
        }

        .approved-appointments-table .customer-cell {
            display: flex;
            flex-direction: column;
            gap: 8px;
            background: #f8fafc;
            padding: 12px;
            border-radius: 8px;
        }

        .approved-appointments-table .customer-name,
        .approved-appointments-table .customer-contact {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #1e293b;
        }

        .approved-appointments-table .customer-name i,
        .approved-appointments-table .customer-contact i {
            color: #2563eb;
            font-size: 0.9rem;
        }

        .approved-appointments-table .datetime-cell {
            display: flex;
            flex-direction: column;
            gap: 8px;
            min-width: 150px;
            background: #f8fafc;
            padding: 12px;
            border-radius: 8px;
        }

        .approved-appointments-table .date,
        .approved-appointments-table .time {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .approved-appointments-table .date {
            font-weight: 600;
            color: #1e293b;
            font-size: 0.9rem;
        }

        .approved-appointments-table .time {
            color: #64748b;
            font-size: 0.85rem;
            background: rgba(37, 99, 235, 0.1);
            padding: 6px 10px;
            border-radius: 6px;
        }

        .approved-appointments-table .details-cell {
            display: flex;
            flex-direction: column;
            gap: 12px;
            min-width: 300px;
            max-width: 300px;
            padding: 12px;
            background: #f8fafc;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .approved-appointments-table .description,
        .approved-appointments-table .quotation {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            color: #475569;
            font-size: 0.9rem;
            line-height: 1.4;
            word-break: break-word;
            white-space: normal;
        }

        .approved-appointments-table .description i,
        .approved-appointments-table .quotation i {
            color: #2563eb;
            font-size: 0.9rem;
            margin-top: 3px;
            flex-shrink: 0;
        }

        .approved-appointments-table .description span,
        .approved-appointments-table .quotation span {
            flex: 1;
        }

        .approved-appointments-table .location-cell {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 150px;
            max-width: 150px;
            padding: 12px;
            background: #f8fafc;
            border-radius: 8px;
            color: #475569;
            font-size: 0.85rem;
            word-break: break-word;
            white-space: normal;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .approved-appointments-table .location-cell i {
            color: #2563eb;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .approved-appointments-table .location-cell span {
            flex: 1;
            line-height: 1.3;
        }

        .approved-appointments-table .work-details-cell {
            display: flex;
            flex-direction: column;
            gap: 8px;
            min-width: 150px;
            background: #f8fafc;
            padding: 12px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .approved-appointments-table .hours,
        .approved-appointments-table .cost {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .approved-appointments-table .hours {
            background: rgba(37, 99, 235, 0.1);
            color: #2563eb;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.1);
        }

        .approved-appointments-table .cost {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
            box-shadow: 0 2px 4px rgba(34, 197, 94, 0.1);
        }

        .approved-appointments-table .hours i,
        .approved-appointments-table .cost i {
            font-size: 0.9rem;
        }

        /* Scrollbar Styling */
        .table-container::-webkit-scrollbar {
            height: 8px;
            width: 8px;
        }

        .table-container::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        .table-container::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .table-container::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Responsive Table */
        @media (max-width: 768px) {
            .approved-appointments-table {
                display: block;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            
            .approved-appointments-table td {
                padding: 12px;
            }
            
            .approved-appointments-table thead th {
                padding: 12px;
            }
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

        /* Calendar Styles */
        .calendar-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 10px;
            width: 240px;
            flex-shrink: 0;
            border: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 1;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 1px solid #f1f5f9;
        }

        .calendar-header h2 {
            color: #1e293b;
            font-size: 0.9rem;
            font-weight: 600;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .calendar-nav-btn {
            background: #f8fafc;
            border: none;
            border-radius: 4px;
            padding: 4px 8px;
            cursor: pointer;
            color: #64748b;
            transition: all 0.3s ease;
            font-size: 0.8rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .calendar-grid {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .calendar-weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
            margin-bottom: 1px;
        }

        .calendar-weekdays div {
            text-align: center;
            font-weight: 600;
            color: #64748b;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 2px 0;
        }

        .calendar-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            font-size: 0.75rem;
            font-weight: 500;
            background: #f8fafc;
            border: 1px solid transparent;
            min-width: 25px;
            min-height: 25px;
            margin: 0;
            z-index: 1;
        }

        .calendar-day:hover {
            background: #e2e8f0;
            transform: translateY(-1px);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .calendar-day.today {
            background: #dbeafe;
            color: #1d4ed8;
            font-weight: 600;
            border: 1px solid #60a5fa;
            box-shadow: 0 1px 2px rgba(37, 99, 235, 0.1);
        }

        .calendar-day.has-appointment {
            background: #dcfce7;
            color: #15803d;
            font-weight: 600;
            border: 1px solid #86efac;
            box-shadow: 0 1px 2px rgba(34, 197, 94, 0.1);
            position: relative;
            cursor: pointer;
            z-index: 2;
        }

        .calendar-day.has-appointment::after {
            content: '';
            position: absolute;
            bottom: 3px;
            width: 3px;
            height: 3px;
            background: #15803d;
            border-radius: 50%;
            box-shadow: 0 1px 2px rgba(34, 197, 94, 0.2);
        }

        .calendar-day.other-month {
            color: #94a3b8;
            background: #f1f5f9;
            opacity: 0.7;
        }

        .calendar-day.selected {
            background: #2563eb;
            color: white;
            font-weight: 600;
            border: 1px solid #60a5fa;
            box-shadow: 0 1px 2px rgba(37, 99, 235, 0.2);
            transform: scale(1.05);
            z-index: 1;
        }

        .appointment-popup {
            position: absolute;
            bottom: -35px;
            left: 50%;
            transform: translateX(-50%);
            background: #15803d;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.75rem;
            white-space: nowrap;
            z-index: 100;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
            display: none;
            pointer-events: none;
        }

        .appointment-popup::after {
            content: '';
            position: absolute;
            top: -6px;
            left: 50%;
            transform: translateX(-50%);
            border-width: 0 6px 6px 6px;
            border-style: solid;
            border-color: transparent transparent #15803d transparent;
        }

        .appointment-popup.show {
            display: block;
            animation: fadeIn 0.2s ease;
        }

        @keyframes fadeIn {
            from { 
                opacity: 0; 
                transform: translate(-50%, 5px);
            }
            to { 
                opacity: 1; 
                transform: translate(-50%, 0);
            }
        }

        /* Layout Styles */
        .approved-content-wrapper {
            display: flex;
            flex-direction: column;
            gap: 20px;
            align-items: center;
        }

        .calendar-container {
            width: 100%;
            max-width: 280px;
            margin: 0 auto;
        }

        .table-container {
            width: 100%;
            margin-top: 20px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .approved-content-wrapper {
                gap: 15px;
            }
            
            .calendar-container {
                width: 100%;
                max-width: none;
            }
        }

        /* Pending Appointments Cards */
        .pending-appointments {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .appointment-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border-left: 4px solid var(--primary);
            position: relative;
            overflow: hidden;
        }

        

        .appointment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .appointment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(37, 99, 235, 0.1);
        }

        .appointment-id {
            background-color: rgba(37, 99, 235, 0.1);
            color: var(--primary);
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .appointment-date {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .appointment-details {
            margin-bottom: 15px;
        }

        .appointment-details p {
            margin: 8px 0;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .appointment-details i {
            color: var(--primary);
            width: 20px;
        }

        .appointment-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .action-btn {
            flex: 1;
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .approve-btn {
            background-color: rgba(37, 99, 235, 0.1);
            color: var(--primary);
        }

        .approve-btn:hover {
            background-color: var(--primary);
            color: white;
        }

        .reject-btn {
            background-color: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .reject-btn:hover {
            background-color: #ef4444;
            color: white;
        }

        .appointment-status {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            background-color: rgba(37, 99, 235, 0.1);
            color: var(--primary);
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
                                    <th>Date & Time</th>
                                    <th>Details</th>
                                    <th>Location</th>
                                    <th>Cost</th>
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
                                            <div class="datetime-cell">
                                                <div class="date">
                                                    <i class="fas fa-calendar"></i>
                                                    <?php echo date('F d, Y', strtotime($appointment->appointment_date)); ?>
                                                </div>
                                                <div class="time">
                                                    <i class="fas fa-clock"></i>
                                                    <?php echo $appointment->appointment_time; ?>
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
                                            <div class="location-cell">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <span><?php echo htmlspecialchars($appointment->location); ?></span>
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