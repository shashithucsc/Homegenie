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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    .container {
      padding: 20px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .status-section {
      margin-bottom: 30px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      padding: 20px;
    }

    .status-header {
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .status-header i {
      font-size: 1.2em;
    }

    .quotations-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    .quotations-table th {
      background-color: #f8f9fa;
      padding: 12px;
      text-align: left;
      font-weight: 600;
      color: #495057;
      border-bottom: 2px solid #dee2e6;
    }

    .quotations-table td {
      padding: 12px;
      border-bottom: 1px solid #dee2e6;
      vertical-align: middle;
    }

    .quotations-table tr:hover {
      background-color: #f8f9fa;
    }

    .status-badge {
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 0.85em;
      font-weight: 500;
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }

    .status-badge i {
      font-size: 0.9em;
    }

    .price-cell {
      font-weight: 600;
      color: #28a745;
    }

    .action-buttons {
      display: flex;
      gap: 10px;
    }

    .action-btn {
      padding: 6px 12px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 5px;
      font-size: 0.9em;
      transition: all 0.3s ease;
    }

    .view-btn {
      background-color: #007bff;
      color: white;
    }

    .edit-btn {
      background-color: #ffc107;
      color: #212529;
    }

    .delete-btn {
      background-color: #dc3545;
      color: white;
    }

    .action-btn:hover {
      opacity: 0.9;
      transform: translateY(-2px);
    }

    .no-quotations {
      text-align: center;
      padding: 30px;
      color: #6c757d;
      font-style: italic;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="quotation-list">
      <?php
      // Group quotations by status
      $groupedQuotations = [
          'Approved' => [],
          'Rejected' => [],
          'Pending' => []
      ];
      
      if (!empty($data)) {
          foreach ($data as $item) {
              $groupedQuotations[$item->status][] = $item;
          }
      }
      
      // Display each status group only if it has quotations
      foreach ($groupedQuotations as $status => $quotations): 
          if (!empty($quotations)): ?>
              <div class="status-section">
                  <h2 class="status-header" style="background-color: <?php 
                      echo $status === 'Approved' ? 'rgba(40, 167, 69, 0.1)' : 
                          ($status === 'Rejected' ? 'rgba(220, 53, 69, 0.1)' : 'rgba(255, 193, 7, 0.1)'); 
                  ?>; color: <?php 
                      echo $status === 'Approved' ? '#28a745' : 
                          ($status === 'Rejected' ? '#dc3545' : '#ffc107'); 
                  ?>">
                      <i class="fas <?php 
                          echo $status === 'Approved' ? 'fa-check-circle' : 
                              ($status === 'Rejected' ? 'fa-times-circle' : 'fa-clock'); 
                      ?>"></i>
                      <?php echo htmlspecialchars($status); ?> Quotations
                  </h2>
                  
                  <table class="quotations-table">
                      <thead>
                          <tr>
                              <th>Quotation ID</th>
                              <th>Appointment ID</th>
                              <th>Appointment Description</th>
                              <th>Location</th>
                              <th>Quotation Details</th>
                              <th>Work Hours</th>
                              <th>Cost</th>
                              <th>Status</th>
                              <th>Created Date</th>
                              <th>Actions</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php foreach ($quotations as $item): ?>
                              <tr>
                                  <td><?php echo htmlspecialchars($item->quotation_id); ?></td>
                                  <td><?php echo htmlspecialchars($item->appointment_id); ?></td>
                                  <td><?php echo htmlspecialchars($item->appointment_description); ?></td>
                                  <td><?php echo htmlspecialchars($item->appointment_location); ?></td>
                                  <td><?php echo htmlspecialchars($item->quotation_details); ?></td>
                                  <td><?php echo htmlspecialchars($item->work_hours); ?> hours</td>
                                  <td class="price-cell">$<?php echo htmlspecialchars($item->cost); ?></td>
                                  <td>
                                      <span class="status-badge" style="background-color: <?php 
                                          echo $item->status === 'Approved' ? 'rgba(40, 167, 69, 0.1)' : 
                                              ($item->status === 'Rejected' ? 'rgba(220, 53, 69, 0.1)' : 'rgba(255, 193, 7, 0.1)'); 
                                      ?>; color: <?php 
                                          echo $item->status === 'Approved' ? '#28a745' : 
                                              ($item->status === 'Rejected' ? '#dc3545' : '#ffc107'); 
                                      ?>;">
                                          <i class="fas <?php 
                                              echo $item->status === 'Approved' ? 'fa-check-circle' : 
                                                  ($item->status === 'Rejected' ? 'fa-times-circle' : 'fa-clock'); 
                                          ?>"></i>
                                          <?php echo htmlspecialchars($item->status); ?>
                                      </span>
                                  </td>
                                  <td><?php echo date('F d, Y', strtotime($item->created_at)); ?></td>
                                  <td>
                                      <div class="action-buttons">
                                          <?php if ($item->status === 'Approved' || $item->status === 'Pending'): ?>
                                              <button class="action-btn view-btn" onclick="downloadQuotationPDF(<?php echo $item->quotation_id; ?>)">
                                                  <i class="fas fa-print"></i> Print / Save
                                              </button>
                                          <?php endif; ?>
                                          
                                          <?php if ($item->status === 'Rejected'): ?>
                                              <button class="action-btn delete-btn" onclick="deleteQuotation(<?php echo $item->quotation_id; ?>)">
                                                  <i class="fas fa-trash"></i> Delete
                                              </button>
                                          <?php endif; ?>
                                      </div>
                                  </td>
                              </tr>
                          <?php endforeach; ?>
                      </tbody>
                  </table>
              </div>
          <?php endif;
      endforeach; ?>
    </div>
  </div>

  <script>
    function downloadQuotationPDF(quotationId) {
        window.location.href = '<?php echo URLROOT; ?>/ServiceProviderController/generateQuotationPDF/' + quotationId;
    }

    function deleteQuotation(quotationId) {
        if (confirm('Are you sure you want to hide this quotation?')) {
            // Find the row containing the quotation
            const rows = document.querySelectorAll('tr');
            for (const row of rows) {
                const firstCell = row.querySelector('td:first-child');
                if (firstCell && firstCell.textContent.trim() === quotationId.toString()) {
                    // Hide the row with a fade-out animation
                    row.style.transition = 'opacity 0.3s ease';
                    row.style.opacity = '0';
                    
                    // Remove the row after the animation completes
                    setTimeout(() => {
                        row.style.display = 'none';
                    }, 300);
                    break;
                }
            }
        }
    }
  </script>
</body>

</html>

<?php
require_once APPROOT . '/views/ServiceProvider/footer_svp.php';
?>