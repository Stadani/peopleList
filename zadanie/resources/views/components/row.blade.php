@foreach ($people as $person)
    <tr>
        <td>{{ $person['id'] }}</td>
        <td>{{ $person['name'] }}</td>
        <td>{{ $person['age'] }}</td>
        <td>{{ $person['gender'] }}</td>
        <td>
            <button class="btn btn-primary btn-sm edit-button" data-id="{{ $person['id'] }}">Edit</button>
            <button class="btn btn-danger btn-sm delete-button" data-id="{{ $person['id'] }}">Delete</button>
        </td>
    </tr>
@endforeach
