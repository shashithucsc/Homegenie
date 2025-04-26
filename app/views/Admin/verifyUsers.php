<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/AdminManageUsers.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Verify Service Providers</title>
    <style>
        .id-photos {
            display: flex;
            gap: 1rem;
            margin: 1rem 0;
        }
        .id-photo {
            width: 200px;
            height: 150px;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }
        .id-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
        .action-btn {
            background-color: transparent;
            color: white;
            border: none;
            padding: 0.5rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .verify-btn {
            background-color: #4CAF50;
        }
        .reject-btn {
            background-color: #f44336;
        }
        .view-btn {
            background-color: #2196F3;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.7);
            z-index: 1000;
        }
        .modal-content {
            position: relative;
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            width: 80%;
            max-width: 800px;
            border-radius: 8px;
        }
        .close {
            position: absolute;
            right: 20px;
            top: 10px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .provider-details {
            margin-top: 1rem;
        }
        .provider-details h3 {
            margin-bottom: 0.5rem;
            font-size: 1.2rem;
        }
        .provider-details p {
            margin: 0.25rem 0;
            font-size: 0.9rem;
        }
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
        }
        .alert-error {
            background-color: #f2dede;
            color: #a94442;
            border: 1px solid #ebccd1;
        }
        table {
            font-size: 0.9rem;
        }
        .table-header h1 {
            font-size: 1.2rem;
        }
        .welcome h3 {
            font-size: 1.2rem;
        }
    </style>
</head>

<body>
    <?php require_once APPROOT . '/views/Admin/AdminSideBar.php'; ?>
    <section class="main">
        <div class="top">
            <div class="welcome">
                <span class="text">
                    <h3>Verify Service Providers</h3>
                </span>
            </div>
            <div class="time" id="clock">
            </div>
        </div>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($_GET['success']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>
        
        <div class="table" id="providers_table">
            <section class="table-header">
                <h1>Unverified Service Providers</h1>
                <div class="input-group">
                    <input type="search" placeholder="Search ..." id="searchInput">
                    <i class='bx bx-search'></i>
                </div>
            </section>
            <section class="table-body">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Expertise</th>
                            <th>ID Photos</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data['unverifiedProviders'])): ?>
                            <?php foreach ($data['unverifiedProviders'] as $provider): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($provider->user_id); ?></td>
                                    <td><?php echo htmlspecialchars($provider->first_name . ' ' . $provider->last_name); ?></td>
                                    <td><?php echo htmlspecialchars($provider->email); ?></td>
                                    <td><?php echo htmlspecialchars($provider->contact_number); ?></td>
                                    <td><?php echo htmlspecialchars($provider->expertise); ?></td>
                                    <td>
                                        <button class="action-btn view-btn" onclick="showProviderDetails(<?php echo htmlspecialchars($provider->provider_id); ?>)">
                                            <i class='bx bx-show'></i>
                                        </button>
                                    </td>
                                    <td class="action-buttons">
                                        <form action="<?php echo URLROOT; ?>/AdminController/verifyProvider/<?php echo $provider->provider_id; ?>" method="POST" style="display: inline;">
                                            <button type="submit" class="action-btn verify-btn">
                                                <i class='bx bx-check'></i>
                                            </button>
                                        </form>
                                        <form action="<?php echo URLROOT; ?>/AdminController/rejectProvider/<?php echo $provider->provider_id; ?>" method="POST" style="display: inline;">
                                            <button type="submit" class="action-btn reject-btn">
                                                <i class='bx bx-x'></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7">No unverified service providers found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </div>
    </section>

    <!-- Modal for provider details -->
    <div id="providerModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="provider-details">
                <h3>Service Provider Details</h3>
                <div id="providerInfo"></div>
                <div class="id-photos">
                    <div class="id-photo">
                        <h4>ID Front</h4>
                        <img id="idFrontImg" src="" alt="ID Front">
                    </div>
                    <div class="id-photo">
                        <h4>ID Back</h4>
                        <img id="idBackImg" src="" alt="ID Back">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo URLROOT; ?>/public/js/clock.js"></script>
    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let searchText = this.value.toLowerCase();
            let tableRows = document.querySelectorAll('tbody tr');
            
            tableRows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchText) ? '' : 'none';
            });
        });

        // Modal functionality
        const modal = document.getElementById('providerModal');
        const span = document.getElementsByClassName('close')[0];

        function showProviderDetails(providerId) {
            // Fetch provider details using AJAX
            fetch('<?php echo URLROOT; ?>/AdminController/getProviderDetails/' + providerId)
                .then(response => response.json())
                .then(provider => {
                    console.log("Provider details:", provider); // Debug log
                    
                    const providerInfo = document.getElementById('providerInfo');
                    providerInfo.innerHTML = `
                        <p><strong>Name:</strong> ${provider.first_name} ${provider.last_name}</p>
                        <p><strong>Email:</strong> ${provider.email}</p>
                        <p><strong>Contact:</strong> ${provider.contact_number}</p>
                        <p><strong>Address:</strong> ${provider.street}, ${provider.district}, ${provider.province}</p>
                        <p><strong>Expertise:</strong> ${provider.expertise}</p>
                        <p><strong>Description:</strong> ${provider.description}</p>
                        <p><strong>Working Hours:</strong> ${provider.working_hours}</p>
                        <p><strong>Service Areas:</strong> ${provider.service_areas}</p>
                        <p><strong>ID Number:</strong> ${provider.id_number}</p>
                    `;

                    // Set ID photos
                    if (provider.id_front) {
                        document.getElementById('idFrontImg').src = '<?php echo URLROOT; ?>/AdminController/getProviderImage/' + providerId + '/front';
                    } else {
                        document.getElementById('idFrontImg').src = '<?php echo URLROOT; ?>/public/img/no-image.jpg';
                    }
                    
                    if (provider.id_back) {
                        document.getElementById('idBackImg').src = '<?php echo URLROOT; ?>/AdminController/getProviderImage/' + providerId + '/back';
                    } else {
                        document.getElementById('idBackImg').src = '<?php echo URLROOT; ?>/public/img/no-image.jpg';
                    }

                    modal.style.display = 'block';
                })
                .catch(error => {
                    console.error("Error fetching provider details:", error);
                    alert("Error loading provider details. Please try again.");
                });
        }

        span.onclick = function() {
            modal.style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>

</html>