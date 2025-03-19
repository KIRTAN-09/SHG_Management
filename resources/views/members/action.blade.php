<div class="flex justify-center space-x-2">
    <button onclick="showMemberDetails({{ $id }})" class="btn btn-info">
        <i class="fas fa-eye"></i>
    </button>
    <a href="{{ route('members.edit', $id) }}" class="btn btn-sm btn-warning">
        <i class="fas fa-edit"></i>
    </a>
    <form action="{{ route('members.destroy', $id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete(event, this)">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>
