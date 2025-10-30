@extends('layouts.base')

@section('title', 'Schedules')

@section('ChildContent')
<style>
    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 20px;
    }
    .pagination button {
        border: 1px solid #d1d5db;
        background-color: white;
        color: #1f2937;
        padding: 6px 14px;
        border-radius: 6px;
        transition: all 0.2s ease;
    }
    .pagination button:hover {
        background-color: #2563eb;
        color: white;
    }
    .pagination button.active {
        background-color: #2563eb;
        color: white;
        border-color: #2563eb;
    }
    .pagination button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }
    .btn-edit {
        background-color: #e0f2fe;
        color: #0284c7;
    }
    .btn-edit:hover {
        background-color: #0284c7;
        color: white;
    }
    .btn-delete {
        background-color: #fee2e2;
        color: #dc2626;
    }
    .btn-delete:hover {
        background-color: #dc2626;
        color: white;
    }
</style>

<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Schedule Management</h2>
        <button id="add-schedule-btn"
            class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-all flex items-center">
            <i class="fas fa-plus mr-2"></i> Add Schedule
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">All Schedules</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 text-xs font-semibold uppercase text-gray-600">
                    <tr>
                        <th class="px-6 py-3 text-left">Title</th>
                        <th class="px-6 py-3 text-left">Employee</th>
                        <th class="px-6 py-3 text-left">Start Time</th>
                        <th class="px-6 py-3 text-left">End Time</th>
                        <th class="px-6 py-3 text-left">Notes</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody id="schedules-table-body" class="divide-y divide-gray-200 text-gray-700">
                    <tr>
                        <td colspan="6" class="px-6 py-6 text-center text-gray-400">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="pagination" class="pagination py-4"></div>
    </div>
</div>

<!-- MODAL -->
<div id="schedule-form-overlay"
    class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex justify-center items-center p-4">
    <div class="bg-white rounded-xl w-full max-w-2xl shadow-lg p-6 relative mx-auto">
        <button id="close-schedule-form"
            class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>

        <h3 id="form-title" class="text-xl font-semibold text-gray-800 mb-4">Add Schedule</h3>

        <form id="schedule-form" class="space-y-4">
            <input type="hidden" id="schedule_id">

            <input type="text" id="schedule_title" placeholder="Title"
                class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="schedule_start" class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                    <input type="datetime-local" id="schedule_start"
                        class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                </div>
                <div>
                    <label for="schedule_end" class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                    <input type="datetime-local" id="schedule_end"
                        class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <div>
                <label for="schedule_notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                <textarea id="schedule_notes" placeholder="Add any notes here..."
                    class="border border-gray-300 rounded-lg px-4 py-2 w-full h-24 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
            </div>

            <div>
                <label for="employee_id" class="block text-sm font-medium text-gray-700 mb-1">Employee</label>
                <select id="employee_id" class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Select Employee</option>
                    @foreach(App\Models\Employee::all() as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->first_name }} {{ $emp->last_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200">
                <button type="button" id="cancel-schedule-form"
                    class="border border-gray-300 rounded-lg px-6 py-2 hover:bg-gray-50 transition-colors">Cancel</button>
                <button type="submit"
                    class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">Save Schedule</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.getElementById('schedules-table-body');
    const paginationDiv = document.getElementById('pagination');
    const formOverlay = document.getElementById('schedule-form-overlay');
    const form = document.getElementById('schedule-form');
    const formTitle = document.getElementById('form-title');
    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    let editId = null;
    let currentPage = 1;

    async function loadSchedules(page = 1) {
        try {
            const res = await fetch(`/api/schedules?page=${page}`);
            const result = await res.json();

            if (!result.success) {
                console.error('Failed to load schedules');
                return;
            }

            // Affichage des données
            if (result.data.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-calendar-times text-4xl mb-2 text-gray-300"></i>
                            <p class="text-lg">No schedules found</p>
                            <p class="text-sm">Click "Add Schedule" to create your first schedule</p>
                        </td>
                    </tr>
                `;
            } else {
                tableBody.innerHTML = result.data.map(s => `
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-semibold">${s.title || '-'}</td>
                        <td class="px-6 py-4">${s.employee ? s.employee.first_name + ' ' + s.employee.last_name : '-'}</td>
                        <td class="px-6 py-4">${s.start_time ? new Date(s.start_time).toLocaleString() : '-'}</td>
                        <td class="px-6 py-4">${s.end_time ? new Date(s.end_time).toLocaleString() : '-'}</td>
                        <td class="px-6 py-4 max-w-xs truncate">${s.notes || '-'}</td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <button class="btn-action btn-edit" onclick="editSchedule(${s.id})">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn-action btn-delete" onclick="deleteSchedule(${s.id})">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                `).join('');
            }

            renderPagination(result.pagination);
            currentPage = page;
        } catch (error) {
            console.error('Error loading schedules:', error);
            tableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="px-6 py-6 text-center text-red-500">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Error loading schedules
                    </td>
                </tr>
            `;
        }
    }

    function renderPagination(pagination) {
        let html = '';
        if (pagination && pagination.last_page > 1) {
            html += `<button ${pagination.current_page === 1 ? 'disabled' : ''} onclick="loadSchedules(${pagination.current_page - 1})" class="pagination-btn">
                        <i class="fas fa-chevron-left mr-1"></i> Prev
                    </button>`;
            
            for (let i = 1; i <= pagination.last_page; i++) {
                html += `<button ${i === pagination.current_page ? 'class="active"' : ''} onclick="loadSchedules(${i})" class="pagination-btn">${i}</button>`;
            }
            
            html += `<button ${pagination.current_page === pagination.last_page ? 'disabled' : ''} onclick="loadSchedules(${pagination.current_page + 1})" class="pagination-btn">
                        Next <i class="fas fa-chevron-right ml-1"></i>
                    </button>`;
        }
        paginationDiv.innerHTML = html;
    }

    window.editSchedule = async (id) => {
        try {
            const res = await fetch(`/api/schedules/${id}`);
            const data = await res.json();
            if (data.success) {
                editId = id;
                const s = data.data;
                document.getElementById('schedule_title').value = s.title || '';
                document.getElementById('schedule_start').value = s.start_time ? s.start_time.replace(' ', 'T').substring(0, 16) : '';
                document.getElementById('schedule_end').value = s.end_time ? s.end_time.replace(' ', 'T').substring(0, 16) : '';
                document.getElementById('schedule_notes').value = s.notes || '';
                document.getElementById('employee_id').value = s.employee_id || '';
                
                formTitle.textContent = 'Edit Schedule';
                formOverlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        } catch (error) {
            console.error('Error editing schedule:', error);
            alert('Error loading schedule data');
        }
    };

    window.deleteSchedule = async (id) => {
        if (!confirm('Are you sure you want to delete this schedule?')) return;
        
        try {
            const res = await fetch(`/api/schedules/${id}`, {
                method: 'DELETE',
                headers: { 
                    'X-CSRF-TOKEN': csrf,
                    'Content-Type': 'application/json'
                }
            });
            
            const result = await res.json();
            if (result.success) {
                loadSchedules(currentPage);
            } else {
                alert('Error deleting schedule');
            }
        } catch (error) {
            console.error('Error deleting schedule:', error);
            alert('Error deleting schedule');
        }
    };

    // Add schedule button
    document.getElementById('add-schedule-btn').onclick = () => {
        editId = null;
        form.reset();
        formTitle.textContent = 'Add Schedule';
        formOverlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };

    // Close modal functions
    const closeModal = () => {
        formOverlay.classList.add('hidden');
        document.body.style.overflow = 'auto';
    };

    document.getElementById('close-schedule-form').onclick = closeModal;
    document.getElementById('cancel-schedule-form').onclick = closeModal;

    // Close modal when clicking outside
    formOverlay.onclick = (e) => {
        if (e.target === formOverlay) {
            closeModal();
        }
    };

    // Form submission
    form.onsubmit = async (e) => {
        e.preventDefault();
        
        const payload = {
            title: document.getElementById('schedule_title').value,
            start_time: document.getElementById('schedule_start').value,
            end_time: document.getElementById('schedule_end').value || null,
            notes: document.getElementById('schedule_notes').value || null,
            employee_id: document.getElementById('employee_id').value || null,
        };

        try {
            const url = editId ? `/api/schedules/${editId}` : '/api/schedules';
            const method = editId ? 'PUT' : 'POST';

            const res = await fetch(url, {
                method,
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': csrf 
                },
                body: JSON.stringify(payload)
            });

            const result = await res.json();
            
            if (result.success) {
                closeModal();
                loadSchedules(currentPage);
            } else {
                alert(result.message || 'Error saving schedule');
            }
        } catch (error) {
            console.error('Error saving schedule:', error);
            alert('Error saving schedule');
        }
    };

    // Escape key to close modal
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !formOverlay.classList.contains('hidden')) {
            closeModal();
        }
    });

    window.loadSchedules = loadSchedules;
    loadSchedules();
});
</script>
@endsection