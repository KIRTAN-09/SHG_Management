<div class="flex justify-center space-x-2">
    <a href="{{ route('igas.show', $row->id) }}" class="btn btn-sm btn-info">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{ route('igas.edit', $row->id) }}" class="btn btn-sm btn-warning">
        <i class="fas fa-edit"></i>
    </a>
    <form action="{{ route('igas.destroy', $row->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>