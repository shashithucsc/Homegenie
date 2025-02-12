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
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/SVP/SVP_SubmittedQuotations.css">
</head>

<body>
  <div class="container">
    <div class="button-group"
      style="display: flex;margin-top: 30px; justify-content: center; gap: 20px; margin-bottom: 20px;">
      <button class="btn" onclick="showAppointments()"
        style="color: #1e40af; background-color: white; padding: 12px 30px; font-size: 16px; border-radius: 8px; cursor: pointer; transition: all 0.3s ease; border: 2px solid #1e40af;">
        Approved Appointments
      </button>
      <button class="btn" onclick="showQuotations()"
        style="color: white; background: linear-gradient(135deg, #2563eb, #1e40af); padding: 12px 30px; border: none; font-size: 16px; border-radius: 8px; cursor: pointer; transition: all 0.3s ease;">
        View All Quotations
      </button>
    </div>

    <style>
      .btn:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      }

      .button-group {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 20px;
      }

      .button-group button {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
      }
    </style>

    <!-- Display Quotations -->
    <div class="quotation-list">
      <div class="quotations-container" style="justify-content: center;">
        <?php if (!empty($data)): ?>
          <?php foreach ($data as $item): ?>
            <div class="card" id="card-<?php echo $item->quotation_id; ?>">
              <button class="btn" onclick="printQuotation(<?php echo $item->quotation_id; ?>)"
                style="color: white; background-color:rgb(103, 134, 235); float: right; align-items: end;">
                <i class="fas fa-print fa-1x"></i>
              </button>

              <h3>Quotation ID: <?php echo htmlspecialchars($item->quotation_id); ?></h3>
              <p>Appointment ID: <?php echo htmlspecialchars($item->appointment_id); ?></p>
              <!-- <p>Service Provider ID: <?php echo htmlspecialchars($item->service_provider_id); ?></p> -->

              <!-- Editable Fields -->
              <p>Details:
                <span
                  id="details-text-<?php echo $item->quotation_id; ?>"><?php echo htmlspecialchars($item->quotation_details); ?></span>
                <textarea id="details-input-<?php echo $item->quotation_id; ?>"
                  style="display:none;"><?php echo htmlspecialchars($item->quotation_details); ?></textarea>
              </p>

              <p>Price:
                <span
                  id="price-text-<?php echo $item->quotation_id; ?>"><?php echo htmlspecialchars($item->price); ?></span>
                <input type="number" id="price-input-<?php echo $item->quotation_id; ?>"
                  value="<?php echo htmlspecialchars($item->price); ?>" style="display:none;">
              </p>

              <p>Status: <span
                  id="status-text-<?php echo $item->quotation_id; ?>"><?php echo htmlspecialchars($item->status); ?></span>
              </p>
              <p>Date Created: <span
                  id="created-at-text-<?php echo $item->quotation_id; ?>"><?php echo htmlspecialchars($item->created_at); ?></span>
              </p>
              <p>Last Update: <span
                  id="updated-at-text-<?php echo $item->quotation_id; ?>"><?php echo htmlspecialchars($item->updated_at); ?></span>
              </p>

              <!-- Update Button -->
              <button class="btn update-btn" style="color: white;"
                onclick="editQuotation(<?php echo $item->quotation_id; ?>)"><i class="fas fa-edit"></i> Update</button>

              <!-- Save & Cancel Buttons (Initially Hidden) -->
              <button class="btn save-btn" onclick="saveQuotation(<?php echo $item->quotation_id; ?>)"
                style="color: white; display:none;">Save</button>
              <button class="btn cancel-btn" onclick="cancelEdit(<?php echo $item->quotation_id; ?>)"
                style="color: white; display:none;">Cancel</button>

              <!-- Delete Button -->
              <button class="btn" onclick="deleteQuotation(<?php echo $item->quotation_id; ?>)"
                style="color: white; background-color: red;">
                <i class="fas fa-trash-alt"></i> Delete
              </button>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No quotations available.</p>
        <?php endif; ?>
      </div>
    </div>

  </div>

  <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <script>
    // Function to switch to the Approved Appointments section
    function showAppointments() {
      window.location.href = '<?php echo URLROOT; ?>/ServiceProviderController/quotation';
    }

    // Function to switch to the View All Quotations section
    function showQuotations() {
      window.location.href = '<?php echo URLROOT; ?>/ServiceProviderController/SubmittedQuotations';
    }

    function deleteQuotation(id) {
      if (confirm("Are you sure you want to delete this quotation?")) {
        fetch('<?php echo URLROOT; ?>/ServiceProviderController/deleteQuotation/' + id, {
          method: 'POST'
        })
          .then(response => response.text())
          .then(data => {
            window.location.href = '<?php echo URLROOT; ?>/ServiceProviderController/SubmittedQuotations?message=Quotation deleted successfully';
          })
          .catch(error => {
            console.error("Error deleting quotation:", error);
            window.location.href = '<?php echo URLROOT; ?>/ServiceProviderController/SubmittedQuotations?error=Failed to delete quotation';
          });
      }
    }

    function editQuotation(id) {
      // Hide text and show input fields
      document.getElementById(`details-text-${id}`).style.display = "none";
      document.getElementById(`price-text-${id}`).style.display = "none";
      document.getElementById(`details-input-${id}`).style.display = "block";
      document.getElementById(`price-input-${id}`).style.display = "block";

      // Show Save and Cancel buttons, hide Update button
      document.querySelector(`#card-${id} .update-btn`).style.display = "none";
      document.querySelector(`#card-${id} .save-btn`).style.display = "inline-block";
      document.querySelector(`#card-${id} .cancel-btn`).style.display = "inline-block";
    }

    function cancelEdit(id) {
      // Hide input fields and show text values again
      document.getElementById(`details-text-${id}`).style.display = "inline";
      document.getElementById(`price-text-${id}`).style.display = "inline";
      document.getElementById(`details-input-${id}`).style.display = "none";
      document.getElementById(`price-input-${id}`).style.display = "none";

      // Hide Save and Cancel buttons, show Update button again
      document.querySelector(`#card-${id} .update-btn`).style.display = "inline-block";
      document.querySelector(`#card-${id} .save-btn`).style.display = "none";
      document.querySelector(`#card-${id} .cancel-btn`).style.display = "none";
    }

    function saveQuotation(id) {
      let newDetails = document.getElementById(`details-input-${id}`).value;
      let newPrice = document.getElementById(`price-input-${id}`).value;

      // Send AJAX request to update data
      fetch('<?php echo URLROOT; ?>/ServiceProviderController/updateQuotation/' + id, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `quotation_details=${encodeURIComponent(newDetails)}&price=${encodeURIComponent(newPrice)}`
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Update text values
            document.getElementById(`details-text-${id}`).textContent = newDetails;
            document.getElementById(`price-text-${id}`).textContent = newPrice;

            // Hide input fields and show text again
            document.getElementById(`details-text-${id}`).style.display = "inline";
            document.getElementById(`price-text-${id}`).style.display = "inline";
            document.getElementById(`details-input-${id}`).style.display = "none";
            document.getElementById(`price-input-${id}`).style.display = "none";

            // Hide Save and Cancel buttons, show Update button again
            document.querySelector(`#card-${id} .update-btn`).style.display = "inline-block";
            document.querySelector(`#card-${id} .save-btn`).style.display = "none";
            document.querySelector(`#card-${id} .cancel-btn`).style.display = "none";

            window.location.href = '<?php echo URLROOT; ?>/ServiceProviderController/SubmittedQuotations';
          } else {
            alert("Failed to update quotation");
          }
        })
        .catch(error => {
          console.error("Error saving quotation:", error);
        });
    }

    function printQuotation(id) {
      // Get the details of the selected quotation
      let details = document.getElementById(`details-text-${id}`).textContent;
      let price = document.getElementById(`price-text-${id}`).textContent;
      let status = document.getElementById(`status-text-${id}`).textContent;
      let dateCreated = document.getElementById(`created-at-text-${id}`).textContent;
      let lastUpdate = document.getElementById(`updated-at-text-${id}`).textContent;

      // Create a printable content
      let printContent = `
    <div style="padding: 30px; font-family: 'Helvetica', Arial, sans-serif; background-color: #f4f4f9; height:90%;max-width: 700px; margin: auto; border-radius: 8px; border: 1px solid #ddd; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
        <div style="text-align: center; margin-bottom: 20px;">
            <h1 style="color: #1e40af; font-size: 32px; margin-top: 30px;margin-bottom: 0;">HomeGenie</h1>
            <p style="color: #888; font-size: 14px; margin: 0;">Your Trusted Service Provider</p>
        </div>
        <h2 style="text-align: left; color: #1e40af; font-size: 18px; margin-top: 100px;">Quotation Report</h2>
        <hr style="border-top: 2px solid #1e40af; margin-bottom: 20px;">
        <div style="font-size: 16px; line-height: 1.6;">
            <p><strong style="color: #333;">Quotation ID:</strong> <span style="color: #555;">${id}</span></p>
            <p><strong style="color: #333;">Details:</strong> <span style="color: #555;">${details}</span></p>
            <p><strong style="color: #333;">Price:</strong> <span style="color: #555; font-weight: bold;">${price}</span></p>
            <p><strong style="color: #333;">Status:</strong> <span style="color: #555;">${status}</span></p>
            <p><strong style="color: #333;">Date Created:</strong> <span style="color: #555;">${dateCreated}</span></p>
            <p><strong style="color: #333;">Last Update:</strong> <span style="color: #555;">${lastUpdate}</span></p>
        </div>
        <hr style="border-top: 2px solid #1e40af; margin-top: 20px;">
        <div style="text-align: center; margin-top: 20px;">
            <p style="font-size: 14px; color: #888;">Generated on ${new Date().toLocaleDateString()}</p>
        </div>
    </div>
  `;

      // Open a new window to print the content
      let printWindow = window.open('', '', 'height=600,width=800');
      printWindow.document.write('<html><head><title>Print Quotation</title></head><body>');
      printWindow.document.write(printContent);
      printWindow.document.write('</body></html>');
      printWindow.document.close(); // Necessary for IE >= 10
      printWindow.print(); // Print the content
    }
  </script>
</body>

</html>

<?php
require_once APPROOT . '/views/ServiceProvider/footer_svp.php';
?>