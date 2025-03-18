<div class="flex justify-center space-x-2">
    <a href="{{ route('training.show', $id) }}" class="btn btn-sm btn-info">View</a>
    <a href="{{ route('training.edit', $id) }}" class="btn btn-sm btn-primary">Edit</a>
    <form action="{{ route('training.destroy', $id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
    </form>
</div>