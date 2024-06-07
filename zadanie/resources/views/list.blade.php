<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>People List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="my-4">People List</h1>
    <div class="form-group">
        <input type="text" id="search-input" class="form-control" placeholder="Search by name, age, or gender">
    </div>
    <button id="search-button" class="btn btn-primary mb-3">Search</button>
    <table class="table table-striped">
        <thead>

{{--        modal--}}
        <div class="modal" id="edit-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Person</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="edit-form">
                            <input type="hidden" name="id" id="edit-id">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="form-group">
                                <label for="age">Age:</label>
                                <input type="number" class="form-control" name="age">
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender:</label>
                                <select class="form-control" name="gender">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="save-edit">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>


        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="people-table-body">

        <x-row :people="$people" />


        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    //get data
    $(document).ready(function () {
        $('#search-button').click(function () {
            $.ajax({
                url: '{{ route('index') }}',
                type: 'GET',
                data: {
                    search: $('#search-input').val()
                },
                success: function (data) {
                    $('#people-table-body').html(data.rowView);
                }
            });
        });
    });
</script>
<script>
    // delete data
    $(document).ready(function () {
        $(document).on('click', '.delete-button', function () {
            var id = $(this).data('id');
            var tr = $(this).closest('tr');
            $.ajax({
                url: '/people/' + id,
                type: 'DELETE',
                success: function (data) {
                    tr.remove();
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        $(document).on('click', '.edit-button', function () {
            var id = $(this).data('id');
            $.ajax({
                url: '/people/' + id + '/edit',
                type: 'GET',
                success: function (data) {
                    if (data.person) {
                        var person = data.person;
                        $('#edit-id').val(person.id);
                        $('#edit-form [name="name"]').val(person.name);
                        $('#edit-form [name="age"]').val(person.age);
                        $('#edit-form [name="gender"]').val(person.gender);
                        $('#edit-modal').modal('show');
                    }
                }
            });
        });

        // save data
        $('#save-edit').click(function () {
            var id = $('#edit-id').val();
            $.ajax({
                url: '/people/' + id,
                type: 'PUT',
                data: $('#edit-form').serialize(),
                success: function (data) {
                    if (data.message) {
                        $('#edit-modal').modal('hide');
                        location.reload();
                    } else if (data.error) {
                        alert(data.error);
                    }
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    });

</script>


</body>
</html>
