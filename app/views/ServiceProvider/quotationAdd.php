<?php
require_once APPROOT . '/views/ServiceProvider/navbar_svp.php';
?>

<?php
$user_name = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$profile_pic = isset($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : 'default.png';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quotations</title>
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/SVP/SVP_quotationAdd.css">
</head>

<body>
  <div class="container">
    <h1>Quotations Add</h1>

    <div class="form-section" id="quotation-form">
      <h2>Create Quotation</h2>
      <form method="POST" action="<?php echo URLROOT . '/ServiceProviderController/quoteAdd'; ?>">
        <input type="hidden" name="appointment_id" id="appointment_id">
        <textarea name="quotation_details" placeholder="Enter quotation details" required></textarea>
        <input type="number" name="work_hours" placeholder="Enter work hours" required>
        <input type="number" name="cost" placeholder="Enter cost" required>
        <button type="submit" class="btn" style="color: white;">Create Quotation</button>
        <p>Appointment ID: <span id="display-appointment-id"></span></p>
      </form>
    </div>

    <script>
      window.onload = function () {
        // Debug: Log the session value
        console.log("Session appointment ID:", <?php echo isset($_SESSION['pending_quotation_appointment_id']) ? json_encode($_SESSION['pending_quotation_appointment_id']) : 'null'; ?>);
        
        var appointmentId = <?php echo isset($_SESSION['pending_quotation_appointment_id']) ? json_encode($_SESSION['pending_quotation_appointment_id']) : 'null'; ?>;
        if (appointmentId) {
          document.getElementById('appointment_id').value = appointmentId; // Set hidden input
          document.getElementById('display-appointment-id').textContent = appointmentId; // Display appointment id
        } else {
          console.error("No appointment ID found in session");
        }
      };
    </script>
  </div>
</body>

</html>

<?php
require_once APPROOT . '/views/ServiceProvider/footer_svp.php';
?>