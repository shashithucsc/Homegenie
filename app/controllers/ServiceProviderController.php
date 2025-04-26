<?php
class ServiceProviderController extends Controller
{

    private $QuotationSVPModel;
    private $ProfileSVPModel;
    private $AppointmentSVPModel;
    private $db;


    public function __construct()
    {
        $this->QuotationSVPModel = $this->model('QuotationSVPModel');
        $this->ProfileSVPModel = $this->model('ProfileSVPModel');
        $this->AppointmentSVPModel = $this->model('AppointmentSVPModel');
        $this->db = new Database();
    }

    public function index()
    {
        // Get the logged-in service provider's ID
        $service_provider_id = $_SESSION['user_id'];

        // Get service provider's hourly rate
        $this->db->query('SELECT hourly_rate FROM service_providers WHERE provider_id = :provider_id');
        $this->db->bind(':provider_id', $service_provider_id);
        $hourlyRate = $this->db->single()->hourly_rate;

        // Get pending appointments
        $pendingAppointments = $this->AppointmentSVPModel->getPendingAppointments($service_provider_id);

        // Get approved appointments with customer and quotation details
        $this->db->query('
            SELECT 
                a.appointment_id,
                a.customer_id,
                a.description,
                a.appointment_date,
                a.appointment_time,
                a.location,
                CONCAT(u.first_name, " ", u.last_name) as customer_name,
                u.contact_number,
                q.quotation_details,
                q.work_hours,
                q.cost
            FROM appointments a
            JOIN quotations q ON a.appointment_id = q.appointment_id
            JOIN users u ON a.customer_id = u.user_id
            WHERE q.service_provider_id = :service_provider_id 
            AND q.status = "Approved"
            ORDER BY a.appointment_date DESC, a.appointment_time DESC
        ');
        $this->db->bind(':service_provider_id', $service_provider_id);
        $approvedAppointments = $this->db->resultSet();

        // Pass the data to the view
        $this->view('ServiceProvider/appointments', [
            'pendingAppointments' => $pendingAppointments,
            'approvedAppointments' => $approvedAppointments,
            'hourlyRate' => $hourlyRate
        ]);
    }

    public function getAppointmentDetails($appointment_id)
    {
        $appointment = $this->AppointmentSVPModel->getAppointmentById($appointment_id);
        
        if ($appointment) {
            echo json_encode([
                'success' => true,
                'appointment' => $appointment
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Appointment not found'
            ]);
        }
    }

    public function rejectAppointment()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $appointment_id = $_POST['id'];
            
            $result = $this->AppointmentSVPModel->rejectAppointment($appointment_id);
            
            if ($result) {
                // Simply redirect back to appointments page
                header('Location: ' . URLROOT . '/ServiceProviderController/appointments');
                exit();
            } else {
                // Simply redirect back to appointments page
                header('Location: ' . URLROOT . '/ServiceProviderController/appointments');
                exit();
            }
        }
    }

    public function createQuotation()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'appointment_id' => $_POST['appointment_id'],
                'service_provider_id' => $_POST['service_provider_id'],
                'quotation_details' => $_POST['quotation_details'],
                'work_hours' => $_POST['work_hours'],
                'cost' => $_POST['cost']
            ];

            // Create quotation
            if ($this->QuotationSVPModel->createQuotation($data)) {
                // Update appointment status to approved
                if ($this->AppointmentSVPModel->approveAppointment($data['appointment_id'])) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Quotation created and appointment approved successfully'
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to update appointment status'
                    ]);
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to create quotation'
                ]);
            }
        }
    }

    // Method to approve an appointment
    public function approveAppointment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $appointmentId = $_POST['id'];
            
            // Start session if not already started
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            
            // Store the appointment ID in session
            $_SESSION['pending_quotation_appointment_id'] = $appointmentId;
            
            // Check if this is an AJAX request
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                // Return JSON response for AJAX
                echo json_encode(['success' => true, 'redirect' => URLROOT . '/ServiceProviderController/quotationAdd']);
                exit();
            } else {
                // Regular request, redirect
                header('Location: ' . URLROOT . '/ServiceProviderController/quotationAdd');
                exit();
            }
        }
    }

    // Method to cancel an appointment
    public function cancelAppointment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $appointmentId = $_POST['id'];

            $result = $this->AppointmentSVPModel->cancelAppointment($appointmentId);
            echo json_encode($result);  // Send back success/failure response
        }
    }

    public function support()
    {
        $this->view('ServiceProvider/support');
    }


    public function quotation()
    {
        $service_provider_id = $_SESSION['user_id'];
        // Fetch all quotations for the service provider
        $results = $this->QuotationSVPModel->getAllQuotationslist($service_provider_id);
        $this->view('ServiceProvider/quotations', data: $results);
    }

    public function quotationAdd()
    {
        $this->view('ServiceProvider/quotationAdd');
    }

    public function SubmittedQuotations()
    {
        $service_provider_id = $_SESSION['user_id'];
        $results = $this->QuotationSVPModel->getAllQuotationslist($service_provider_id);
        $this->view('ServiceProvider/SubmittedQuotations', data: $results);
    }

    public function quoteAdd()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize and trim input
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Get form data
            $appointment_id = trim($_POST['appointment_id']);
            $quotation_details = trim($_POST['quotation_details']);
            $work_hours = trim($_POST['work_hours']);
            $cost = trim($_POST['cost']);

            // Get the service_provider_id from the appointment
            $appointment = $this->QuotationSVPModel->getAppointmentById($appointment_id);

            // Check if the appointment was found
            if (!$appointment) {
                die("Appointment not found.");
            }

            $service_provider_id = $appointment->service_provider_id;

            // Prepare the data for the quotation
            $data = [
                'appointment_id' => $appointment_id,
                'service_provider_id' => $service_provider_id,
                'quotation_details' => $quotation_details,
                'work_hours' => $work_hours,
                'cost' => $cost,
                'status' => 'Pending'
            ];

            // Call the model to add the quotation
            if ($this->QuotationSVPModel->addQuotation($data)) {
                // Update the appointment status to 'approved'
                $this->AppointmentSVPModel->approveAppointment($appointment_id);
                
                // Clear the session variable
                unset($_SESSION['pending_quotation_appointment_id']);
                
                // On success, redirect to quotations page
                header('Location: ' . URLROOT . '/ServiceProviderController/quotation');
                exit();
            } else {
                die("Error: Unable to add quotation.");
            }
        }
    }

    public function updateQuotation($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $quotation_details = trim($_POST['quotation_details']);
            $work_hours = trim($_POST['work_hours']);
            $cost = trim($_POST['cost']);

            $quotationModel = $this->model('QuotationSVPModel');

            if ($quotationModel->updateQuotation($id, $quotation_details, $work_hours, $cost)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }


    public function deleteQuotation($quotation_id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->QuotationSVPModel->deleteQuotation($quotation_id)) {
                header('Location: ' . URLROOT . '/ServiceProviderController/SubmittedQuotations?message=Quotation deleted successfully');
                exit();
            } else {
                header('Location: ' . URLROOT . '/ServiceProviderController/SubmittedQuotations?error=Failed to delete quotation');
                exit();
            }
        } else {
            header('Location: ' . URLROOT . '/ServiceProviderController/SubmittedQuotations?error=Invalid request');
            exit();
        }
    }

    public function profile()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }

        $service_provider_id = $_SESSION['user_id'];
        
        // Fetch user details from users table
        $this->db->query('
            SELECT 
                user_id,
                first_name,
                last_name,
                email,
                contact_number,
                street,
                district,
                province,
                profile_image
            FROM users 
            WHERE user_id = :user_id
        ');
        $this->db->bind(':user_id', $service_provider_id);
        $user = $this->db->single();

        // Fetch service provider details from service_providers table
        $this->db->query('
            SELECT 
                provider_id,
                expertise,
                description,
                working_hours,
                service_areas,
                id_number,
                id_front,
                id_back,
                hourly_rate
            FROM service_providers 
            WHERE provider_id = :provider_id
        ');
        $this->db->bind(':provider_id', $service_provider_id);
        $provider = $this->db->single();

        // Get average rating
        $this->db->query('
            SELECT AVG(rating) as average_rating 
            FROM appointments 
            WHERE service_provider_id = :service_provider_id 
            AND finish_status = "complete" 
            AND rating IS NOT NULL
        ');
        $this->db->bind(':service_provider_id', $service_provider_id);
        $rating_result = $this->db->single();
        $average_rating = $rating_result ? round($rating_result->average_rating, 1) : 0;

        // Get quotation statistics
        $this->db->query('
            SELECT 
                SUM(CASE WHEN status = "Approved" THEN 1 ELSE 0 END) as approved_count,
                SUM(CASE WHEN status = "Pending" THEN 1 ELSE 0 END) as pending_count,
                SUM(CASE WHEN status = "Rejected" THEN 1 ELSE 0 END) as rejected_count
            FROM quotations 
            WHERE service_provider_id = :service_provider_id
        ');
        $this->db->bind(':service_provider_id', $service_provider_id);
        $quotation_stats = $this->db->single();

        // Get job status statistics
        $this->db->query('
            SELECT 
                SUM(CASE WHEN finish_status = "complete" THEN 1 ELSE 0 END) as completed_jobs,
                SUM(CASE WHEN finish_status = "pending" THEN 1 ELSE 0 END) as pending_jobs
            FROM appointments 
            WHERE service_provider_id = :service_provider_id
        ');
        $this->db->bind(':service_provider_id', $service_provider_id);
        $job_stats = $this->db->single();

        if (!$user || !$provider) {
            die("Error: No data returned from database.");
        }

        // Pass all data to the view
        $this->view('ServiceProvider/profile', [
            'user' => $user,
            'provider' => $provider,
            'average_rating' => $average_rating,
            'quotation_stats' => $quotation_stats,
            'job_stats' => $job_stats
        ]);
    }



    // public function updateProfileFields()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $service_provider_id = $_SESSION['user_id'];

    //         $expertise = trim($_POST['expertise']);
    //         $service_areas = trim($_POST['service_areas']);
    //         $working_hours = trim($_POST['working_hours']);

    //         $data = [
    //             'service_provider_id' => $service_provider_id,
    //             'expertise' => $expertise,
    //             'service_areas' => $service_areas,
    //             'working_hours' => $working_hours
    //         ];

    //         if ($this->ProfileSVPModel->updateProfileFields($data)) {
    //             header('Location: ' . URLROOT . '/ServiceProviderController/profile');
    //             exit();
    //         } else {
    //             die("Failed to update profile fields.");
    //         }
    //     }
    // }
    public function updateProfileFields()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $service_provider_id = $_SESSION['user_id'];

            $expertise = trim($_POST['expertise']);
            $working_hours = trim($_POST['working_hours']);

            // If 'service_areas' is an array (multi-select), join them with commas
            $service_areas = isset($_POST['service_areas']) && is_array($_POST['service_areas'])
                ? implode(', ', array_map('trim', $_POST['service_areas']))
                : trim($_POST['service_areas']);

            $data = [
                'service_provider_id' => $service_provider_id,
                'expertise' => $expertise,
                'service_areas' => $service_areas,
                'working_hours' => $working_hours
            ];

            if ($this->ProfileSVPModel->updateProfileFields($data)) {
                header('Location: ' . URLROOT . '/ServiceProviderController/profile');
                exit();
            } else {
                die("Failed to update profile fields.");
            }
        }
    }

    public function generateQuotationPDF($quotation_id)
    {
        // Get quotation details
        $quotation = $this->QuotationSVPModel->getQuotationById($quotation_id);
        
        if (!$quotation) {
            die("Quotation not found.");
        }
        
        // Get appointment details
        $appointment = $this->AppointmentSVPModel->getAppointmentById($quotation->appointment_id);
        
        if (!$appointment) {
            die("Appointment not found.");
        }
        
        // Get customer details from users table
        $this->db->query('SELECT first_name, last_name, email, contact_number FROM users WHERE user_id = :customer_id');
        $this->db->bind(':customer_id', $appointment->customer_id);
        $customer = $this->db->single();
        
        if (!$customer) {
            die("Customer not found.");
        }
        
        // Get service provider details from users table
        $this->db->query('SELECT first_name, last_name, email, contact_number FROM users WHERE user_id = :provider_id');
        $this->db->bind(':provider_id', $quotation->service_provider_id);
        $service_provider = $this->db->single();
        
        if (!$service_provider) {
            die("Service provider not found.");
        }

        // Generate HTML for the quotation
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Quotation #' . $quotation->quotation_id . '</title>
            <style>
                @page {
                    size: A4;
                    margin: 0;
                }
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.4;
                    color: #333;
                    margin: 0;
                    padding: 20px;
                    font-size: 12px;
                }
                .header {
                    text-align: center;
                    margin-bottom: 15px;
                    padding-bottom: 10px;
                    border-bottom: 2px solid #2563eb;
                }
                .company-name {
                    font-size: 20px;
                    color: #2563eb;
                    margin: 0;
                }
                .quotation-title {
                    color: #374151;
                    margin: 10px 0;
                    font-size: 16px;
                }
                .details-grid {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 15px;
                    margin-bottom: 15px;
                }
                .details-section {
                    background: #f8fafc;
                    padding: 10px;
                    border-radius: 4px;
                }
                .details-section h2 {
                    margin: 0 0 8px 0;
                    font-size: 14px;
                    color: #2563eb;
                }
                .detail-item {
                    margin-bottom: 5px;
                    display: flex;
                }
                .detail-label {
                    font-weight: bold;
                    color: #666;
                    width: 80px;
                }
                .quotation-details {
                    background-color: white;
                    padding: 10px;
                    border-radius: 4px;
                    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
                }
                .quotation-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 10px 0;
                    font-size: 12px;
                }
                .quotation-table th {
                    background-color: #2563eb;
                    color: white;
                    padding: 8px;
                    text-align: left;
                }
                .quotation-table td {
                    padding: 8px;
                    border-bottom: 1px solid #ddd;
                }
                .quotation-table tr:last-child td {
                    border-bottom: none;
                }
                .price-cell {
                    font-weight: bold;
                    color: #2563eb;
                }
                .footer {
                    margin-top: 20px;
                    text-align: center;
                    color: #666;
                    font-size: 10px;
                    padding-top: 10px;
                    border-top: 1px solid #ddd;
                }
                @media print {
                    .no-print { display: none; }
                    body { padding: 15px; }
                }
            </style>
        </head>
        <body>
            <div class="header">
                <div class="company-name">HomeGenie</div>
                <p style="color: #666; margin: 5px 0;">Your Trusted Service Provider</p>
            </div>

            <h1 class="quotation-title">Quotation #' . $quotation->quotation_id . '</h1>
            <p style="text-align: center; color: #666; margin: 0 0 15px 0;">Generated on: ' . date('F d, Y', strtotime($quotation->created_at)) . '</p>

            <div class="details-grid">
                <div class="details-section">
                    <h2>Service Provider</h2>
                    <div class="detail-item">
                        <div class="detail-label">Name:</div>
                        <div>' . htmlspecialchars($service_provider->first_name . ' ' . $service_provider->last_name) . '</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Email:</div>
                        <div>' . htmlspecialchars($service_provider->email) . '</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Phone:</div>
                        <div>' . htmlspecialchars($service_provider->contact_number) . '</div>
                    </div>
                </div>

                <div class="details-section">
                    <h2>Customer</h2>
                    <div class="detail-item">
                        <div class="detail-label">Name:</div>
                        <div>' . htmlspecialchars($customer->first_name . ' ' . $customer->last_name) . '</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Email:</div>
                        <div>' . htmlspecialchars($customer->email) . '</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Phone:</div>
                        <div>' . htmlspecialchars($customer->contact_number) . '</div>
                    </div>
                </div>
            </div>

            <div class="quotation-details">
                <h2 style="color: #2563eb; margin: 0 0 10px 0; font-size: 14px;">Quotation Details</h2>
                <table class="quotation-table">
                    <tr>
                        <th>Appointment Description</th>
                        <td>' . htmlspecialchars($appointment->description) . '</td>
                    </tr>
                    <tr>
                        <th>Location</th>
                        <td>' . htmlspecialchars($appointment->location) . '</td>
                    </tr>
                    <tr>
                        <th>Quotation Details</th>
                        <td>' . htmlspecialchars($quotation->quotation_details) . '</td>
                    </tr>
                    <tr>
                        <th>Work Hours</th>
                        <td>' . htmlspecialchars($quotation->work_hours) . ' hours</td>
                    </tr>
                    <tr>
                        <th>Cost</th>
                        <td class="price-cell">$' . number_format($quotation->cost, 2) . '</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span style="color: ' . ($quotation->status === 'Approved' ? '#28a745' : ($quotation->status === 'Rejected' ? '#dc3545' : '#ffc107')) . ';">
                                ' . htmlspecialchars($quotation->status) . '
                            </span>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="footer">
                <p>This is a computer-generated quotation from HomeGenie</p>
                <p>Generated on: ' . date('F d, Y H:i:s') . '</p>
            </div>

            <div class="no-print" style="text-align: center; margin-top: 15px;">
                <button onclick="window.print()" style="padding: 8px 16px; background-color: #2563eb; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;">
                    Print / Save as PDF
                </button>
            </div>
        </body>
        </html>';

        // Output the HTML
        echo $html;
        exit;
    }

    public function updateProfessionalInfo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $service_provider_id = $_SESSION['user_id'];

            // Sanitize input
            $expertise = trim($_POST['expertise']);
            $working_hours = trim($_POST['working_hours']);
            $description = trim($_POST['description']);
            $hourly_rate = trim($_POST['hourly_rate']);
            
            // Handle service areas (array)
            $service_areas = isset($_POST['service_areas']) && is_array($_POST['service_areas'])
                ? implode(', ', array_map('trim', $_POST['service_areas']))
                : '';

            // Update in database
            $this->db->query('
                UPDATE service_providers 
                SET expertise = :expertise,
                    working_hours = :working_hours,
                    service_areas = :service_areas,
                    description = :description,
                    hourly_rate = :hourly_rate
                WHERE provider_id = :provider_id
            ');

            $this->db->bind(':expertise', $expertise);
            $this->db->bind(':working_hours', $working_hours);
            $this->db->bind(':service_areas', $service_areas);
            $this->db->bind(':description', $description);
            $this->db->bind(':hourly_rate', $hourly_rate);
            $this->db->bind(':provider_id', $service_provider_id);

            if ($this->db->execute()) {
                header('Location: ' . URLROOT . '/ServiceProviderController/profile?success=Professional information updated successfully');
                exit();
            } else {
                header('Location: ' . URLROOT . '/ServiceProviderController/profile?error=Failed to update professional information');
                exit();
            }
        }
    }

    public function updateWorkPhotos()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['work_photos'])) {
            $service_provider_id = $_SESSION['user_id'];
            $upload_dir = dirname(dirname(dirname(__DIR__))) . '/public/img/SVPpic/';
            
            // Ensure the directory exists and is writable
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            // Get existing photos
            $this->db->query('SELECT work_photos FROM service_providers WHERE provider_id = :provider_id');
            $this->db->bind(':provider_id', $service_provider_id);
            $result = $this->db->single();
            $existing_photos = $result ? explode(',', $result->work_photos) : [];
            
            // Process each uploaded file
            $new_photos = [];
            foreach ($_FILES['work_photos']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['work_photos']['error'][$key] === UPLOAD_ERR_OK) {
                    $original_name = basename($_FILES['work_photos']['name'][$key]);
                    $target_path = $upload_dir . $original_name;

                    // Move uploaded file
                    if (move_uploaded_file($tmp_name, $target_path)) {
                        $new_photos[] = $original_name;
                    }
                }
            }

            // Combine existing and new photos
            $all_photos = array_merge($existing_photos, $new_photos);
            $photos_string = implode(',', array_filter($all_photos));

            // Update the work_photos column
            $this->db->query('
                UPDATE service_providers 
                SET work_photos = :work_photos 
                WHERE provider_id = :provider_id
            ');
            
            $this->db->bind(':work_photos', $photos_string);
            $this->db->bind(':provider_id', $service_provider_id);
            
            if ($this->db->execute()) {
                header('Location: ' . URLROOT . '/ServiceProviderController/profile?success=Photos uploaded successfully');
            } else {
                header('Location: ' . URLROOT . '/ServiceProviderController/profile?error=Failed to update photo information');
            }
            exit();
        }
    }

    public function deleteWorkPhoto()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['photo_index'])) {
            $photo_index = $_POST['photo_index'];
            $service_provider_id = $_SESSION['user_id'];
            $upload_dir = dirname(dirname(dirname(__DIR__))) . '/public/img/SVPpic/';

            // Get current photos
            $this->db->query('SELECT work_photos FROM service_providers WHERE provider_id = :provider_id');
            $this->db->bind(':provider_id', $service_provider_id);
            $result = $this->db->single();
            
            if ($result && $result->work_photos) {
                $photos = explode(',', $result->work_photos);
                
                if (isset($photos[$photo_index])) {
                    // Delete the file
                    $photo_to_delete = $photos[$photo_index];
                    $file_path = $upload_dir . $photo_to_delete;
                    
                    // Remove the photo from the array
                    unset($photos[$photo_index]);
                    $photos = array_values($photos); // Reindex array
                    
                    // Update the database
                    $this->db->query('
                        UPDATE service_providers 
                        SET work_photos = :work_photos 
                        WHERE provider_id = :provider_id
                    ');
                    
                    $this->db->bind(':work_photos', implode(',', $photos));
                    $this->db->bind(':provider_id', $service_provider_id);

                    if ($this->db->execute()) {
                        // Delete the file if database update was successful
                        if (file_exists($file_path)) {
                            unlink($file_path);
                        }
                        echo json_encode(['success' => true]);
                    } else {
                        echo json_encode(['success' => false, 'error' => 'Failed to update photo information']);
                    }
                } else {
                    echo json_encode(['success' => false, 'error' => 'Photo not found']);
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'No photos found']);
            }
            exit();
        }
    }
}
