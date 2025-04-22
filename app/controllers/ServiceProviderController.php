<?php
class ServiceProviderController extends Controller
{

    private $QuotationSVPModel;
    private $ProfileSVPModel;
    private $AppointmentSVPModel;


    public function __construct()
    {
        $this->QuotationSVPModel = $this->model('QuotationSVPModel');
        // Load the ProfileSVPModel
        $this->ProfileSVPModel = $this->model('ProfileSVPModel');

        $this->AppointmentSVPModel = $this->model('AppointmentSVPModel');
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

            $result = $this->AppointmentSVPModel->approveAppointment($appointmentId);
            echo json_encode($result);  // Send back success/failure response
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
        // Fetch all quotations and appointments
        $results1 = $this->QuotationSVPModel->getAllQuotations();
        $results = $this->QuotationSVPModel->getAllAppointmentsById($service_provider_id);

        // Extract the appointment_ids that already have a quotation
        $quotation_appointment_ids = array_map(function ($quote) {
            return $quote->appointment_id;  // Assuming 'appointment_id' is the field that links to appointments
        }, $results1);

        // Filter out appointments that already have a quotation
        $filteredAppointments = array_filter($results, function ($appointment) use ($quotation_appointment_ids) {
            return !in_array($appointment->appointment_id, $quotation_appointment_ids);
        });

        // Re-index the filtered appointments array
        $filteredAppointments = array_values($filteredAppointments);

        // Pass only the filtered appointments to the view
        $this->view('ServiceProvider/quotations', data: $filteredAppointments);
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
                // On success, redirect to quotations page or another appropriate page
                header('Location: ' . URLROOT . '/ServiceProviderController/quotation');
                exit();
            } else {
                die("Error: Unable to add quotation.");
            }
        }
    }

    public function updateQuotation($id): void {
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
        // Fetch profile details
        $results2 = $this->ProfileSVPModel->getProfileDetails($service_provider_id);

        if (!$results2) {
            die("Error: No data returned from model.");
        }

        // Pass data to the view
        $this->view('ServiceProvider/profile', ['row' => $results2]);
    }



    public function updateProfileFields()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $service_provider_id = $_SESSION['user_id'];

        $expertise = trim($_POST['expertise']);
        $service_areas = trim($_POST['service_areas']);
        $working_hours = trim($_POST['working_hours']);

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


}
