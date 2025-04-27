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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    /* Base Styles */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding-top: 50px;
      /* padding: 2rem; */
      background: #fff;
    }

    /* Status Section */
    .status-section {
      margin-bottom: 2rem;
      background: #fff;
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      overflow: hidden;
      width: 100%;
    }

    /* Status Header */
    .status-header {
      padding: 1rem 1.5rem;
      font-size: 1.25rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      border-bottom: 1px solid #e5e7eb;
    }

    .status-header i {
      font-size: 1.1em;
    }

    .status-header.approved {
      background: #f0fdf4;
      color: #166534;
    }

    .status-header.rejected {
      background: #fef2f2;
      color: #991b1b;
    }

    .status-header.pending {
      background: #fffbeb;
      color: #92400e;
    }

    /* Table Styles */
    .quotations-table {
      width: 95%;
      margin: 10px auto;
      border-collapse: collapse;
      font-size: 0.95rem;
    }

    .quotations-table thead th {
      background: #f9fafb;
      color: #374151;
      font-weight: 600;
      padding: 1rem 1.5rem;
      text-align: left;
      font-size: 0.9rem;
      border-bottom: 1px solid #e5e7eb;
    }

    .quotations-table tbody tr {
      border-bottom: 1px solid #e5e7eb;
    }

    .quotations-table tbody tr:hover {
      background: #f9fafb;
    }

    .quotations-table td {
      padding: 1rem 1.5rem;
      vertical-align: middle;
      color: #374151;
    }

    /* ID Cells */
    .quotations-table td:first-child,
    .quotations-table td:nth-child(2) {
      font-weight: 500;
      color: #4b5563;
    }

    /* Quotation Details */
    .quotations-table td:nth-child(3) {
      max-width: 300px;
      word-break: break-word;
      white-space: normal;
      line-height: 1.5;
    }

    /* Work Hours */
    .quotations-table td:nth-child(4) {
      color: #4b5563;
      font-weight: 500;
    }

    /* Price */
    .quotations-table td:nth-child(5) {
      color: #166534;
      font-weight: 500;
    }

    /* Status Badge */
    .status-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.5rem 1rem;
      border-radius: 4px;
      font-weight: 500;
      font-size: 0.9rem;
    }

    .status-badge i {
      font-size: 1em;
    }

    .status-badge.approved {
      background: #f0fdf4;
      color: #166534;
    }

    .status-badge.rejected {
      background: #fef2f2;
      color: #991b1b;
    }

    .status-badge.pending {
      background: #fffbeb;
      color: #92400e;
    }

    /* Action Buttons */
    .action-buttons {
      display: flex;
      gap: 0.75rem;
    }

    .action-btn {
      padding: 0.5rem 1rem;
      border: 1px solid #e5e7eb;
      border-radius: 4px;
      font-weight: 500;
      font-size: 0.9rem;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      background: #fff;
      color: #374151;
      transition: all 0.2s ease;
    }

    .action-btn i {
      font-size: 1em;
    }

    .view-btn {
      border-color:rgb(20, 104, 221);
      color: rgb(20, 104, 221);
    }

    .view-btn:hover {
      background: #f3f4f6;
    }

    .delete-btn {
      border-color: #991b1b;
      color: #991b1b;
    }

    .delete-btn:hover {
      background: #fef2f2;
    }

    /* Created Date */
    .quotations-table td:nth-child(7) {
      color: #6b7280;
      font-size: 0.9rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .container {
        padding: 1rem;
      }
      
      .quotations-table {
        display: block;
        overflow-x: auto;
        width: 100%;
      }
      
      .quotations-table td {
        padding: 0.75rem 1rem;
        min-width: 120px;
      }
      
      .quotations-table thead th {
        padding: 0.75rem 1rem;
        min-width: 120px;
      }
      
      .action-buttons {
        flex-direction: column;
      }
      
      .action-btn {
        width: 100%;
        justify-content: center;
      }
      
      .status-badge {
        padding: 0.5rem 0.75rem;
      }
      
      .status-header {
        padding: 0.75rem 1rem;
        font-size: 1.1rem;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="quotation-list">
      <?php
      // Group quotations by status in the desired order
      $groupedQuotations = [
        'Approved' => [],
        'Pending' => [],
        'Rejected' => []
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
            <h2 class="status-header <?php echo strtolower($status); ?>">
              <i class="fas <?php
                            echo $status === 'Approved' ? 'fa-check-circle' : ($status === 'Rejected' ? 'fa-times-circle' : 'fa-clock');
                            ?>"></i>
              <?php echo htmlspecialchars($status); ?> Quotations
            </h2>

            <table class="quotations-table">
              <thead>
                <tr>
                  <th>Quotation ID</th>
                  <th>Appointment ID</th>
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
                    <td><?php echo htmlspecialchars($item->quotation_details); ?></td>
                    <td><?php echo htmlspecialchars($item->work_hours); ?> hours</td>
                    <td class="price-cell">$<?php echo htmlspecialchars($item->cost); ?></td>
                    <td>
                      <span class="status-badge <?php echo strtolower($item->status); ?>">
                        <i class="fas <?php
                                      echo $item->status === 'Approved' ? 'fa-check-circle' : ($item->status === 'Rejected' ? 'fa-times-circle' : 'fa-clock');
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