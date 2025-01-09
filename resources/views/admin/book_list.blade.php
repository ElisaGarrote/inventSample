<div class="book-list-container">
    <table class="book-list-table">
        <thead>
            <tr>
                <th>Book Number</th>
                <th>Research Title</th>
                <th>Authors</th>
                <th>Category</th>
                <th>Restriction Code</th>
                <th class="actions-header">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)
                <tr data-book-id="{{ $book->id }}">
                    <td>{{ $book->book_number }}</td>
                    <td>{{ $book->study_title }}</td>
                    <td>{{ $book->authors }}</td>
                    <td>{{ $book->categories }}</td>
                    <td>{{ $book->restriction_codes }}</td>
                    <td>
                        <button type="button" class="edit-btn" onclick="openEditModal({{ $book->id }})">Edit</button>
                        <button type="button" class="archive-btn" onclick="confirmArchive({{ $book->id }})">Archive</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
