<div class="flex justify-center space-x-2">
    <button onclick="showMemberDetails({{ $id }})" class="btn btn-info">
        <i class="fas fa-eye"></i>
    </button>
    <a href="{{ route('savings.edit', $id) }}" class="btn btn-sm btn-warning">
        <i class="fas fa-edit"></i>
    </a>
    <form action="{{ route('savings.destroy', $id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this saving?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>
