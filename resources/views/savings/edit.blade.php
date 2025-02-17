@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-2xl font-bold mb-4">Edit Saving</h1>
            <form action="{{ route('savings.update', $saving->id) }}" method="POST">
                @csrf
                @method('PUT')
                <!-- New fields -->
                <div class="mb-4">
                    <label for="member-id" class="block text-gray-700">Member ID:</label>
                    <input type="text" id="member-id" name="member-id" class="form-input mt-1 block w-full" placeholder="Enter Member ID" value="{{ $saving->member_id }}" required>
                    <span id="member-id-error" class="text-red-500 text-sm mt-1" style="display: none;">ID must be a number</span>
                </div>
                <div class="mb-4">
                    <label for="member-name" class="block text-gray-700">Member Name:</label>
                    <input type="text" id="member-name" name="member-name" class="form-input mt-1 block w-full" placeholder="Enter Member Name" value="{{ $saving->member_name }}" required>
                    <span id="member-name-error" class="text-red-500 text-sm mt-1" style="display: none;">Name must be in characters</span>
                </div>
                <div class="mb-4">
                    <label for="date-of-deposit" class="block text-gray-700">Date of Deposit:</label>
                    <input type="date" id="date-of-deposit" name="date-of-deposit" class="form-input mt-1 block w-full" value="{{ $saving->date_of_deposit }}" required>
                </div>
                <div class="mb-4">
                    <label for="amount" class="block text-gray-700">Amount:</label>
                    <input type="number" id="amount" name="amount" class="form-input mt-1 block w-full" value="{{ $saving->amount }}" required>
                    <span id="amount-error" class="text-red-500 text-sm mt-1" style="display: none;">Amount Can't Be Negative</span>
                </div>
                <input type="submit" value="Submit" class="btn btn-primary bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">    
            </form>
        </div>
    </div>
</div>
  
<script>
document.getElementById('amount').addEventListener('input', function() {
    const value = this.value;
    if (value < 0) {
        this.value = '';
        document.getElementById('amount-error').style.display = 'block';
    } else {
        document.getElementById('amount-error').style.display = 'none';
    }
});
</script>
@endsection
