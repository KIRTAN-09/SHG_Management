<div class="container mx-auto p-4">
    <style>
        .flex {
            display: flex;
            margin-right: -190px;
            margin-left: -190px;
        }
        .form-control {
            background-color: #f9fafb;
            border: 1px solid #d1d5db;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            color: #374151;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.3);
            outline: none;
        }
        .form-control option {
            color: #374151;
        }
    </style>
    <h1 class="text-center mb-4 text-blue-600 font-bold text-2xl">Savings Report</h1>
    <div class="flex justify-center">
        <div class="w-full lg:w-3/4">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-blue-600 font-bold text-xl mb-4">Filter Savings</h3>
                <form method="GET" action="{{ route('savings.report') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="member_id" class="block text-sm font-medium text-gray-700">Member Name:</label>
                        <select name="member_id" id="member_id" class="form-control block w-full mt-1 rounded-md border-gray-300 shadow-sm">
                            <option value="">Select Member</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="group_id" class="block text-sm font-medium text-gray-700">Group Name:</label>
                        <select name="group_id" id="group_id" class="form-control block w-full mt-1 rounded-md border-gray-300 shadow-sm">
                            <option value="">Select Group</option>
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="from_date" class="block text-sm font-medium text-gray-700">From Date:</label>
                        <input type="date" name="from_date" id="from_date" class="form-control block w-full mt-1 rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="mb-4">
                        <label for="to_date" class="block text-sm font-medium text-gray-700">To Date:</label>
                        <input type="date" name="to_date" id="to_date" class="form-control block w-full mt-1 rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="mb-4">
                        <label for="year" class="block text-sm font-medium text-gray-700">Year:</label>
                        <input type="number" name="year" id="year" class="form-control block w-full mt-1 rounded-md border-gray-300 shadow-sm" placeholder="Enter Year">
                    </div>
                    <button type="submit" class="btn btn-primary bg-blue-600 text-white py-2 px-4 rounded-md">Fetch Savings</button>
                </form>
            </div>
        </div>
    </div>
</div>