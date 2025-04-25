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
        // Assuming the user is logged in and their ID is stored in the session
        $service_provider_id = $_SESSION['user_id'];

        // Fetch the appointments from the model
        $pendingAppointments = $this->AppointmentSVPModel->getPendingAppointments($service_provider_id);
        $approvedAppointments = $this->AppointmentSVPModel->getApprovedAppointments($service_provider_id);

        // Pass the appointments to the view
        $this->view('ServiceProvider/appointments', [
            'pendingAppointments' => $pendingAppointments,
            'approvedAppointments' => $approvedAppointments
        ]);
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
            $price = trim($_POST['price']);

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
                'price' => $price,
                'status' => 'pending'
            ];

            // Call the model to add the quotation
            if ($this->QuotationSVPModel->addQuotation($data)) {
                // Update the appointment status to 'Approved'
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
            $price = trim($_POST['price']);

            $quotationModel = $this->model('QuotationSVPModel');

            if ($quotationModel->updateQuotation($id, $quotation_details, $price)) {
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
        $service_provider_id = $_SESSION['user_id'];
        
        // Fetch user details from users table
        $this->db->query('
            SELECT 
                user_id,
                first_name,
                last_name,
                email,
                contact_number,
                address,
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
                id_back
            FROM service_providers 
            WHERE provider_id = :provider_id
        ');
        $this->db->bind(':provider_id', $service_provider_id);
        $provider = $this->db->single();

        if (!$user || !$provider) {
            die("Error: No data returned from database.");
        }

        // Pass both user and provider data to the view
        $this->view('ServiceProvider/profile', [
            'user' => $user,
            'provider' => $provider
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

        // Get customer details
        $customer = $this->model('CustomerModel')->getCustomerById($appointment->customer_id);
        
        if (!$customer) {
            die("Customer not found.");
        }

        // Get service provider details
        $service_provider = $this->ProfileSVPModel->getProfileDetails($quotation->service_provider_id);
        
        if (!$service_provider) {
            die("Service provider not found.");
        }

        // Create printable HTML content
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Quotation #' . $quotation->quotation_id . '</title>
            <style>
                @media print {
                    body { font-family: Arial, sans-serif; margin: 0; }
                    .no-print { display: none; }
                    .print-button { display: none; }
                }
                body { 
                    font-family: Arial, sans-serif; 
                    margin: 0;
                    color: #333;
                }
                .header {
                    background-color: #1a237e;
                    color: white;
                    padding: 20px;
                    text-align: center;
                    position: relative;
                }
                .logo {
                    font-size: 28px;
                    font-weight: bold;
                    margin-bottom: 10px;
                    color: #fff;
                }
                .logo span {
                    color: #64b5f6;
                }
                .quotation-title {
                    font-size: 24px;
                    margin: 20px 0;
                    color: #1a237e;
                    text-align: center;
                }
                .content {
                    padding: 40px;
                    max-width: 800px;
                    margin: 0 auto;
                }
                .details-section {
                    background-color: #f5f5f5;
                    padding: 20px;
                    border-radius: 8px;
                    margin-bottom: 30px;
                }
                .details-section h2 {
                    color: #1a237e;
                    border-bottom: 2px solid #64b5f6;
                    padding-bottom: 10px;
                    margin-bottom: 20px;
                }
                .details-grid {
                    display: grid;
                    grid-template-columns: repeat(2, 1fr);
                    gap: 20px;
                }
                .detail-item {
                    margin-bottom: 10px;
                }
                .detail-label {
                    font-weight: bold;
                    color: #666;
                }
                .quotation-details {
                    background-color: white;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                }
                .quotation-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                }
                .quotation-table th {
                    background-color: #1a237e;
                    color: white;
                    padding: 12px;
                    text-align: left;
                }
                .quotation-table td {
                    padding: 12px;
                    border-bottom: 1px solid #ddd;
                }
                .quotation-table tr:last-child td {
                    border-bottom: none;
                }
                .price-cell {
                    font-weight: bold;
                    color: #1a237e;
                }
                .footer {
                    margin-top: 50px;
                    text-align: center;
                    color: #666;
                    font-size: 14px;
                }
                .print-button {
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    padding: 10px 20px;
                    background-color: #1a237e;
                    color: white;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    font-weight: bold;
                }
                .print-button:hover {
                    background-color: #0d47a1;
                }
                .status-badge {
                    display: inline-block;
                    padding: 5px 10px;
                    border-radius: 15px;
                    font-weight: bold;
                    font-size: 14px;
                }
                .status-approved {
                    background-color: #e8f5e9;
                    color: #2e7d32;
                }
                .status-pending {
                    background-color: #fff3e0;
                    color: #f57c00;
                }
                .status-rejected {
                    background-color: #ffebee;
                    color: #c62828;
                }
            </style>
        </head>
        <body>
            <button class="print-button" onclick="window.print()">Print / Save as PDF</button>

            <div class="header">
                <div class="logo">Home<span>Genie</span></div>
                <p>Your Trusted Home Service Partner</p>
            </div>

            <div class="content">
                <h1 class="quotation-title">Quotation #' . $quotation->quotation_id . '</h1>
                <p style="text-align: center; color: #666; margin-bottom: 30px;">Generated on: ' . date('F d, Y', strtotime($quotation->created_at)) . '</p>

                <div class="details-grid">
                    <div class="details-section">
                        <h2>Service Provider Details</h2>
                        <div class="detail-item">
                            <div class="detail-label">Name</div>
                            <div>' . htmlspecialchars($service_provider->name) . '</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Email</div>
                            <div>' . htmlspecialchars($service_provider->email) . '</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Phone</div>
                            <div>' . htmlspecialchars($service_provider->phone) . '</div>
                        </div>
                    </div>

                    <div class="details-section">
                        <h2>Customer Details</h2>
                        <div class="detail-item">
                            <div class="detail-label">Name</div>
                            <div>' . htmlspecialchars($customer->name) . '</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">NIC</div>
                            <div>' . htmlspecialchars($customer->nic) . '</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Address</div>
                            <div>' . htmlspecialchars($customer->address) . '</div>
                        </div>
                    </div>
                </div>

                <div class="quotation-details">
                    <h2 style="color: #1a237e; margin-bottom: 20px;">Quotation Details</h2>
                    <table class="quotation-table">
                        <tr>
                            <th>Description</th>
                            <td>' . htmlspecialchars($quotation->quotation_details) . '</td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td class="price-cell">$' . number_format($quotation->price, 2) . '</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="status-badge status-' . strtolower($quotation->status) . '">
                                    ' . htmlspecialchars($quotation->status) . '
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="footer">
                    <p>This is a computer-generated quotation from HomeGenie</p>
                    <p>For any inquiries, please contact our customer service</p>
                    <p>Generated on: ' . date('F d, Y H:i:s') . '</p>
                </div>
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
                    description = :description
                WHERE provider_id = :provider_id
            ');

            $this->db->bind(':expertise', $expertise);
            $this->db->bind(':working_hours', $working_hours);
            $this->db->bind(':service_areas', $service_areas);
            $this->db->bind(':description', $description);
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
