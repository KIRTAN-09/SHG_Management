<link rel="stylesheet" href="{{ asset('css/popup.css') }}">

<div class="flex justify-center space-x-2">
    <a href="{{ route('igas.show', $row->id) }}" class="btn btn-sm btn-info">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{ route('igas.edit', $row->id) }}" class="btn btn-sm btn-warning">
        <i class="fas fa-edit"></i>
    </a>
    <form action="{{ route('igas.destroy', $row->id) }}" method="POST" style="display:inline;" onsubmit="return showDeletePopup(event, this)">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>

<div id="deletePopup" class="popup-box" style="display: none;">
    <h3>Are you sure you want to delete this IGA?</h3>
    <div class="popup-buttons">
        <button class="btn btn-cancel" onclick="closeDeletePopup()">Cancel</button>
        <button class="btn btn-confirm" id="confirmDeleteButton">Delete</button>
    </div>
</div>
<div id="popupOverlay" class="popup-overlay" style="display: none;" onclick="closeDeletePopup()"></div>

<script>
function showDeletePopup(event, form) {
    event.preventDefault();
    document.getElementById('deletePopup').style.display = 'block';
    document.getElementById('popupOverlay').style.display = 'block';

    const confirmButton = document.getElementById('confirmDeleteButton');
    confirmButton.onclick = function () {
        form.submit();
    };
}

function closeDeletePopup() {
    document.getElementById('deletePopup').style.display = 'none';
    document.getElementById('popupOverlay').style.display = 'none';
}
</script>