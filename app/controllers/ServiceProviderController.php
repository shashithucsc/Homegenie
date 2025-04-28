<?php
class ServiceProviderController extends Controller
{

    private $QuotationSVPModel;
    private $ProfileSVPModel;
    private $AppointmentSVPModel;
    private $SupportSVPModel;
    private $db;


    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'service_provider') {
            header('Location: ' . URLROOT . '/LoginController');
            exit;
        }
        $this->QuotationSVPModel = $this->model('QuotationSVPModel');
        $this->ProfileSVPModel = $this->model('ProfileSVPModel');
        $this->AppointmentSVPModel = $this->model('AppointmentSVPModel');
        $this->SupportSVPModel = $this->model('SupportSVPModel');
        $this->db = new Database();
    }

    public function index()
    {
        // Get the logged-in service provider's ID
        $service_provider_id = $_SESSION['user_id'];
    
        // Get service provider's hourly rate
        $hourlyRate = $this->AppointmentSVPModel->getHourlyRate($service_provider_id);
    
        // Get pending appointments
        $pendingAppointments = $this->AppointmentSVPModel->getPendingAppointments($service_provider_id);
    
        // Get approved appointments with customer and quotation details
        $approvedAppointments = $this->AppointmentSVPModel->getApprovedAppointments($service_provider_id);
    
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
            
            // Simply redirect back to appointments page
            header('Location: ' . URLROOT . '/ServiceProviderController/appointments');
            exit();
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
    
            // Create quotation with Pending status
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
        $user_id = $_SESSION['user_id'];
        
        // Get FAQs and issues
        $faqs = $this->SupportSVPModel->getAllFAQs();
        $issues = $this->SupportSVPModel->getUserIssues($user_id);
        
        $this->view('ServiceProvider/support', [
            'faqs' => $faqs,
            'issues' => $issues
        ]);
    }

    public function createIssue()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'user_id' => $_SESSION['user_id'],
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description'])
            ];

            if ($this->SupportSVPModel->createIssue($data)) {
                header('Location: ' . URLROOT . '/ServiceProviderController/support?success=Issue reported successfully');
            } else {
                header('Location: ' . URLROOT . '/ServiceProviderController/support?error=Failed to report issue');
            }
            exit();
        }
    }

    public function updateIssueStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $status = $_POST['status'];

            if ($this->SupportSVPModel->updateIssueStatus($id, $status)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
            exit();
        }
    }



    public function quotation()
{
    $service_provider_id = $_SESSION['user_id'];
    
    // Fetch all quotations for the service provider
    $results = $this->QuotationSVPModel->getAllQuotationslist($service_provider_id);
    
    $this->view('ServiceProvider/quotations', data: $results);
}



public function SubmittedQuotations()
{
    $service_provider_id = $_SESSION['user_id'];
    
    $results = $this->QuotationSVPModel->getAllQuotationslist($service_provider_id);
    
    $this->view('ServiceProvider/SubmittedQuotations', data: $results);
}

    public function profile()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit();
        }
    
        $service_provider_id = $_SESSION['user_id'];
    
        // Call the model methods
        $user = $this->ProfileSVPModel->getUserDetails($service_provider_id);
        $provider = $this->ProfileSVPModel->getProviderDetails($service_provider_id);
        $average_rating = $this->ProfileSVPModel->getAverageRating($service_provider_id);
        $quotation_stats = $this->ProfileSVPModel->getQuotationStats($service_provider_id);
        $job_stats = $this->ProfileSVPModel->getJobStats($service_provider_id);
    
        if (!$user || !$provider) {
            die("Error: No data returned from database.");
        }
    
        // Load the view
        $this->view('ServiceProvider/profile', [
            'user' => $user,
            'provider' => $provider,
            'average_rating' => $average_rating,
            'quotation_stats' => $quotation_stats,
            'job_stats' => $job_stats
        ]);
    }
    

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
        // Get all quotation details from the model
        $data = $this->QuotationSVPModel->getQuotationDetailsForPDF($quotation_id);
        
        if (!$data) {
            die("Quotation details not found.");
        }

        // Extract the data for the view
        $quotation = $data['quotation'];
        $appointment = $data['appointment'];
        $customer = $data['customer'];
        $service_provider = $data['service_provider'];

        // Load the view with the data
        require_once APPROOT . '/views/ServiceProvider/pdfquotation.php';
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
    
            // Handle service areas
            $service_areas = isset($_POST['service_areas']) && is_array($_POST['service_areas'])
                ? implode(', ', array_map('trim', $_POST['service_areas']))
                : '';
    
            // Call model method
            $success = $this->ProfileSVPModel->updateProfessionalInfo(
                $service_provider_id,
                $expertise,
                $working_hours,
                $service_areas,
                $description,
                $hourly_rate
            );
    
            if ($success) {
                header('Location: ' . URLROOT . '/ServiceProviderController/profile?success=Professional information updated successfully');
            } else {
                header('Location: ' . URLROOT . '/ServiceProviderController/profile?error=Failed to update professional information');
            }
            exit();
        }
    }
    


    
    
}
