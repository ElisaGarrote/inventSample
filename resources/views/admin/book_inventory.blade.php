<!-- resources/views/admin/book_inventory.blade.php -->
<!-- resources/views/admin/book_inventory.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Library Management System</title>
    <link rel="stylesheet" href="{{ asset('css/Admin.BookInventory.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <img src="{{ asset('assets/UNIARCHIVE.HEADER.png') }}" alt="UNARCHIVE Logo" class="logo">
        <div class="search-container">
            <input type="text" placeholder="Find book..." class="search-bar">
            <button class="clear-btn">✖</button>
        </div>
        <div class="header-icons">
            <form action="{{ route('logout') }}" method="POST">
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
            <!-- Filter Bar -->
            <div class="filter-bar">
                <label for="title-filter">Title:</label>
                <input type="text" id="title-filter" placeholder="Enter title">
                <label for="category-filter">Category:</label>
                <input type="text" id="category-filter" placeholder="Enter category">
                <label for="researcher-filter">Researcher:</label>
                <input type="text" id="researcher-filter" placeholder="Enter researcher">
                <button class="apply-btn" onclick="applyFilters()">Apply</button>
            </div>
            <!-- Action Buttons -->
            <div class="action-buttons">
                <button type="button" onclick="openAddBookModal()">Add Book</button>
            </div>
        </div>

        <!-- Book List -->
        <div class="book-list-container">
            <table class="book-list-table">
                <thead>
                    <tr>
                        <th>Book Number</th>
                        <th>Title</th>
                        <th>Researchers</th>
                        <th>Category</th>
                        <th>Book Code</th>
                        <th>Status</th>
                        <th class="actions-header">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $book)
                        <tr data-book-id="{{ $book->id }}">
                            <td>{{ $book->book_number }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->researchers }}</td>
                            <td>{{ $book->category }}</td>
                            <td>{{ $book->book_code }}</td>
                            <td>{{ $book->status }}</td>
                            <td>
                                <button type="button" class="view-btn" onclick="openViewModal({{ $book->id }})">View</button>
                                <button type="button" class="edit-btn" onclick="openEditModal({{ $book->id }})">Edit</button>
                                <button type="button" class="archive-btn" onclick="confirmArchive({{ $book->id }})">Archive</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modals -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeViewModal()">&times;</span>
            <div id="viewBookDetails"></div>
        </div>
    </div>
    
    <script>
        function openViewModal(bookId) {
            // AJAX call to fetch the detailed information of the book
            fetch(`/admin/book/${bookId}`)
                .then(response => response.json())
                .then(data => {
                    const details = `
                        <h2>Book Details</h2>
                        <p><strong>Title:</strong> ${data.title}</p>
                        <p><strong>Researchers:</strong> ${data.researchers}</p>
                        <p><strong>Category:</strong> ${data.category}</p>
                        <p><strong>Location:</strong> ${data.location}</p>
                        <p><strong>Abstract:</strong> ${data.abstract}</p>
                        <p><strong>Book Code:</strong> ${data.book_code}</p>
                        <p><strong>Status:</strong> ${data.status}</p>
                    `;
                    document.getElementById('viewBookDetails').innerHTML = details;
                    document.getElementById('viewModal').style.display = 'block';
                })
                .catch(error => console.error('Error:', error));
        }

        function closeViewModal() {
            document.getElementById('viewModal').style.display = 'none';
        }
    </script>
</body>
</html>
<!-- Add Book Modal -->
<div class="modal-overlay" id="addBookModal" style="display: none;">
    <div class="modal-content">
        <button class="close-btn" onclick="closeModal('addBookModal')">&times;</button>
        <h2>Add New Book</h2>
        <form id="addBookForm">
            @csrf

            <label for="book_number">Book Number:</label>
            <input type="text" id="book_number" name="book_number" placeholder="Enter book number" required><br><br>

            <label for="study_title">Research Title:</label>
            <input type="text" id="study_title" name="study_title" placeholder="Enter research title" required><br><br>

            <label for="authors">Authors:</label>
            <input type="text" id="authors" name="authors" placeholder="Enter authors" required><br><br>

            <label for="categories">Category:</label>
            <select id="categories" name="categories" required>
                <option value="Science">Science</option>
                <option value="Technology">Technology</option>
                <option value="Engineering">Engineering</option>
                <option value="Mathematics">Mathematics</option>
                <option value="Arts">Arts</option>
            </select><br><br>

            <label for="restriction_codes">Restriction Code (Optional):</label>
            <input type="text" id="restriction_codes" name="restriction_codes" placeholder="Enter restricted code"><br><br>

            <div class="button-container">
                <button type="button" onclick="closeModal('addBookModal')" class="cancel-btn">Cancel</button>
                <button type="submit" class="confirm-btn">Add Book</button>
            </div>
        </form>
    </div>
</div>

<!--Add Books Js-->
<script>
// Function to open the "Add Book" modal
function openAddBookModal() {
    document.getElementById('addBookModal').style.display = 'flex'; // Show modal
}

// Function to close the "Add Book" modal
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none'; // Hide modal
}

// Handle Add Book Form submission via AJAX
document.getElementById("addBookForm").addEventListener("submit", function(event) {
    event.preventDefault();  // Prevent the default form submission

    const formData = new FormData(this);  // Collect form data
    console.log([...formData.entries()]); // Log all form data
    fetch('/books/store', {  // Send POST request to store the book
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
    })
    .then(response => response.json())  // Handle JSON response
    .then(data => {
        if (data.book) {  // If book is added successfully
            const tableBody = document.querySelector('.book-list-table tbody');  // Get the table body
            const row = `
                <tr>
                    <td>${data.book.book_number}</td>
                    <td>${data.book.study_title}</td>
                    <td>${data.book.authors}</td>
                    <td>${data.book.categories}</td>
                    <td>${data.book.restriction_codes || ''}</td>
                    <td>
                        <button type="button" class="edit-btn" onclick="openEditModal(${data.book.id})">Edit</button>
                        <button type="button" class="archive-btn" onclick="confirmArchive(${data.book.id})">Archive</button>
                    </td>
                </tr>`;
            tableBody.insertAdjacentHTML('beforeend', row);  // Insert the new row into the table

            alert('Book added successfully!');  // Show success message
            this.reset();  // Reset the form
            closeModal('addBookModal');  // Close the modal after the form is reset
        } else {
            alert('Error adding book: ' + (data.message || 'Unexpected error.'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding book. Please try again.');
    });
});
</script>

<!-- Edit Book Modal -->
<div class="modal-overlay" id="editBookModal" style="display: none;">
    <div class="modal-content">
        <button class="close-btn" onclick="closeEditModal()">&times;</button>
        <h2>Edit Research Book</h2>
        <form id="editBookForm">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" id="edit_book_id" name="id">
            
            <label for="edit_book_number">Book Number</label>
            <input type="text" id="edit_book_number" name="book_number" required><br><br>

            <label for="edit_study_title">Research Title</label>
            <input type="text" id="edit_study_title" name="study_title" required><br><br>

            <label for="edit_authors">Authors</label>
            <input type="text" id="edit_authors" name="authors" required><br><br>

            <label for="edit_categories">Category</label>
            <select id="edit_categories" name="categories" required>
                <option value="Science">Science</option>
                <option value="Technology">Technology</option>
                <option value="Engineering">Engineering</option>
                <option value="Mathematics">Mathematics</option>
                <option value="Arts">Arts</option>
            </select><br><br>

            <label for="edit_restriction_codes">Restriction Code (Optional)</label>
            <input type="text" id="edit_restriction_codes" name="restriction_codes"><br><br>

            <div class="button-container">
                <button type="button" onclick="closeEditModal()" class="cancel-btn">Cancel</button>
                <button type="submit" class="confirm-btn">Update Book</button>
            </div>
        </form>
    </div>
</div>

<!--javascript of edit-->
<script>
    function openEditModal(bookId) {
    // Fetch book details and populate the form
    fetch(`/books/${bookId}/edit`)
        .then(response => response.json())
        .then(book => {
            document.getElementById('edit_book_id').value = book.id; // Ensure this exists in the form
            document.getElementById('edit_book_number').value = book.book_number;
            document.getElementById('edit_study_title').value = book.study_title;
            document.getElementById('edit_authors').value = book.authors;
            document.getElementById('edit_categories').value = book.categories;
            document.getElementById('edit_restriction_codes').value = book.restriction_codes || '';
            document.getElementById('editBookModal').style.display = 'flex';
        })
        .catch(error => {
            console.error('Error fetching book:', error);
            alert('Failed to fetch book details. Please try again.');
        });
}

// Handle Cancel Button
function closeEditModal() {
    const modal = document.getElementById('editBookModal');
    modal.style.display = 'none'; // Hide the modal
    document.getElementById('editBookForm').reset(); // Reset the form fields
}

// Handle Update Form Submission
document.getElementById('editBookForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(this);
    const bookId = document.getElementById('edit_book_id').value;

    // Disable the Update button and show a loading message
    const updateButton = document.querySelector('.confirm-btn');
    updateButton.disabled = true;
    updateButton.textContent = 'Updating...';

    fetch(`/books/${bookId}`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
    })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw new Error(
                        `HTTP Error: ${response.status} - ${errorData.message || 'Unknown error'}`
                    );
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Update the table row with the new book data
                const updatedRow = document.querySelector(`tr[data-book-id="${bookId}"]`);
                updatedRow.innerHTML = `
                    <td>${data.book.book_number}</td>
                    <td>${data.book.study_title}</td>
                    <td>${data.book.authors}</td>
                    <td>${data.book.categories}</td>
                    <td>${data.book.restriction_codes || ''}</td>
                    <td>
                        <button type="button" class="edit-btn" onclick="openEditModal(${data.book.id})">Edit</button>
                        </td>`;
                alert('Book updated successfully');
                closeEditModal(); // Close the modal
            } else {
                throw new Error('Failed to update the book. Please check the server logs.');
            }
        })
        .catch(error => {
            console.error('Error updating book:', error);
            alert('An error occurred: ' + error.message);
        })
        .finally(() => {
            // Re-enable the Update button and restore its text
            updateButton.disabled = false;
            updateButton.textContent = 'Update Book';
        });
});
</script>

<!-- Archive Confirmation Modal -->
<div class="modal-overlay" id="archiveModal" style="display: none;">
    <div class="modal-content">
        <button class="close-btn" onclick="closeArchiveModal()">&times;</button>
        <h2>Are you sure you want to archive this book?</h2>
        <p>This action cannot be undone.</p>
        <div class="button-container">
            <button type="button" onclick="closeArchiveModal()" class="cancel-btn">Cancel</button>
            <button type="button" id="confirmArchiveBtn" class="confirm-btn">Confirm</button>
        </div>
    </div>
</div>

<script>
   // Function to show the confirmation modal for archiving
    let currentBookId = '';

    function confirmArchive(bookId) {
        currentBookId = bookId;  // Store the current book ID
        document.getElementById("archiveModal").style.display = 'block'; // Show the modal
    }

    // Function to close the archive modal
    function closeArchiveModal() {
        document.getElementById("archiveModal").style.display = 'none'; // Hide the modal
    }

    // Handle the confirmation action for archiving
    document.getElementById("confirmArchiveBtn").addEventListener("click", function() {
        window.location.href = '/books/archive/' + currentBookId; // Correct route for archiving
    });
</script>
</body>
</html>
