<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Completed Orders</title>
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/supplierCompletedOrders.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
  <?php require APPROOT . '/views/supplier/admin/sidebar.php'; ?>

  <div class="payments-container">
    <h2><i class="fas fa-clipboard-check"></i> Completed Orders</h2>
    <table>
      <thead>
        <tr>
          <th><i class="fas fa-receipt"></i> Order ID</th>
          <th><i class="fas fa-user"></i> Customer</th>
          <th><i class="fas fa-boxes"></i> Items</th>
          <th><i class="fas fa-dollar-sign"></i> Total</th>
          <th><i class="fas fa-credit-card"></i> Payment</th>
          <th><i class="fas fa-map-marker-alt"></i> Address</th>
          <th><i class="fas fa-calendar-day"></i> Date</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($data['completedOrders'])): ?>
          <?php foreach ($data['completedOrders'] as $order): ?>
            <tr>
              <td><?php echo $order->order_id; ?></td>
              <td><?php echo $order->customer_id; ?></td>
              <td>
                <?php if (!empty($order->items) && is_array($order->items)): ?>
                  <div class="item-details">
                    <ul>
                      <?php foreach ($order->items as $item): ?>
                        <li>
                          <div class="item-attribute">
                            <strong><i class="fas fa-box"></i> </strong>
                            <span><?php echo $item->item_name; ?></span><span> x <?php echo $item->quantity; ?></span>
                          </div>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                <?php else: ?>
                  <div class="item-details">No items found</div>
                <?php endif; ?>
              </td>
              <td><?php echo number_format($order->total_amount, 2); ?></td>
              <td>
                <span class="payment-method"
                  style="background: <?php echo $order->payment_method === 'credit_card' ? '#e6f4ea' : '#ebf8ff' ?>; color: <?php echo $order->payment_method === 'credit_card' ? '#137333' : '#2b6cb0' ?>;">
                  <i class="fas fa-wallet"></i> <?php echo str_replace('_', ' ', $order->payment_method); ?>
                </span>
              </td>
              <td title="<?php echo $order->delivery_address; ?>">
                <?php echo substr($order->delivery_address, 0, 30) . '...'; ?>
              </td>
              <td><?php echo date('M j, Y', strtotime($order->created_at)); ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="7"><i class="fas fa-box-open"></i> No completed orders available</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>


  <script>
    document.querySelectorAll('.item-details').forEach(detail => {
      detail.addEventListener('click', () => {
        detail.classList.toggle('expanded');
      });
    });
  </script>
</body>

</html>