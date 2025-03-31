<div class="card">
    <div class="card">
    <link rel="stylesheet" href="{{ asset('css/MembeR.css') }}"><br>

    <div class="card-header">Members Report</div>
    <div class="card-body">
        <form><br>
            <div class="form-group">
                <label for="member">Select Member</label><br>
                <div class="dropdown" style="display: flex; align-items: center;">
                    <input type="text" id="member-search" class="form-control" placeholder="Search Member ID or Name" onfocus="toggleDropdown(true)" onblur="setTimeout(() => toggleDropdown(false), 200)" style="margin-right: 10px;">
                    <select id="village-filter" class="form-control" style="width: 150px;" onchange="filterByVillage()">
                        <option value="">All Villages</option>
                        @foreach($members->pluck('village')->unique()->sort() as $village)
                            <option value="{{ $village }}">{{ $village }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="member-dropdown" class="dropdown-menu" style="display: none; max-height: 200px; overflow-y: auto; border: 1px solid #ced4da; border-radius: 5px;">
                    @foreach($members as $member)
                        <div class="dropdown-item" onclick="selectMember('{{ $member->id }}', '{{ $member->member_uid }}-{{ $member->name }}')">
                            {{ $member->member_uid }}-{{ $member->name }}
                        </div>
                    @endforeach
                </div>
                <input type="hidden" id="member-id" name="member_uid" required>
            </div>
        </form>
    </div>
</div>

<div>
    <h1>Member Details:</h1>
    <table class="table table-bordered" id="all-members-table" style="display: none;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Member UID</th>
                <th>Number</th>
                <th>Name</th>
                <th>Group</th>
                <th>Village</th>
                <th>Caste</th>
                <th>Share Price</th>
                <th>Share Quantity</th>
                <th>Member Type</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $member)
                <tr>
                    <td>{{ $member->id }}</td>
                    <td>{{ $member->member_uid }}</td>
                    <td>{{ $member->number }}</td>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->group }}</td>
                    <td>{{ $member->village }}</td>
                    <td>{{ $member->caste }}</td>
                    <td>{{ $member->share_price }}</td>
                    <td>{{ $member->share_quantity }}</td>
                    <td>{{ $member->member_type }}</td>
                    <td>{{ $member->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div>
    <h1>Selected Member Details:</h1>
    <table class="table table-bordered" id="selected-member-details" style="display: none;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Member UID</th>
                <th>Number</th>
                <th>Name</th>
                <th>Group</th>
                <th>Village</th>
                <th>Caste</th>
                <th>Share Price</th>
                <th>Share Quantity</th>
                <th>Member Type</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td id="member-id-cell"></td>
                <td id="member-uid-cell"></td>
                <td id="member-number-cell"></td>
                <td id="member-name-cell"></td>
                <td id="member-group-cell"></td>
                <td id="member-village-cell"></td>
                <td id="member-caste-cell"></td>
                <td id="member-share-price-cell"></td>
                <td id="member-share-quantity-cell"></td>
                <td id="member-type-cell"></td>
                <td id="member-status-cell"></td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    function toggleDropdown(show) {
        const dropdown = document.getElementById('member-dropdown');
        dropdown.style.display = show ? 'block' : 'none';
    }

    function selectMember(id, displayName) {
        document.getElementById('member-id').value = id;
        document.getElementById('member-search').value = displayName;
        toggleDropdown(false);

        // Fetch and display the selected member's details
        fetch(`/get-member-details?member_uid=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                    return;
                }

                document.getElementById('selected-member-details').style.display = 'table';

                // Populate the selected member's details
                document.getElementById('member-id-cell').textContent = data.id;
                document.getElementById('member-uid-cell').textContent = data.member_uid;
                document.getElementById('member-number-cell').textContent = data.number;
                document.getElementById('member-name-cell').textContent = data.name;
                document.getElementById('member-group-cell').textContent = data.group;
                document.getElementById('member-village-cell').textContent = data.village;
                document.getElementById('member-caste-cell').textContent = data.caste;
                document.getElementById('member-share-price-cell').textContent = data.share_price;
                document.getElementById('member-share-quantity-cell').textContent = data.share_quantity;
                document.getElementById('member-type-cell').textContent = data.member_type;
                document.getElementById('member-status-cell').textContent = data.status;
            })
            .catch(error => console.error('Error fetching member details:', error));
    }

    function filterByVillage() {
        const selectedVillage = document.getElementById('village-filter').value.toLowerCase();
        const tableRows = Array.from(document.querySelectorAll('#all-members-table tbody tr'));

        // Filter table rows based on the selected village
        tableRows.forEach(row => {
            const villageCell = row.querySelector('td:nth-child(6)').textContent.toLowerCase(); // Village column
            row.style.display = selectedVillage === '' || villageCell === selectedVillage ? '' : 'none';
        });

        // Ensure the table remains visible
        document.getElementById('all-members-table').style.display = 'table';
    }

    document.getElementById('member-search').addEventListener('input', function () {
        const searchValue = this.value.trim().toLowerCase();
        const isNumeric = /^\d+$/.test(searchValue); // Check if the input is an integer
        const tableRows = Array.from(document.querySelectorAll('#all-members-table tbody tr'));

        // Filter table rows based on ID or name starting from the first position
        tableRows.forEach(row => {
            const idCell = row.querySelector('td:nth-child(1)').textContent.toLowerCase(); // ID column
            const nameCell = row.querySelector('td:nth-child(4)').textContent.toLowerCase(); // Name column
            const matches = isNumeric 
                ? idCell.startsWith(searchValue) // Match by ID starting from the first position
                : nameCell.startsWith(searchValue); // Match by name starting from the first position
            row.style.display = matches ? '' : 'none';
        });

        // Ensure the table remains visible
        document.getElementById('all-members-table').style.display = 'table';
    });

    document.getElementById('member-search').addEventListener('keypress', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent form submission

            const searchValue = this.value.trim().toLowerCase();
            const isNumeric = /^\d+$/.test(searchValue); // Check if the input is an integer

            // Call AJAX to fetch filtered data
            fetch(`/get-member-details?search=${searchValue}&type=${isNumeric ? 'id' : 'name'}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    // Populate the table with the fetched data
                    const tableBody = document.querySelector('#all-members-table tbody');
                    tableBody.innerHTML = '';

                    data.forEach(member => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${member.id}</td>
                            <td>${member.member_uid}</td>
                            <td>${member.number}</td>
                            <td>${member.name}</td>
                            <td>${member.group}</td>
                            <td>${member.village}</td>
                            <td>${member.caste}</td>
                            <td>${member.share_price}</td>
                            <td>${member.share_quantity}</td>
                            <td>${member.member_type}</td>
                            <td>${member.status}</td>
                        `;
                        tableBody.appendChild(row);
                    });

                    // Ensure the table remains visible
                    document.getElementById('all-members-table').style.display = 'table';
                })
                .catch(error => console.error('Error fetching filtered data:', error));
        }
    });

    // Ensure the table is always visible on page load
    document.getElementById('all-members-table').style.display = 'table';
</script>

<style>
/* Styling for the card */
.card {
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    margin: 20px;
    padding: 15px;
}

/* Styling for the card header */
.card-header {
    background-color: #f8f9fa;
    font-weight: bold;
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

/* Styling for the form group */
.form-group {
    margin-bottom: 15px;
}

/* Styling for the select dropdown */
.form-control {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

/* Styling for the table */
.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.table th, .table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.table th {
    background-color: #f8f9fa;
    font-weight: bold;
}
</style>

    <div class="card-header">Members Report</div>
    <div class="card-body">
        <form>
            <div class="form-group">
                <label for="member">Select Member</label>
                <div class="dropdown" style="display: flex; align-items: center;">
                    <input type="text" id="member-search" class="form-control" placeholder="Search Member ID or Name" onfocus="toggleDropdown(true)" onblur="setTimeout(() => toggleDropdown(false), 200)" style="margin-right: 10px;">
                    <select id="village-filter" class="form-control" style="width: 150px;" onchange="filterByVillage()">
                        <option value="">All Villages</option>
                        @foreach($members->pluck('village')->unique()->sort() as $village)
                            <option value="{{ $village }}">{{ $village }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="member-dropdown" class="dropdown-menu" style="display: none; max-height: 200px; overflow-y: auto; border: 1px solid #ced4da; border-radius: 5px;">
                    @foreach($members as $member)
                        <div class="dropdown-item" onclick="selectMember('{{ $member->id }}', '{{ $member->member_uid }}-{{ $member->name }}')">
                            {{ $member->member_uid }}-{{ $member->name }}
                        </div>
                    @endforeach
                </div>
                <input type="hidden" id="member-id" name="member_uid" required>
            </div>
        </form>
    </div>
</div>

<div>
    <h1>Member Details:</h1>
    <table class="table table-bordered" id="all-members-table" style="display: none;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Member UID</th>
                <th>Number</th>
                <th>Name</th>
                <th>Group</th>
                <th>Village</th>
                <th>Caste</th>
                <th>Share Price</th>
                <th>Share Quantity</th>
                <th>Member Type</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $member)
                <tr>
                    <td>{{ $member->id }}</td>
                    <td>{{ $member->member_uid }}</td>
                    <td>{{ $member->number }}</td>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->group }}</td>
                    <td>{{ $member->village }}</td>
                    <td>{{ $member->caste }}</td>
                    <td>{{ $member->share_price }}</td>
                    <td>{{ $member->share_quantity }}</td>
                    <td>{{ $member->member_type }}</td>
                    <td>{{ $member->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div>
    <h1>Selected Member Details:</h1>
    <table class="table table-bordered" id="selected-member-details" style="display: none;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Member UID</th>
                <th>Number</th>
                <th>Name</th>
                <th>Group</th>
                <th>Village</th>
                <th>Caste</th>
                <th>Share Price</th>
                <th>Share Quantity</th>
                <th>Member Type</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td id="member-id-cell"></td>
                <td id="member-uid-cell"></td>
                <td id="member-number-cell"></td>
                <td id="member-name-cell"></td>
                <td id="member-group-cell"></td>
                <td id="member-village-cell"></td>
                <td id="member-caste-cell"></td>
                <td id="member-share-price-cell"></td>
                <td id="member-share-quantity-cell"></td>
                <td id="member-type-cell"></td>
                <td id="member-status-cell"></td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    function toggleDropdown(show) {
        const dropdown = document.getElementById('member-dropdown');
        dropdown.style.display = show ? 'block' : 'none';
    }

    function selectMember(id, displayName) {
        document.getElementById('member-id').value = id;
        document.getElementById('member-search').value = displayName;
        toggleDropdown(false);

        // Fetch and display the selected member's details
        fetch(`/get-member-details?member_uid=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                    return;
                }

                document.getElementById('selected-member-details').style.display = 'table';

                // Populate the selected member's details
                document.getElementById('member-id-cell').textContent = data.id;
                document.getElementById('member-uid-cell').textContent = data.member_uid;
                document.getElementById('member-number-cell').textContent = data.number;
                document.getElementById('member-name-cell').textContent = data.name;
                document.getElementById('member-group-cell').textContent = data.group;
                document.getElementById('member-village-cell').textContent = data.village;
                document.getElementById('member-caste-cell').textContent = data.caste;
                document.getElementById('member-share-price-cell').textContent = data.share_price;
                document.getElementById('member-share-quantity-cell').textContent = data.share_quantity;
                document.getElementById('member-type-cell').textContent = data.member_type;
                document.getElementById('member-status-cell').textContent = data.status;
            })
            .catch(error => console.error('Error fetching member details:', error));
    }

    function filterByVillage() {
        const selectedVillage = document.getElementById('village-filter').value.toLowerCase();
        const tableRows = Array.from(document.querySelectorAll('#all-members-table tbody tr'));

        // Filter table rows based on the selected village
        tableRows.forEach(row => {
            const villageCell = row.querySelector('td:nth-child(6)').textContent.toLowerCase(); // Village column
            row.style.display = selectedVillage === '' || villageCell === selectedVillage ? '' : 'none';
        });

        // Ensure the table remains visible
        document.getElementById('all-members-table').style.display = 'table';
    }

    document.getElementById('member-search').addEventListener('input', function () {
        const searchValue = this.value.trim().toLowerCase();
        const isNumeric = /^\d+$/.test(searchValue); // Check if the input is an integer
        const tableRows = Array.from(document.querySelectorAll('#all-members-table tbody tr'));

        // Filter table rows based on ID or name starting from the first position
        tableRows.forEach(row => {
            const idCell = row.querySelector('td:nth-child(1)').textContent.toLowerCase(); // ID column
            const nameCell = row.querySelector('td:nth-child(4)').textContent.toLowerCase(); // Name column
            const matches = isNumeric 
                ? idCell.startsWith(searchValue) // Match by ID starting from the first position
                : nameCell.startsWith(searchValue); // Match by name starting from the first position
            row.style.display = matches ? '' : 'none';
        });

        // Ensure the table remains visible
        document.getElementById('all-members-table').style.display = 'table';
    });

    document.getElementById('member-search').addEventListener('keypress', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent form submission

            const searchValue = this.value.trim().toLowerCase();
            const isNumeric = /^\d+$/.test(searchValue); // Check if the input is an integer

            // Call AJAX to fetch filtered data
            fetch(`/get-member-details?search=${searchValue}&type=${isNumeric ? 'id' : 'name'}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    // Populate the table with the fetched data
                    const tableBody = document.querySelector('#all-members-table tbody');
                    tableBody.innerHTML = '';

                    data.forEach(member => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${member.id}</td>
                            <td>${member.member_uid}</td>
                            <td>${member.number}</td>
                            <td>${member.name}</td>
                            <td>${member.group}</td>
                            <td>${member.village}</td>
                            <td>${member.caste}</td>
                            <td>${member.share_price}</td>
                            <td>${member.share_quantity}</td>
                            <td>${member.member_type}</td>
                            <td>${member.status}</td>
                        `;
                        tableBody.appendChild(row);
                    });

                    // Ensure the table remains visible
                    document.getElementById('all-members-table').style.display = 'table';
                })
                .catch(error => console.error('Error fetching filtered data:', error));
        }
    });

    // Ensure the table is always visible on page load
    document.getElementById('all-members-table').style.display = 'table';
</script>

<style>
/* Styling for the card */
.card {
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    margin: 20px;
    padding: 15px;
}

/* Styling for the card header */
.card-header {
    background-color: #f8f9fa;
    font-weight: bold;
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

/* Styling for the form group */
.form-group {
    margin-bottom: 15px;
}

/* Styling for the select dropdown */
.form-control {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

/* Styling for the table */
.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.table th, .table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.table th {
    background-color: #f8f9fa;
    font-weight: bold;
}
</style>
