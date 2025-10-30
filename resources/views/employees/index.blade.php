@extends('layouts.base')

@section('title', 'Employees')

@section('ChildContent')
<style>
    .form-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 40;
        justify-content: center;
        align-items: center;
    }

    .form-overlay.active {
        display: flex;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 6px;
        margin-top: 20px;
    }

    .pagination button {
        border: 1px solid #ccc;
        background: #fff;
        padding: 6px 12px;
        border-radius: 6px;
        cursor: pointer;
    }

    .pagination button.active {
        background: #2563eb;
        color: #fff;
    }

    .pagination button:disabled {
        opacity: .5;
        cursor: not-allowed;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.25s ease-in-out;
    }

    .btn-edit {
        background-color: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
    }

    .btn-edit:hover {
        background-color: #0284c7;
        color: white;
        transform: scale(1.05);
    }

    .btn-delete {
        background-color: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    .btn-delete:hover {
        background-color: #dc2626;
        color: white;
        transform: scale(1.05);
    }
</style>

<div class="flex h-screen">
    <div class="flex-1 flex flex-col overflow-hidden lg:ml-0">
        <main class="flex-1 overflow-y-auto p-4 md:p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 hidden lg:block">Employee Management</h1>
                <button id="add-employee-btn"
                    class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-blue-600 flex items-center">
                    <i class="fas fa-plus mr-2"></i> Add Employee
                </button>
            </div>

            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800">All Employees</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Position</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="employee_table_body" class="bg-white divide-y divide-gray-200"></tbody>
                    </table>
                </div>
            </div>

            <div id="pagination" class="pagination"></div>
        </main>
    </div>
</div>

<!-- Modal -->
<div class="form-overlay" id="employee-form-overlay">
    <div class="bg-white rounded-xl shadow-lg m-auto w-full max-w-3xl p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 id="form-title" class="text-xl font-bold text-gray-800">Add Employee</h3>
            <button id="close-employee-form" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form id="employee-form" class="space-y-4">
            <input type="hidden" id="employee_id">

            <div class="grid grid-cols-2 gap-4">
                <input type="text" id="first_name" placeholder="First name" class="border rounded p-2" required>
                <input type="text" id="last_name" placeholder="Last name" class="border rounded p-2" required>
            </div>

            <input type="email" id="email" placeholder="Email" class="border rounded p-2 w-full" required>
            <input type="text" id="phone" placeholder="Phone" class="border rounded p-2 w-full">

            <div class="grid grid-cols-2 gap-4">
                <input type="text" id="position" placeholder="Position" class="border rounded p-2" required>
                <input type="text" id="department" placeholder="Department" class="border rounded p-2" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <select id="gender" class="border rounded p-2">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                <input type="date" id="hire_date" class="border rounded p-2" required>
            </div>

            <input type="number" id="salary" step="0.01" placeholder="Salary" class="border rounded p-2 w-full" required>

            <select id="status" class="border rounded p-2 w-full">
                <option value="Active">Active</option>
                <option value="On Leave">On Leave</option>
                <option value="Inactive">Inactive</option>
            </select>

            <div class="flex justify-end gap-3 mt-4">
                <button type="button" id="cancel-employee-form" class="px-4 py-2 border rounded">Cancel</button>
                <button type="submit" id="submit-btn" class="px-4 py-2 bg-primary text-white rounded">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const body = document.getElementById('employee_table_body');
    const formOverlay = document.getElementById('employee-form-overlay');
    const form = document.getElementById('employee-form');
    const addBtn = document.getElementById('add-employee-btn');
    const closeBtn = document.getElementById('close-employee-form');
    const cancelBtn = document.getElementById('cancel-employee-form');
    const paginationDiv = document.getElementById('pagination');
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let editId = null, page = 1;

    async function loadEmployees(p = 1) {
        const res = await fetch(`/api/employees?page=${p}`);
        const j = await res.json();
        if (j.success) {
            body.innerHTML = j.data.map(e => `
                <tr>
                    <td class="px-6 py-3">${e.first_name} ${e.last_name}</td>
                    <td class="px-6 py-3">${e.email}</td>
                    <td class="px-6 py-3">${e.department}</td>
                    <td class="px-6 py-3">${e.position}</td>
                    <td class="px-6 py-3">
                        <span class="px-2 py-1 rounded-full text-xs ${e.status==='Active' ? 'bg-green-100 text-green-700' : e.status==='On Leave' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700'}">${e.status}</span>
                    </td>
                    <td class="px-6 py-3 flex gap-2">
                        <button onclick="editEmployee(${e.id})" class="btn-action btn-edit">
                            <i class="fas fa-pen"></i> Edit
                        </button>
                        <button onclick="deleteEmployee(${e.id})" class="btn-action btn-delete">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </td>
                </tr>`).join('');
            renderPagination(j.pagination);
        }
    }

    function renderPagination(p) {
        let html = '';
        for (let i = 1; i <= p.last_page; i++) {
            html += `<button ${i===p.current_page?'class="active"':''} onclick="loadEmployees(${i})">${i}</button>`;
        }
        paginationDiv.innerHTML = html;
    }

    window.editEmployee = async id => {
        const r = await fetch(`/api/employees/${id}`);
        const j = await r.json();
        if (j.success) {
            const e = j.data;
            editId = id;
            for (const [k, v] of Object.entries(e)) {
                if (document.getElementById(k)) document.getElementById(k).value = v ?? '';
            }
            formOverlay.classList.add('active');
        }
    };

    window.deleteEmployee = async id => {
        if (!confirm('Delete this employee?')) return;
        await fetch(`/api/employees/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrf }
        });
        loadEmployees(page);
    };

    addBtn.onclick = () => {
        editId = null;
        form.reset();
        formOverlay.classList.add('active');
    };
    closeBtn.onclick = cancelBtn.onclick = () => formOverlay.classList.remove('active');

    form.onsubmit = async e => {
        e.preventDefault();
        const data = Object.fromEntries(new FormData(form).entries());
        const url = editId ? `/api/employees/${editId}` : '/api/employees';
        const method = editId ? 'PUT' : 'POST';
        await fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
            body: JSON.stringify(data)
        });
        formOverlay.classList.remove('active');
        loadEmployees(page);
    };

    window.loadEmployees = loadEmployees;
    loadEmployees();
});
</script>
@endsection
