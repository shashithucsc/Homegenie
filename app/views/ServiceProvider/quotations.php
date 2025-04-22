<?php require_once APPROOT . '/views/ServiceProvider/navbar_svp.php';
$user_name = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$profile_pic = isset($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : 'default.png';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quotations</title>
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/SVP/SVP_quotations.css">
</head>

<body>
  <div class="container">
    <!-- Buttons to switch between views -->
    <div class="button1-group" style="text-align: center; margin-top: 30px;margin-bottom: 20px;">
      <button class="btn1" onclick="showAppointments()"
        style="color: white; background: linear-gradient(135deg, #2563eb, #1e40af); padding: 12px 30px; font-size: 16px; border: none; border-radius: 8px; cursor: pointer; transition: all 0.3s ease;">
        Quote Appointments
      </button>
      <button class="btn1" onclick="showQuotations()"
        style="color: #1e40af; background-color: white; padding: 12px 30px; font-size: 16px; border: 2px solid #1e40af; border-radius: 8px; cursor: pointer; transition: all 0.3s ease; margin-left: 15px;">
        Created Quotations
      </button>
    </div>

    <!-- Display Appointments Section -->
    <div id="appointments-section">
      <div class="appointments-container" style="justify-content: center;margin-top: 30px;">
        <?php if (!empty($data)): ?>
          <?php foreach ($data as $item): ?>
            <div class="card">
              <h3>Service Category: <?php echo htmlspecialchars($item->service_category); ?></h3>
              <p>Appointment ID: <?php echo htmlspecialchars($item->appointment_id); ?></p>
              <p>Customer ID: <?php echo htmlspecialchars($item->customer_id); ?></p>
              <p>Date: <?php echo htmlspecialchars($item->appointment_date); ?></p>
              <p>Time: <?php echo htmlspecialchars($item->appointment_time); ?></p>
              <p>Location: <?php echo htmlspecialchars($item->location); ?></p>
              <p>Status: <?php echo htmlspecialchars($item->status); ?></p>
              <button class="btn" style="color: white;" data-id="<?php echo $item->appointment_id; ?>"
                onclick="createQuotation(<?php echo $item->appointment_id; ?>)">
                Create Quotation
              </button>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No approved appointments available.</p>
        <?php endif; ?>
      </div>
    </div>

    <script>
      // Function to switch to the Approved Appointments section
      function showAppointments() {
        window.location.href = '<?php echo URLROOT; ?>/ServiceProviderController/quotation';
      }

      // Function to switch to the View All Quotations section
      function showQuotations() {
        window.location.href = '<?php echo URLROOT; ?>/ServiceProviderController/SubmittedQuotations';
      }

      // Function to create a quotation
      function createQuotation(appointmentId) {
        window.location.href = '<?php echo URLROOT; ?>/ServiceProviderController/quotationAdd?appointment_id=' + appointmentId;
      }
    </script>
  </div>
</body>

</html>

<?php
require_once APPROOT . '/views/ServiceProvider/footer_svp.php';
?>