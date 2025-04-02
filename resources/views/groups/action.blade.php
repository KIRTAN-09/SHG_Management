<div class="flex justify-center space-x-2">
    <a href="{{ route('groups.show', $id) }}" class="btn btn-sm btn-info">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{ route('groups.edit', $id) }}" class="btn btn-sm btn-warning">
        <i class="fas fa-edit"></i>
    </a>
    <form action="{{ route('groups.destroy', $id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this group?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>