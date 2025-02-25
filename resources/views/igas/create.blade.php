@extends('layouts.app')

@section('content')
<style>
body, html {
    height: 100%;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    width: 100%;
    padding: 20px;
    box-sizing: border-box;
}

form {
    width: 100%;
    max-width: 600px;
    padding: 20px;
    border: 2px solid #343798;
    border-radius: 20px;
    box-shadow: 0px 0px 10px rgba(8, 8, 8, 0.478);
    background-color: #fff;
}

form:hover {
    box-shadow: 0px 0px 15px rgba(19, 19, 20, 0.6);
}

h1 {
    text-align: center;
    margin-bottom: 20px;
    font-weight: bold;
    color:rgb(0, 0, 0);
    font-size: 28px;
    font-style: bold;
}

label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
    color:rgb(0, 0, 0);
    font-size: 16px;
}

.radio-group {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
}

input[type="text"],
input[type="date"],
input[type="number"] {
    width: calc(100% - 16px);
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ced4da;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 14px;
    font-weight: normal; /* Ensure font is not bold */
    transition: border-color 0.3s ease-in-out;
}

input[type="text"]:focus,
input[type="date"]:focus,
input[type="number"]:focus {
    border-color: #007bff;
    outline: none;
}

input[type="date"] {
    width: calc(100% - 16px);
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
    font-size: 16px;
}

input[type="submit"] {
    background-color: #092f57;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 7px;
    cursor: pointer;
    width: 100%;
    font-size: 16px;
    display: block;
    margin: 0 auto;
    transition: background-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

input[type="submit"]:hover {
    background-color: #0056b3;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.error-message {
    font-size: 12px;
}
</style>
<div class="container">
    <form action="{{ route('igas.store') }}" method="POST">
        @csrf
        <h1>Create IGA</h1>
        <div class="form-group">
            <label for="member-id">Member id</label>
            <input type="text" class="form-control" id="member-id" name="member-id" required>
        </div>
        <div class="form-group">
            <label for="name">Members Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <select class="form-control" id="category" name="category">
                <option value="Farming">Farming</option>
                <option value="Trading">Trading</option>
                <option value="Services">Services</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="form-group">
            <label for="earned">Amount Earned</label>
            <input type="number" class="form-control" id="earned" name="earned" placeholder="Enter amount earned" required>
        </div>
        <div class="form-group">
            <label for="remarks">Remarks</label>
            <textarea class="form-control" id="remarks" name="remarks" rows="3" placeholder="Enter any remarks"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
<script>
document.getElementById('group-id-option').addEventListener('change', function() {
    document.getElementById('group-id').style.display = 'block';
    document.getElementById('group-id').setAttribute('type', 'number');
    document.getElementById('group-name').style.display = 'none';
    document.getElementById('group-id-error').style.display = 'none';
    document.getElementById('group-name-error').style.display = 'none';
});
document.getElementById('group-name-option').addEventListener('change', function() {
    document.getElementById('group-id').style.display = 'none';
    document.getElementById('group-name').style.display = 'block';
    document.getElementById('group-id-error').style.display = 'none';
    document.getElementById('group-name-error').style.display = 'none';
});

// Prevent future dates in the date of deposit field
const dateOfDeposit = document.getElementById('date-of-deposit');
const today = new Date().toISOString().split('T')[0];
dateOfDeposit.setAttribute('max', today);

// Validation for Group ID and Name inputs
document.getElementById('group-id').addEventListener('input', function() {
    const value = this.value;
    if (isNaN(value) || /[^0-9]/.test(value)) {
        document.getElementById('group-id-error').style.display = 'block';
    } else {
        document.getElementById('group-id-error').style.display = 'none';
    }
});

document.getElementById('group-name').addEventListener('input', function() {
    const value = this.value;
    if (/[^a-zA-Z]/.test(value)) {
        document.getElementById('group-name-error').style.display = 'block';
    } else {
        document.getElementById('group-name-error').style.display = 'none';
    }
});

// Validation for Member ID and Name inputs
document.getElementById('member-id').addEventListener('input', function() {
    const value = this.value;
    if (isNaN(value) || /[^0-9]/.test(value)) {
        document.getElementById('member-id-error').style.display = 'block';
    } else {
        document.getElementById('member-id-error').style.display = 'none';
    }
});

document.getElementById('member-name').addEventListener('input', function() {
    const value = this.value;
    if (/[^a-zA-Z]/.test(value)) {
        document.getElementById('member-name-error').style.display = 'block';
    } else {
        document.getElementById('member-name-error').style.display = 'none';
    }
});

// Validation for Amount input
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
