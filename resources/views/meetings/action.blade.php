<div class="flex justify-center space-x-2">
    <button onclick="showMeetingDetails({{ $id }})" class="btn btn-info">View</button>
        <a href="{{ route('meetings.edit', $id) }}" class="btn btn-sm btn-primary">Edit</a>
    
    <form action="{{ route('meetings.destroy', $id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete(event, this)">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
    </form>
</div>