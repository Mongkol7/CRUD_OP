<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Application</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #0a0f1a;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', sans-serif;
            color: #e1e8ed;
        }

        .glass-card {
            background: #1a1f2e;
            backdrop-filter: blur(10px);
            border: 1px solid #2a3441;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.4);
        }

        .liquid-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
            background: #0a0f1a;
        }

        .liquid-shape {
            position: absolute;
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
            filter: blur(80px);
            opacity: 0.3;
            animation: morph 15s ease-in-out infinite;
        }

        .liquid-shape:nth-child(1) {
            width: 400px;
            height: 400px;
            background: linear-gradient(45deg, #10b981, #059669);
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }

        .liquid-shape:nth-child(2) {
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, #34d399, #10b981);
            bottom: -150px;
            right: -150px;
            animation-delay: 3s;
        }

        .liquid-shape:nth-child(3) {
            width: 350px;
            height: 350px;
            background: linear-gradient(225deg, #059669, #047857);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: 6s;
        }

        @keyframes morph {
            0%, 100% {
                border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
                transform: rotate(0deg) scale(1);
            }
            25% {
                border-radius: 60% 40% 30% 70% / 50% 60% 40% 50%;
                transform: rotate(90deg) scale(1.1);
            }
            50% {
                border-radius: 30% 70% 50% 50% / 60% 30% 70% 40%;
                transform: rotate(180deg) scale(0.9);
            }
            75% {
                border-radius: 70% 30% 40% 60% / 40% 70% 50% 60%;
                transform: rotate(270deg) scale(1.05);
            }
        }

        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
        }

        .btn-primary {
            background: #10b981;
            color: white;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-primary:hover {
            background: #059669;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-outline {
            background: transparent;
            color: #10b981;
            border: 1px solid #10b981;
            transition: all 0.2s ease;
        }

        .btn-outline:hover {
            background: rgba(16, 185, 129, 0.1);
            transform: translateY(-1px);
        }

        .btn-edit {
            background: #10b981;
            color: white;
            padding: 6px 16px;
            border-radius: 6px;
            font-size: 0.875rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-edit:hover {
            background: #059669;
        }

        .btn-delete {
            background: #1f2937;
            color: #9ca3af;
            padding: 6px 16px;
            border-radius: 6px;
            font-size: 0.875rem;
            border: 1px solid #374151;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-delete:hover {
            background: #374151;
            color: #e5e7eb;
        }

        table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }

        .table-row {
            transition: all 0.2s ease;
        }

        .table-row:hover {
            background: rgba(16, 185, 129, 0.05);
        }

        thead tr {
            border-bottom: 1px solid #2a3441;
        }

        tbody tr {
            border-bottom: 1px solid #1f2937;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981, #059669);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
        }

        input, textarea, select {
            background: #0f1419;
            border: 1px solid #2a3441;
            color: #e1e8ed;
        }

        input::placeholder, textarea::placeholder {
            color: #6b7280;
        }

        select option {
            background: #1a1f2e;
            color: #e1e8ed;
        }

        .search-box {
            background: #0f1419;
            border: 1px solid #2a3441;
            padding: 8px 16px;
            border-radius: 8px;
            color: #e1e8ed;
            width: 100%;
            max-width: 400px;
            transition: all 0.2s ease;
        }

        .search-box:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .icon-btn {
            background: transparent;
            border: none;
            color: #6b7280;
            cursor: pointer;
            padding: 8px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .icon-btn:hover {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .form-checkbox {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            border: 1px solid #374151;
            background: #0f1419;
            cursor: pointer;
            accent-color: #10b981;
        }

        .form-checkbox:checked {
            background: #10b981;
            border-color: #10b981;
        }

        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #0f1419;
        }

        ::-webkit-scrollbar-thumb {
            background: #2a3441;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #10b981;
        }

        /* Animation for form */
        #formCard {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Loading Spinner */
        .spinner {
            border: 3px solid #2a3441;
            border-top: 3px solid #10b981;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 0.8s linear infinite;
            display: inline-block;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .btn-loading {
            opacity: 0.7;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            body {
                padding: 1rem !important;
            }

            .glass-card {
                padding: 1rem !important;
            }

            /* Stack header items on mobile */
            .header-controls {
                flex-direction: column;
                gap: 1rem;
            }

            .search-controls {
                flex-direction: column;
                width: 100%;
            }

            .search-box {
                width: 100% !important;
            }

            /* Make table responsive */
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            table {
                min-width: 600px;
            }

            /* Smaller padding on mobile */
            tbody td, thead th {
                padding: 0.75rem 0.5rem !important;
                font-size: 0.875rem;
            }

            /* Adjust button sizes */
            .btn-edit, .btn-delete {
                padding: 4px 12px !important;
                font-size: 0.75rem !important;
            }

            /* Form adjustments */
            #formCard {
                padding: 1.5rem !important;
            }

            h2 {
                font-size: 1.25rem !important;
            }

            /* Mobile-friendly inputs */
            input, textarea, select {
                font-size: 16px !important; /* Prevents zoom on iOS */
            }

            /* Liquid shapes - smaller on mobile */
            .liquid-shape:nth-child(1) {
                width: 250px !important;
                height: 250px !important;
            }

            .liquid-shape:nth-child(2) {
                width: 300px !important;
                height: 300px !important;
            }

            .liquid-shape:nth-child(3) {
                width: 200px !important;
                height: 200px !important;
            }
        }

        /* Tablet styles */
        @media (min-width: 769px) and (max-width: 1024px) {
            .glass-card {
                padding: 1.5rem !important;
            }

            table {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body class="min-h-screen p-8">
    <!-- Liquid Background -->
    <div class="liquid-bg">
        <div class="liquid-shape"></div>
        <div class="liquid-shape"></div>
        <div class="liquid-shape"></div>
    </div>

    <div class="max-w-7xl mx-auto">
        <!-- Header with Search and Add Button -->
        <div class="glass-card rounded-lg p-6 mb-6">
            <div class="flex justify-between items-center header-controls">
                <div class="flex items-center gap-4 search-controls">
                    <input type="text" placeholder="Search by name or email..." class="search-box" id="searchInput">
                </div>
                <button
                    onclick="toggleForm()"
                    class="btn-primary px-6 py-2 rounded-lg font-medium flex items-center gap-2 w-full sm:w-auto"
                    id="toggleFormBtn"
                >
                    <span>+ Add Record</span>
                </button>
            </div>
        </div>

        <!-- Create/Update Form (Hidden by default) -->
        <div id="formCard" class="glass-card rounded-lg p-8 mb-6" style="display: none;">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold" style="color: #10b981;">Add New Record</h2>
                <button onclick="toggleForm()" class="icon-btn text-2xl">&times;</button>
            </div>
            <form id="crudForm" class="space-y-4">
                <input type="hidden" id="recordId" name="id">

                <div>
                    <label class="block text-sm font-medium mb-2" style="color: #9ca3af;">Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Enter name"
                        class="w-full px-4 py-2 rounded-lg transition-all duration-200 text-sm"
                        required
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2" style="color: #9ca3af;">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Enter email"
                        class="w-full px-4 py-2 rounded-lg transition-all duration-200 text-sm"
                        required
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2" style="color: #9ca3af;">Password</label>
                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter password"
                            class="w-full px-4 py-2 rounded-lg transition-all duration-200 text-sm pr-12"
                            required
                        >
                        <button
                            type="button"
                            onclick="togglePasswordVisibility()"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2"
                            style="background: none; border: none; cursor: pointer; padding: 4px; color: #6b7280;"
                        >
                            <svg id="passwordToggleIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 justify-end pt-4">
                    <button
                        type="button"
                        onclick="resetForm()"
                        class="btn-outline px-6 py-2 rounded-lg font-medium text-sm w-full sm:w-auto"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="btn-primary px-6 py-2 rounded-lg font-medium text-sm w-full sm:w-auto"
                    >
                        Save Record
                    </button>
                </div>
            </form>
        </div>

        <!-- Records Table -->
        <div class="glass-card rounded-lg p-6">
            <div class="overflow-x-auto table-responsive">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th class="text-left py-3 px-4 text-xs font-medium uppercase tracking-wider" style="color: #6b7280;">Name</th>
                            <th class="text-left py-3 px-4 text-xs font-medium uppercase tracking-wider" style="color: #6b7280;">Email</th>
                            <th class="text-left py-3 px-4 text-xs font-medium uppercase tracking-wider" style="color: #6b7280;">Password</th>
                            <th class="text-center py-3 px-4 text-xs font-medium uppercase tracking-wider" style="color: #6b7280;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="recordsTableBody">
                        <!-- Records will be inserted here -->
                        <tr class="table-row">
                            <td colspan="4" class="text-center py-12" style="color: #6b7280;">
                                No records found. Click "+ Add Record" to create your first record.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer -->
            <div class="flex justify-between items-center mt-6 pt-4" style="border-top: 1px solid #2a3441;">
                <div class="text-sm" style="color: #9ca3af;">
                    Showing <span id="recordCount">0</span> entries
                </div>
                <div class="flex gap-2 items-center justify-center text-center text-sm font-medium ">
                    <!-- developer -->
                    <span class="text-white">DEVELOPER:</span>
                    <a href="https://github.com/Mongkol7" target="_blank" class="hover:text-green-300">SEREYMONGKOL THOEUNG</a>
                    <a href="https://github.com/Mongkol7" target="_blank" class="hover:text-green-300"><img src="https://img.icons8.com/ios/50/000000/github.png" width="30" height="30" style="filter: invert(1);" class="hover:filter-invert-0 hover:scale-110 transition-all duration-300 "/></a>
                </div>
                <!-- <div class="flex gap-2">
                    <button class="px-3 py-1 rounded text-sm" style="background: #1f2937; color: #9ca3af; border: 1px solid #374151;">1</button>
                    <button class="px-3 py-1 rounded text-sm" style="background: #1f2937; color: #9ca3af; border: 1px solid #374151;">2</button>
                </div> -->
            </div>
        </div>
    </div>

    <script>
        // Data storage
        let records = [];
        const API_URL = 'api.php';

        // Toggle form visibility
        function toggleForm() {
            const formCard = document.getElementById('formCard');
            if (formCard.style.display === 'none') {
                formCard.style.display = 'block';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } else {
                formCard.style.display = 'none';
                resetForm();
            }
        }

        // Load records from API
        async function loadRecords() {
            const tbody = document.getElementById('recordsTableBody');

            // Show loading state
            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center py-12">
                        <div class="spinner" style="margin: 0 auto 12px;"></div>
                        <div style="color: #9ca3af;">Loading records...</div>
                    </td>
                </tr>
            `;

            try {
                const response = await fetch(API_URL);
                const result = await response.json();

                if (result.success) {
                    records = result.data;
                    renderRecords();
                } else {
                    console.error('Failed to load records');
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="4" class="text-center py-12" style="color: #ef4444;">
                                Failed to load records. Please try again.
                            </td>
                        </tr>
                    `;
                }
            } catch (error) {
                console.error('Error loading records:', error);
                tbody.innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center py-12" style="color: #ef4444;">
                            Error loading records. Please check your connection.
                        </td>
                    </tr>
                `;
            }
        }

        // Handle form submission
        document.getElementById('crudForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const recordId = document.getElementById('recordId').value;
            const submitBtn = e.submitter || document.querySelector('#crudForm button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;

            // Show loading state
            submitBtn.innerHTML = '<span class="spinner"></span> <span style="margin-left: 8px;">Saving...</span>';
            submitBtn.classList.add('btn-loading');

            const formData = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                password: document.getElementById('password').value
            };

            try {
                let response;
                if (recordId) {
                    // Update existing record
                    formData.id = parseInt(recordId);
                    response = await fetch(API_URL, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(formData)
                    });
                } else {
                    // Create new record
                    response = await fetch(API_URL, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(formData)
                    });
                }

                const result = await response.json();

                if (result.success) {
                    await loadRecords();
                    resetForm();
                    toggleForm();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: recordId ? 'Record updated successfully' : 'Record created successfully',
                        background: '#1a1f2e',
                        color: '#e1e8ed',
                        confirmButtonColor: '#10b981'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: result.message,
                        background: '#1a1f2e',
                        color: '#e1e8ed',
                        confirmButtonColor: '#10b981'
                    });
                }
            } catch (error) {
                console.error('Error saving record:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to save record',
                    background: '#1a1f2e',
                    color: '#e1e8ed',
                    confirmButtonColor: '#10b981'
                });
            } finally {
                // Restore button state
                submitBtn.innerHTML = originalBtnText;
                submitBtn.classList.remove('btn-loading');
            }
        });

        // Render records table with optional search filter
        function renderRecords(searchTerm = '') {
            const tbody = document.getElementById('recordsTableBody');
            const countSpan = document.getElementById('recordCount');

            // Filter records based on search term
            let filteredRecords = records;
            if (searchTerm) {
                const search = searchTerm.toLowerCase();
                filteredRecords = records.filter(record =>
                    record.name.toLowerCase().includes(search) ||
                    record.email.toLowerCase().includes(search)
                );
            }

            countSpan.textContent = filteredRecords.length;

            if (filteredRecords.length === 0) {
                tbody.innerHTML = `
                    <tr class="table-row">
                        <td colspan="4" class="text-center py-12" style="color: #6b7280;">
                            ${searchTerm ? 'No records match your search.' : 'No records found. Click "+ Add Record" to create your first record.'}
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = filteredRecords.map((record, index) => {
                return `
                <tr class="table-row">
                    <td class="py-3 px-4 text-sm">
                        <div style="color: #e1e8ed; font-weight: 500;">${record.name}</div>
                    </td>
                    <td class="py-3 px-4 text-sm" style="color: #9ca3af;">${record.email}</td>
                    <td class="py-3 px-4 text-sm" style="color: #9ca3af;">
                        <div class="flex items-center gap-2">
                            <span id="password-${record.id}" data-password="${record.password}">••••••••</span>
                            <button
                                onclick="toggleTablePassword(${record.id})"
                                style="background: none; border: none; cursor: pointer; color: #6b7280; padding: 4px;"
                            >
                                <svg id="eye-${record.id}" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </td>
                    <td class="py-3 px-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button onclick="editRecord(${record.id})" class="btn-edit">Edit</button>
                            <button onclick="deleteRecord(${record.id})" class="btn-delete">Delete</button>
                        </div>
                    </td>
                </tr>
            `}).join('');
        }

        // Edit record
        function editRecord(id) {
            const record = records.find(r => r.id === id);
            if (record) {
                document.getElementById('recordId').value = record.id;
                document.getElementById('name').value = record.name;
                document.getElementById('email').value = record.email;
                document.getElementById('password').value = record.password;

                // Show form and scroll to it
                document.getElementById('formCard').style.display = 'block';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }

        // Delete record
        async function deleteRecord(id) {
            const result = await Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                background: '#1a1f2e',
                color: '#e1e8ed',
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#374151',
                confirmButtonText: 'Yes, delete it!'
            });

            if (result.isConfirmed) {
                // Show loading alert
                Swal.fire({
                    title: 'Deleting...',
                    html: '<div class="spinner" style="margin: 20px auto;"></div>',
                    background: '#1a1f2e',
                    color: '#e1e8ed',
                    showConfirmButton: false,
                    allowOutsideClick: false
                });

                try {
                    const response = await fetch(API_URL, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ id: id })
                    });

                    const deleteResult = await response.json();

                    if (deleteResult.success) {
                        await loadRecords();
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Record has been deleted.',
                            background: '#1a1f2e',
                            color: '#e1e8ed',
                            confirmButtonColor: '#10b981'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: deleteResult.message,
                            background: '#1a1f2e',
                            color: '#e1e8ed',
                            confirmButtonColor: '#10b981'
                        });
                    }
                } catch (error) {
                    console.error('Error deleting record:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to delete record',
                        background: '#1a1f2e',
                        color: '#e1e8ed',
                        confirmButtonColor: '#10b981'
                    });
                }
            }
        }

        // Reset form
        function resetForm() {
            document.getElementById('crudForm').reset();
            document.getElementById('recordId').value = '';
            // Reset password field to hidden state
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('passwordToggleIcon');
            passwordInput.type = 'password';
            toggleIcon.innerHTML = `
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            `;
        }

        // Toggle password visibility in form
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('passwordToggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                // Eye-off icon
                toggleIcon.innerHTML = `
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                    <line x1="1" y1="1" x2="23" y2="23"></line>
                `;
            } else {
                passwordInput.type = 'password';
                // Eye icon
                toggleIcon.innerHTML = `
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                `;
            }
        }

        // Toggle password visibility in table
        function toggleTablePassword(id) {
            const passwordSpan = document.getElementById(`password-${id}`);
            const eyeIcon = document.getElementById(`eye-${id}`);
            const actualPassword = passwordSpan.getAttribute('data-password');

            if (passwordSpan.textContent === '••••••••') {
                passwordSpan.textContent = actualPassword;
                // Eye-off icon
                eyeIcon.innerHTML = `
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                    <line x1="1" y1="1" x2="23" y2="23"></line>
                `;
            } else {
                passwordSpan.textContent = '••••••••';
                // Eye icon
                eyeIcon.innerHTML = `
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                `;
            }
        }

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value;
            renderRecords(searchTerm);
        });

        // Load records on page load
        loadRecords();
    </script>
</body>
</html>
