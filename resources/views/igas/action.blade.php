<div class="btn-group" role="group" aria-label="Basic example">
    <a href="{{ route('igas.show', $row->id) }}" class="btn btn-sm btn-info">View</a>
    <a href="{{ route('igas.edit', $row->id) }}" class="btn btn-sm btn-primary">Edit</a>
    <form action="{{ route('igas.destroy', $row->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
    </form>
</div>
