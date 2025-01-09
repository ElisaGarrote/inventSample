<!DOCTYPE html>
<html>
<head>
    <title>Library Management System</title>
    <!-- Use Laravel's asset helper for CSS -->
    <link rel="stylesheet" href="{{ asset('css/Admin.UserManagement.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <img src="{{ asset('assets/UNIARCHIVE.HEADER.png') }}" alt="UNARCHIVE Logo" class="logo">
        <div class="search-container">
            <input type="text" placeholder="Find user..." class="search-bar">
            <button class="clear-btn">✖</button>
        </div>

        <div class="header-icons">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Log out</button>
            </form>
        </div>
    </div>

    <!-- Title Bar -->
    <div class="title-bar">
        <span id="current-date"></span>
        <span id="current-time"></span>
    </div>

    <script>
        function updateDateTime() {
            const now = new Date();
            const date = now.toLocaleDateString('en-US');
            const time = now.toLocaleTimeString('en-US');
            document.getElementById('current-date').textContent = date;
            document.getElementById('current-time').textContent = time;
        }
        setInterval(updateDateTime, 1000);
        window.onload = updateDateTime;
    </script>

    <!-- Sidebar -->
    <div class="sidebar">
        <button onclick="window.location.href='{{ route('admin.dashboard') }}';">Dashboard</button>
        <button onclick="window.location.href='{{ route('admin.book_inventory') }}';">Book Inventory</button>
        <button onclick="window.location.href='{{ route('admin.user_management') }}';">User Management</button>
        <button onclick="window.location.href='{{ route('admin.reports') }}';">Reports</button>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Filter and Action Container -->
        <div class="filter-action-container">
            <div class="filter-bar">
                <label for="role-filter">Filter:</label>
                <input type="text" id="role-filter" placeholder="Role">
                <input type="text" id="status-filter" placeholder="Status">
                <button class="apply-btn">Apply</button>
            </div>

            <div class="action-buttons">
                <button class="add-btn" onclick="openAddModal()">Add</button>
            </div>
        </div>

        <!-- User Table -->
    <div class="user-list-container">
        <table class="user-list-table">
            <thead>
                <tr>
                    <th>User Number</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Contact Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr data-user-id="{{ $user->id }}">
                        <td>{{ $user->user_number }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->contact_number }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->status }}</td>
                        <td>
                            <button type="button" class="edit-btn" onclick="openEditUserModal({{ $user->id }})">Edit</button>
                            <button onclick="confirmDelete({{ $user->id }})">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

<!-- Add Modal -->
<div class="modal-overlay" id="add-modal">
    <div class="modal-content">
        <button class="close-btn" onclick="closeModal('add-modal')">&times;</button>
        <h2>Add New User</h2>
        <form id="add-user-form" action="{{ route('users.store') }}" method="POST">
            @csrf

            <label for="user_number">User Number:</label>
            <input type="text" id="user_number" name="user_number" placeholder="Enter user number" required><br><br>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter name" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter email" required><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter password" required><br><br>

            <label for="contact_number">Contact Number:</label>
            <input type="text" id="contact_number" name="contact_number" placeholder="Enter contact number" required><br><br>

            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="admin">Admin</option>
                <option value="faculty">Faculty</option>
            </select><br><br>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select><br><br>

            <div class="button-container">
                <button type="button" onclick="closeModal('add-modal')" class="cancel-btn">Cancel</button>
                <button type="submit" class="save-btn">Add User</button>
            </div>
        </form>
    </div>
</div>

<!--js for add user-->
    <script>
// Function to open the modal
function openAddModal() {
    document.getElementById('add-modal').style.display = 'block';
}

// Function to close the modal
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Update table with new user
function updateUserTable(user) {
    const tableBody = document.querySelector('.user-list-table tbody'); // Get table body

    // Create a new row for the user
    const row = document.createElement('tr');
    row.setAttribute('data-user-id', user.id); // Add data-user-id attribute

    row.innerHTML = `
        <td>${user.user_number}</td>
        <td>${user.name}</td>
        <td>${user.email}</td>
        <td>${user.contact_number}</td>
        <td>${user.role}</td>
        <td>${user.status}</td>
        <td>
            <button type="button" class="edit-btn" onclick="openEditUserModal(${user.id})">Edit</button>
        </td>
    `;

    // Append the new row to the table
    tableBody.appendChild(row);
}

// Handle form submission via AJAX
document.getElementById("add-user-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent default form submission

    let formData = new FormData(this); // Collect form data

    fetch("{{ route('users.store') }}", { // Send POST request to the store route
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json', // Expect JSON response
        },
    })
    .then(response => response.json()) // Parse JSON response
    .then(data => {
        if (data.success) { // If the request is successful
            alert('User added successfully!');
            closeModal('add-modal');  // Close the modal
            updateUserTable(data.user); // Add the new user to the table
        } else {
            alert('Error adding user: ' + (data.message || 'Unexpected error.'));
            console.log(data.errors); // Log errors for debugging
        }
    })
    .catch(error => { // Handle network or other errors
        console.error('Error:', error);
        alert('There was an error with the request. Please try again.');
    });
});
</script>

<!-- Edit User Modal -->
<div class="modal-overlay" id="editUserModal" style="display: none;">
    <div class="modal-content">
        <button class="close-btn" onclick="closeEditUserModal()">&times;</button>
        <h2>Edit User</h2>
        <form id="editUserForm">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" id="edit_user_id" name="id">
            
            <label for="edit_user_number">User Number</label>
            <input type="text" id="edit_user_number" name="user_number" required><br><br>

            <label for="edit_name">Name</label>
            <input type="text" id="edit_name" name="name" required><br><br>

            <label for="edit_email">Email</label>
            <input type="email" id="edit_email" name="email" required><br><br>

            <label for="edit_contact_number">Contact Number</label>
            <input type="text" id="edit_contact_number" name="contact_number" required><br><br>

            <label for="edit_role">Role</label>
            <select id="edit_role" name="role" required>
                <option value="admin">Admin</option>
                <option value="faculty">Faculty</option>
            </select><br><br>

            <label for="edit_status">Status</label>
            <select id="edit_status" name="status" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select><br><br>

            <div class="button-container">
                <button type="button" onclick="closeEditUserModal()" class="cancel-btn">Cancel</button>
                <button type="submit" class="confirm-btn">Update User</button>
            </div>
        </form>
    </div>
</div>
<script>
// Open the Edit User Modal and populate it with data
// Open the Edit User Modal and populate it with data
    function openEditUserModal(userId) {
        // Ensure userId is provided before making the request
        if (!userId) {
            alert('Invalid user ID.');
            return;
        }

        fetch(`/users/${userId}/edit`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch user details');
                }
                return response.json();
            })
            .then(user => {
                // Populate the form fields with the user data
                document.getElementById('edit_user_id').value = user.id;
                document.getElementById('edit_user_number').value = user.user_number;
                document.getElementById('edit_name').value = user.name;
                document.getElementById('edit_email').value = user.email;
                document.getElementById('edit_contact_number').value = user.contact_number;
                document.getElementById('edit_role').value = user.role;
                document.getElementById('edit_status').value = user.status;

                // Open the modal by changing display property
                document.getElementById('editUserModal').style.display = 'flex';
            })
            .catch(error => {
                console.error('Error fetching user:', error);
                alert('Failed to fetch user details. Please try again.');
            });
    }

    // Close the Edit User Modal
    function closeEditUserModal() {
        const modal = document.getElementById('editUserModal');
        modal.style.display = 'none'; // Hide the modal
        document.getElementById('editUserForm').reset(); // Reset the form fields
    }

    // Handle Update Form Submission for User
    document.getElementById('editUserForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(this);
        const userId = document.getElementById('edit_user_id').value;

        // Disable the Update button and show a loading message
        const updateButton = document.querySelector('.confirm-btn');
        updateButton.disabled = true;
        updateButton.textContent = 'Updating...';

        fetch(`/users/${userId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        })
        .then(response => response.json())
        .then(data => {
        if (data.success) {
            // Check if the row with the correct userId exists
            const updatedRow = document.querySelector(`tr[data-user-id="${userId}"]`);
            
            if (updatedRow) {
                updatedRow.innerHTML = `
                    <td>${data.user.user_number}</td>
                    <td>${data.user.name}</td>
                    <td>${data.user.email}</td>
                    <td>${data.user.contact_number}</td>
                    <td>${data.user.role}</td>
                    <td>${data.user.status}</td>
                    <td>
                        <button type="button" class="edit-btn" onclick="openEditUserModal(${data.user.id})">Edit</button>
                    </td>`;
                alert('User updated successfully');
                closeEditUserModal(); // Close the modal
            } else {
                console.error('User row not found for update.');
                alert('Failed to update the user row in the table.');
            }
        } else {
            throw new Error('Failed to update the user. Please check the server logs.');
        }
    })
});
</script>

<!-- Delete Confirmation Modal -->
<div class="modal-overlay" id="deleteModal" style="display: none;">
    <div class="modal-content">
        <button class="close-btn" onclick="closeDeleteModal()">&times;</button>
        <h2>Are you sure you want to delete this user?</h2>
        <div class="button-container">
            <button type="button" onclick="closeDeleteModal()" class="cancel-btn">Cancel</button>
            <button type="button" id="confirmDeleteBtn" class="confirm-btn">Confirm</button>
        </div>
    </div>
</div>

<!-- js for delete -->
<script>
    // Function to show the confirmation modal for deleting
    let currentUserId = '';

    function confirmDelete(userId) {
        currentUserId = userId;  // Store the current user ID
        document.getElementById("deleteModal").style.display = 'block'; // Show the modal
    }

    // Function to close the delete modal
    function closeDeleteModal() {
        document.getElementById("deleteModal").style.display = 'none'; // Hide the modal
    }

    function confirmDelete(userId) {
    console.log('Confirm delete called for user ID:', userId); // Debug
    currentUserId = userId;
    document.getElementById("deleteModal").style.display = 'block';
    }
    // Handle the confirmation action for deleting
    document.getElementById("confirmDeleteBtn").addEventListener("click", function() {
    console.log('Delete button clicked for user ID:', currentUserId); // Debug
    fetch(`/users/${currentUserId}/delete`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        console.log('Delete response:', data); // Debug
        if (data.success) {
            alert('User deleted successfully!');
            document.querySelector(`[data-user-id='${currentUserId}']`).remove();
        } else {
            alert('Error deleting user: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('There was an error with the request. Please try again.');
    });

    closeDeleteModal();
});
</script> 
</body>
</html>