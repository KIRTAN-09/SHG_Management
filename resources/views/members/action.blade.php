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
<!-- Member Details Modal -->
<div id="memberDetailsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="memberDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="memberDetailsModalLabel">Member Details</h5>
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Member details will be loaded here dynamically -->
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
            // Assuming response is an object with member details
            let detailsHtml = '';
            for (const [key, value] of Object.entries(response)) {
                detailsHtml += `<tr><th>${key}</th><td>${value}</td></tr>`;
            }
            // Load the response into the table body
            $('#memberDetailsContent').html(detailsHtml);
            // Show the modal
            $('#memberDetailsModal').modal('show');
        },
        error: function() {
            alert('Failed to fetch member details.');
        }
    });
}

function confirmDelete(event, form) {
    event.preventDefault();
    if (confirm('Are you sure you want to delete this member?')) {
        form.submit();
    }
}

// Close modal on button click
$(document).on('click', '.btn-secondary', function() {
    $('#memberDetailsModal').modal('hide');
});
</script>