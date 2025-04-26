<?php
$user_name = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$profile_pic = isset($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : 'default.png';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$email = isset($_SESSION['email']) ? $_SESSION['email'] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - HomeGenie</title>
   
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/navbar.css">
  
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/footer.css">
    <style>
        /* Payment Section */
        :root {
            --primary-color: #4A90E2;
            --secondary-color: #47B881;
            --accent-color: #E2574A;
            --text-color: #333;
            --light-gray: #f5f5f5;
            --dark-gray: #666;
        }
        .payment-section {
            padding: 4rem 2rem;
            background: var(--light-gray);
        }

        .payment-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .payment-container h2 {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--primary-color);
        }

        .payment-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-group label {
            font-weight: bold;
            color: var(--text-color);
        }

        .form-group input {
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .pay-button {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .pay-button:hover {
            background: #357abd;
        }

        .secure-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            color: var(--dark-gray);
            font-size: 0.9rem;
        }

        .amount-display {
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 2rem;
        }
    </style>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</head>

<body>
<?php require_once APPROOT . '/views/supplier/navbar/navbar.php'; ?>
    
    <section id="payment" class="payment-section">
        <div class="payment-container">
            <h2>Payment Details</h2>
            <div class="amount-display">
                Amount to Pay: $<?php echo number_format($data['grand_total'], 2); ?>
            </div>
            <form class="payment-form" action="<?php echo URLROOT; ?>/StorePageController/processPayment" method="POST">
                <input type="hidden" name="grand_total" value="<?php echo $data['grand_total']; ?>">
                <input type="hidden" name="delivery_address" value="<?php echo htmlspecialchars($data['delivery_address']); ?>">
                <input type="hidden" name="supplier_ids" value='<?php echo json_encode($_SESSION['pending_supplier_ids']); ?>'>
                <input type="hidden" name="supplier_totals" value='<?php echo json_encode($_SESSION['pending_supplier_totals']); ?>'>
                <input type="hidden" name="supplier_delivery_fees" value='<?php echo json_encode($_SESSION['pending_supplier_delivery_fees']); ?>'>
                <input type="hidden" name="supplier_grand_totals" value='<?php echo json_encode($_SESSION['pending_supplier_grand_totals']); ?>'>
                
                <div class="form-group">
                    <label>Card Number</label>
                    <input type="text" name="card_number" placeholder="1234 5678 9012 3456" maxlength="19" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Expiry Date</label>
                        <input type="text" name="expiry_date" placeholder="MM/YY" maxlength="5" required>
                    </div>
                    <div class="form-group">
                        <label>CVV</label>
                        <input type="text" name="cvv" placeholder="123" maxlength="3" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Cardholder Name</label>
                    <input type="text" name="cardholder_name" placeholder="John Doe" required>
                </div>
                <button type="submit" class="pay-button">Pay Now</button>
                <div class="secure-badge">
                    <span><i class='bx bx-lock'></i></span>
                    Secure Payment
                </div>
            </form>
        </div>
    </section>

    <script>
        // Format card number input
        document.querySelector('input[name="card_number"]').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{4})/g, '$1 ').trim();
            e.target.value = value;
        });

        // Format expiry date input
        document.querySelector('input[name="expiry_date"]').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.slice(0,2) + '/' + value.slice(2);
            }
            e.target.value = value;
        });

        // Format CVV input
        document.querySelector('input[name="cvv"]').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '');
        });
    </script>
     <?php require_once APPROOT . '/views/footer.php'; ?>
</body>

</html> 