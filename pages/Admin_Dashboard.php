<?php
session_start();
require_once '../classes/database.php';
require_once '../classes/vehicle.php';
require_once '../classes/reservation.php';
require_once '../classes/review.php';
require_once '../classes/category.php';
require_once '../classes/user.php';

// Initialize objects
$vehicleObj = new Vehicle();
$reservationObj = new Reservation();
$reviewObj = new Review();
$categoryObj = new Category();
$userObj = new User();  
// Fetch data for dashboard
$vehicles = $vehicleObj->ShowVehicles();
$reservations = $reservationObj->ViewReservations();
$categories = $categoryObj->viewCategories();
$reviews = $reviewObj->viewReview();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Drive & Loc</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Space Grotesk', sans-serif;
        }

        .clip-path-diagonal {
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
        }

        .car-gradient {
            background: linear-gradient(90deg, #FF0000 0%, #000000 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .car-gradient-modified {
            background: linear-gradient(90deg, #FF0000 0%, #FF0000 30%, #000000 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .diagonal-border {
            background: linear-gradient(135deg, #FF0000 0%, #000000 100%);
            transform: skew(-12deg);
        }

        .hover-grow {
            transition: transform 0.3s ease;
        }

        .hover-grow:hover {
            transform: scale(1.02) translateY(-5px);
        }

        /* Admin Specific Styles */
        .sidebar {
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background-color: #111;
            padding-top: 20px;
            z-index: 60;
        }

        .sidebar-item {
            padding: 15px 20px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .sidebar-item:hover {
            background-color: #222;
        }

        .sidebar-item.active {
            background-color: #333;
            border-left: 4px solid #FF0000;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px); /* Adjusted width */
        }

        .table-container {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .data-table th, .data-table td {
            border-bottom: 1px solid #333;
            padding: 12px 15px;
            text-align: left;
        }

        .data-table th {
            font-weight: bold;
            text-transform: uppercase;
            color: #ddd;
        }

        .action-buttons button {
            background-color: transparent;
            border: 1px solid #FF0000;
            color: #FF0000;
            padding: 8px 12px;
            margin-right: 5px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .action-buttons button:hover {
            background-color: #FF0000;
            color: #000;
        }

        .action-buttons .edit-button {
            border-color: #FFD700; /* Yellow Gold */
            color: #FFD700;
        }

        .action-buttons .edit-button:hover {
            background-color: #FFD700;
            color: #000;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #ddd;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group select,
        .form-group textarea,
        .form-group input[type="file"] {
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
        }

        .submit-button {
            background-color: #FF0000;
            color: #000;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: opacity 0.2s ease;
        }

        .submit-button:hover {
            opacity: 0.8;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #222;
            margin: 15% auto;
            padding: 30px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 8px;
            position: relative;
        }

        .close-button {
            color: #aaa;
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-button:hover,
        .close-button:focus {
            color: white;
            text-decoration: none;
            cursor: pointer;
        }

        .statistics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .statistic-card {
            background-color: #1e1e1e;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .statistic-value {
            font-size: 2em;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .statistic-label {
            text-transform: uppercase;
            font-size: 0.8em;
            color: #aaa;
        }

        /* Improved Styling for Multiple Forms in Modals */
        .form-container {
            border: 1px solid #555;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 4px;
            position: relative;
        }

        .form-container:last-child {
            margin-bottom: 0;
        }

        .remove-form-button {
            position: absolute;
            top: 5px;
            right: 10px;
            color: #aaa;
            font-size: 1.2em;
            cursor: pointer;
            background: none;
            border: none;
        }

        .remove-form-button:hover {
            color: white;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

    </style>
</head>
<body class="bg-black text-white overflow-x-hidden">
    <!-- Admin Dashboard Layout -->
    <div class="flex">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="p-6">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-3 h-12 bg-red-600"></div>
                    <span class="text-2xl font-bold tracking-wider">Drive & Loc Admin</span>
                </div>
            </div>
            <nav>
                <ul>
                    <li class="sidebar-item active" data-target="dashboard-content">
                        <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                    </li>
                    <li class="sidebar-item" data-target="reservations-content">
                        <i class="fas fa-calendar-check mr-3"></i> Reservations
                    </li>
                    <li class="sidebar-item" data-target="vehicles-content">
                        <i class="fas fa-car mr-3"></i> Vehicles
                    </li>
                    <li class="sidebar-item" data-target="categories-content">
                        <i class="fas fa-tags mr-3"></i> Categories
                    </li>
                    <li class="sidebar-item" data-target="reviews-content">
                        <i class="fas fa-star-half-alt mr-3"></i> Reviews
                    </li>
                    <li class="sidebar-item" data-target="clients-content">
                        <i class="fas fa-users mr-3"></i> Clients
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="content">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline"><?php echo $_SESSION['success']; ?></span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path fill-rule="evenodd" d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                    </span>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline"><?php echo $_SESSION['error']; ?></span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path fill-rule="evenodd" d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                    </span>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Dashboard Content -->
            <section id="dashboard-content">
                <h2 class="text-3xl font-bold mb-6">Admin Dashboard</h2>
                <div class="statistics-grid">
                    <div class="statistic-card">
                        <div class="statistic-value car-gradient"><?php echo count($reservations); ?></div>
                        <div class="statistic-label">Total Reservations</div>
                    </div>
                    <div class="statistic-card">
                        <div class="statistic-value car-gradient"><?php echo count($vehicles); ?></div>
                        <div class="statistic-label">Total Vehicles</div>
                    </div>
                    <div class="statistic-card">
                        <div class="statistic-value car-gradient"><?php echo count($categories); ?></div>
                        <div class="statistic-label">Categories</div>
                    </div>
                    <div class="statistic-card">
                        <div class="statistic-value car-gradient"><?php echo count($reviews) > 0 ? number_format(array_sum(array_column($reviews, 'rating')) / count($reviews), 1) : 0; ?></div>
                        <div class="statistic-label">Average Rating</div>
                    </div>
                </div>
            </section>

            <!-- Reservations Management -->
            <section id="reservations-content" class="hidden">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-3xl font-bold">Manage Reservations</h2>
                </div>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Client</th>
                                <th>Vehicle</th>
                                <th>From Date</th>
                                <th>To Date</th>
                                <th>Location</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservations as $reservation): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($reservation['reservation_id']); ?></td>
                                <td><?php echo htmlspecialchars($reservation['client_id']); ?></td>
                                <td><?php echo htmlspecialchars($reservation['vehicle_name']); ?></td>
                                <td><?php echo htmlspecialchars($reservation['from_date']); ?></td>
                                <td><?php echo htmlspecialchars($reservation['to_date']); ?></td>
                                <td><?php echo htmlspecialchars($reservation['location']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Vehicle Management -->
            <section id="vehicles-content" class="hidden">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-3xl font-bold">Manage Vehicles</h2>
                    <button class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" id="add-vehicle-button">
                        Add Vehicle
                    </button>
                </div>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Model</th>
                                <th>Category</th>
                                <th>Picture</th>
                                <th>Price per Day</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($vehicles as $vehicle): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($vehicle['vehicle_id']); ?></td>
                                <td><?php echo htmlspecialchars($vehicle['vehicle_name']); ?></td>
                                <td><?php echo htmlspecialchars($vehicle['model']); ?></td>
                                <td><img src="../assets/images/<?php echo htmlspecialchars($vehicle['picture']); ?>" alt="<?php echo htmlspecialchars($vehicle['vehicle_name']); ?>" width="50"></td>
                                <td><?php echo htmlspecialchars($vehicle['price']); ?></td>
                                <td class="action-buttons">
                                    <button class="edit-vehicle edit-button" data-id="<?php echo $vehicle['vehicle_id']; ?>">Edit</button>
                                    <form action="../controllers/vehicle_controller.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="vehicle_id" value="<?php echo $vehicle['vehicle_id']; ?>">
                                        <button type="submit" data-delete-form class="delete-vehicle">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Add Vehicle Modal -->
                <div id="add-vehicle-modal" class="modal">
                    <div class="modal-content">
                        <span class="close-button">×</span>
                        <h2 class="text-2xl font-bold mb-4">Add New Vehicles</h2>
                        <form id="add-vehicle-form" action="../controllers/vehicle_controller.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="add">
                            <div id="vehicle-forms-container">
                                <div class="form-container">
                                    <div class="form-group">
                                        <label for="vehicle_name">Vehicle Name</label>
                                        <input type="text" name="vehicle_name[]" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="model">Model</label>
                                        <input type="text" name="model[]" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="category_id">Category</label>
                                        <select name="category_id[]" required>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?php echo htmlspecialchars($category['category_id']); ?>">
                                                    <?php echo htmlspecialchars($category['category_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Price per Day</label>
                                        <input type="number" name="price[]" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="picture">Vehicle Picture</label>
                                        <input type="file" name="picture[]" accept="image/*">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-actions">
                                <button type="button" id="add-more-vehicles" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add More</button>
                                <button type="submit" class="submit-button">Add Vehicle(s)</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

            <!-- Category Management -->
            <section id="categories-content" class="hidden">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-3xl font-bold">Manage Categories</h2>
                    <button class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" id="add-category-button">
                        Add Category
                    </button>
                </div>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($category['category_id']); ?></td>
                                <td><?php echo htmlspecialchars($category['category_name']); ?></td>
                                <td class="action-buttons">
                                    <button class="edit-category edit-button" data-id="<?php echo $category['category_id']; ?>">Edit</button>
                                    <form action="../controllers/category_controller.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="category_id" value="<?php echo $category['category_id']; ?>">
                                        <button type="submit" data-delete-form class="delete-category">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Add Category Modal -->
                <div id="add-category-modal" class="modal">
                    <div class="modal-content">
                        <span class="close-button">×</span>
                        <h2 class="text-2xl font-bold mb-4">Add New Categories</h2>
                        <form id="add-category-form" action="../controllers/category_controller.php" method="POST">
                            <input type="hidden" name="action" value="add">
                            <div id="category-forms-container">
                                <div class="form-container">
                                    <div class="form-group">
                                        <label for="category_name">Category Name</label>
                                        <input type="text" name="category_name[]" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-actions">
                                <button type="button" id="add-more-categories" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add More</button>
                                <button type="submit" class="submit-button">Add Category(s)</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

            <!-- Reviews Management -->
            <section id="reviews-content" class="hidden">
                <h2 class="text-3xl font-bold mb-6">Manage Reviews</h2>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Vehicle</th>
                                <th>Client</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reviews as $review): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($review['review_id']); ?></td>
                                <td><?php echo htmlspecialchars($review['user_id']); ?></td>
                                <td><?php echo htmlspecialchars($review['content']); ?></td>
                                <td class="action-buttons">
                                    <button class="delete-review" data-id="<?php echo $review['review_id']; ?>">Delete</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Client Management -->
            <section id="clients-content" class="hidden">
                <h2 class="text-3xl font-bold mb-6">Manage Clients</h2>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Registration Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>401</td>
                                <td>John Doe</td>
                                <td>john.doe@example.com</td>
                                <td>2024-12-20</td>
                                <td><button class="view-client" data-id="401">View</button></td>
                            </tr>
                            <tr>
                                <td>402</td>
                                <td>Jane Smith</td>
                                <td>jane.smith@example.com</td>
                                <td>2024-12-25</td>
                                <td><button class="view-client" data-id="402">View</button></td>
                            </tr>
                            <!-- More client rows will go here -->
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Tab switching functionality
            function setupTabs() {
                const sidebarItems = document.querySelectorAll('.sidebar-item');
                const contentSections = document.querySelectorAll('.content > section');

                function showSection(targetId) {
                    contentSections.forEach(section => section.classList.add('hidden'));
                    document.getElementById(targetId).classList.remove('hidden');
                }

                function setActive(selectedItem) {
                    sidebarItems.forEach(item => item.classList.remove('active'));
                    selectedItem.classList.add('active');
                }

                sidebarItems.forEach(item => {
                    item.addEventListener('click', function() {
                        const target = this.getAttribute('data-target');
                        showSection(target);
                        setActive(this);
                    });
                });

                // Show dashboard by default
                showSection('dashboard-content');
                setActive(document.querySelector('.sidebar-item[data-target="dashboard-content"]'));
            }

            // Modal functionality
            function setupModals() {
                function setupModal(modalId, buttonId) {
                    const modal = document.getElementById(modalId);
                    const btn = document.getElementById(buttonId);
                    const closeBtn = modal.querySelector('.close-button');

                    btn.onclick = () => modal.style.display = "block";
                    closeBtn.onclick = () => modal.style.display = "none";
                    window.onclick = (e) => {
                        if (e.target == modal) modal.style.display = "none";
                    };
                }

                setupModal('add-vehicle-modal', 'add-vehicle-button');
                setupModal('add-category-modal', 'add-category-button');
            }

            // Delete confirmation handlers
            function setupDeleteHandlers() {
                document.querySelectorAll('[data-delete-form]').forEach(button => {
                    button.addEventListener('click', function(e) {
                        if (!confirm('Are you sure you want to delete this item?')) {
                            e.preventDefault();
                        }
                    });
                });
            }

            // Dynamic form handling for vehicles
            document.getElementById('add-more-vehicles').addEventListener('click', function() {
                const container = document.getElementById('vehicle-forms-container');
                const newForm = container.firstElementChild.cloneNode(true);
                // Clear input values in the new form
                newForm.querySelectorAll('input[type="text"], input[type="number"], input[type="file"]').forEach(input => input.value = '');
                // Add remove button to dynamically added forms
                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.classList.add('remove-form-button');
                removeButton.innerHTML = '×';
                removeButton.addEventListener('click', function() {
                    container.removeChild(newForm);
                });
                newForm.appendChild(removeButton);
                container.appendChild(newForm);
            });

            // Dynamic form handling for categories
            document.getElementById('add-more-categories').addEventListener('click', function() {
                const container = document.getElementById('category-forms-container');
                const newForm = container.firstElementChild.cloneNode(true);
                // Clear input values in the new form
                newForm.querySelectorAll('input[type="text"], input[type="file"]').forEach(input => input.value = '');
                // Add remove button
                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.classList.add('remove-form-button');
                removeButton.innerHTML = '×';
                removeButton.addEventListener('click', function() {
                    container.removeChild(newForm);
                });
                newForm.appendChild(removeButton);
                container.appendChild(newForm);
            });

            // Initialize all functionality
            setupTabs();
            setupModals();
            setupDeleteHandlers();
        });
    </script>

</body>
</html>