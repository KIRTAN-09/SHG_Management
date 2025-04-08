<link rel="stylesheet" href="{{ asset('css/popup.css') }}">

<div class="flex justify-center space-x-2">
    <button onclick="showMemberDetails({{ $id }})" class="btn btn-info">
        <i class="fas fa-eye"></i>
    </button>
    <a href="{{ route('members.edit', $id) }}" class="btn btn-sm btn-warning">
        <i class="fas fa-edit"></i>
    </a>
    <form action="{{ route('members.destroy', $id) }}" method="POST" style="display:inline;" onsubmit="return showDeletePopup(event, this)">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>

<div id="deletePopup" class="popup-box" style="display: none;">
    <h3>Are you sure you want to delete this member?</h3>
    <div class="popup-buttons">
        <button class="btn btn-cancel" onclick="closeDeletePopup()">Cancel</button>
        <button class="btn btn-confirm" id="confirmDeleteButton">Delete</button>
    </div>
</div>
<div id="popupOverlay" class="popup-overlay" style="display: none;" onclick="closeDeletePopup()"></div>

<!-- Member Details Modal -->
<div id="memberDetailsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="memberDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="memberDetailsModalLabel">Member Details</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center mb-4">
                    <img id="memberPhoto" src="" alt="Member Photo" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 2px solid #ddd;">
                </div>
                <table class="table table-bordered">
                    <tbody id="memberDetailsContent"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function showMemberDetails(id) {
    // Make an AJAX request to fetch member details
    $.ajax({
        url: '/members/' + id,
        method: 'GET',
        success: function(response) {
            // Ensure the photo path points to the correct location
            $('#memberPhoto').attr('src', response.photo ? `/storage/${response.photo}` : '/images/default-avatar.png');
            
            let detailsHtml = '';
            for (const [key, value] of Object.entries(response)) {
                if (key !== 'photo') {
                    detailsHtml += `<tr><th>${key}</th><td>${value}</td></tr>`;
                }
            }
            $('#memberDetailsContent').html(detailsHtml);
            $('#memberDetailsModal').modal('show');
        },
        error: function() {
            alert('Failed to fetch member details.');
        }
    });
}

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

// Close modal on button click
$(document).on('click', '.btn-secondary', function() {
    $('#memberDetailsModal').modal('hide');
});
</script>