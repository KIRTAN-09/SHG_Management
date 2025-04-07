<link rel="stylesheet" href="{{ asset('css/popup.css') }}">

<div class="flex justify-center space-x-2">
    <a href="javascript:void(0)" onclick="showGroupDetails({{ $id }})" class="btn btn-sm btn-info">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{ route('groups.edit', $id) }}" class="btn btn-sm btn-warning">
        <i class="fas fa-edit"></i>
    </a>
    <form action="{{ route('groups.destroy', $id) }}" method="POST" style="display:inline;" onsubmit="return showDeletePopup(event, this)">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>

<div id="deletePopup" class="popup-box" style="display: none;">
    <h3>Are you sure you want to delete this group?</h3>
    <div class="popup-buttons">
        <button class="btn btn-cancel" onclick="closeDeletePopup()">Cancel</button>
        <button class="btn btn-confirm" id="confirmDeleteButton">Delete</button>
    </div>
</div>
<div id="popupOverlay" class="popup-overlay" style="display: none;" onclick="closeDeletePopup()"></div>

<!-- Group Details Modal -->
<div id="groupDetailsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="groupDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="groupDetailsModalLabel">Group Details</h5>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody id="groupDetailsContent"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

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

function showGroupDetails(id) {
    // Make an AJAX request to fetch group details
    $.ajax({
        url: '/groups/' + id,
        method: 'GET',
        success: function(response) {
            let detailsHtml = '';
            if (Array.isArray(response)) {
                if (response.length === 0) {
                    detailsHtml = '<tr><td colspan="2" class="text-center">No members added to this group.</td></tr>';
                } else {
                    response.forEach(group => {
                        for (const [key, value] of Object.entries(group)) {
                            detailsHtml += `<tr><th>${key}</th><td>${value || 'null'}</td></tr>`;
                        }
                    });
                }
            } else {
                for (const [key, value] of Object.entries(response)) {
                    detailsHtml += `<tr><th>${key}</th><td>${value || 'null'}</td></tr>`;
                }
            }
            $('#groupDetailsContent').html(detailsHtml);
            $('#groupDetailsModal').modal('show');
        },
        error: function() {
            alert('Failed to fetch group details.');
        }
    });
}

// Close modal on button click
$(document).on('click', '.btn-secondary', function() {
    $('#groupDetailsModal').modal('hide');
});
</script>