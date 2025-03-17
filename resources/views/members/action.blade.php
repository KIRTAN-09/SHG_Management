<div class="flex justify-center space-x-2">
    <button onclick="showMemberDetails({{ $id }})" class="btn btn-info">View</button>
    @can('member-edit')
        <a href="{{ route('members.edit', $id) }}" class="btn btn-sm btn-primary">Edit</a>
    @endcan
    <form action="{{ route('members.destroy', $id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete(event, this)">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
    </form>
</div>
