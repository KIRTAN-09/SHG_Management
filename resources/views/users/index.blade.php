@extends('layouts.app')

@section('content')
<!-- Add this line to include Font Awesome -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> -->

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2 class="text-2xl font-bold mb-4">Users Management</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success mb-2" href="{{ route('users.create') }}"><i class="fa fa-plus"></i> Create New User</a>
        </div>
        <br>
    </div>
</div>

@session('success')
    <div class="alert alert-success" role="alert"> 
        {{ $value }}
    </div>
@endsession

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
   @foreach ($data as $key => $user)
    <div class="bg-white shadow-md rounded-lg p-6">
        <h3 class="text-lg font-semibold mb-2">{{ $user->name }}</h3>
        <div class="mb-4">
          @if(!empty($user->getRoleNames()))
            @foreach($user->getRoleNames() as $v)
               <span class="inline-block bg-green-200 text-green-800 text-xs px-2 py-1 rounded">{{ $v }}</span>
            @endforeach
          @endif
        </div>
        <div class="flex space-x-2">
            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#showModal" data-username="{{ $user->name }}" data-useremail="{{ $user->email }}" data-userroles="{{ implode(', ', $user->getRoleNames()->toArray()) }}"><i class="fa-solid fa-list"></i> View</button>
            <a class="btn btn-primary btn-sm" href="{{ route('users.edit',$user->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-userid="{{ $user->id }}"><i class="fa-solid fa-trash"></i> Delete</button>
        </div>
    </div>
 @endforeach
</div>

{!! $data->links('pagination::bootstrap-5') !!}

<p class="text-center text-primary"><small> </small></p>

<!-- Show User Details Modal -->
<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showModalLabel">User Details</h5>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> <span id="modalUserName"></span></p>
                <p><strong>Email:</strong> <span id="modalUserEmail"></span></p>
                <p><strong>Roles:</strong> <span id="modalUserRoles"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this user?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var showModal = document.getElementById('showModal');
    showModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var userName = button.getAttribute('data-username');
        var userEmail = button.getAttribute('data-useremail');
        var userRoles = button.getAttribute('data-userroles');

        var modalUserName = document.getElementById('modalUserName');
        var modalUserEmail = document.getElementById('modalUserEmail');
        var modalUserRoles = document.getElementById('modalUserRoles');

        modalUserName.textContent = userName;
        modalUserEmail.textContent = userEmail;
        modalUserRoles.textContent = userRoles;
    });

    var deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var userId = button.getAttribute('data-userid');
        var form = document.getElementById('deleteForm');
        form.action = '/users/' + userId;
    });
</script>
@endsection