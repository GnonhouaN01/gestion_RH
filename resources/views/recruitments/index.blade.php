@extends('layouts.base')

@section('title', 'Recruitment')

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

    .loading {
        opacity: 0.6;
        pointer-events: none;
    }

    .max-w-xs.truncate {
        max-width: 22rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
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
        opacity: 0.5;
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
                <h1 class="text-2xl font-bold text-gray-800 hidden lg:block">Recruitment</h1>
                <button id="add-recruitment-btn"
                    class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-600 transition-colors flex items-center">
                    <i class="fas fa-plus mr-2"></i> Add Job Opening
                </button>
            </div>

            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800">Current Job Openings</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Positions</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="recruitment_table_body" class="bg-white divide-y divide-gray-200"></tbody>
                    </table>
                </div>
            </div>

            <div id="pagination" class="pagination mt-4"></div>
        </main>
    </div>
</div>

<!-- Modal -->
<div class="form-overlay" id="recruitment-form-overlay">
    <div class="bg-white rounded-xl shadow-lg m-auto w-full max-w-2xl p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 id="form-title" class="text-xl font-bold text-gray-800">Add Job Opening</h3>
            <button id="close-recruitment-form" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times text-xl"></i></button>
        </div>

        <form id="recruitment-form" class="space-y-4">
            <input type="hidden" id="recruitment_id" name="id">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                <input type="text" id="title" name="title"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="description" name="description"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary h-24"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Positions Needed</label>
                <input type="number" id="positions_needed" name="positions_needed"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary" min="1" value="1" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select id="status" name="status"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary">
                    <option value="Open">Open</option>
                    <option value="Closed">Closed</option>
                </select>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" id="cancel-recruitment-form"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</button>
                <button type="submit" id="submit-btn"
                    class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-600">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.getElementById('recruitment_table_body');
    const paginationDiv = document.getElementById('pagination');
    const formOverlay = document.getElementById('recruitment-form-overlay');
    const form = document.getElementById('recruitment-form');
    const addBtn = document.getElementById('add-recruitment-btn');
    const closeBtn = document.getElementById('close-recruitment-form');
    const cancelBtn = document.getElementById('cancel-recruitment-form');
    const formTitle = document.getElementById('form-title');
    const submitBtn = document.getElementById('submit-btn');
    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

    let currentPage = 1;
    let perPage = 5;
    let editingId = null;

    function escapeHtml(unsafe) {
        if (!unsafe) return '';
        return String(unsafe)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    async function loadRecruitments(page = 1) {
        currentPage = page;
        tableBody.innerHTML = '<tr><td colspan="5" class="text-center py-6">Loading...</td></tr>';
        try {
            const res = await fetch(`/api/recruitments?page=${page}&per_page=${perPage}`);
            const json = await res.json();
            if (!json.success) throw new Error('API returned error');

            const items = json.data || [];
            if (items.length === 0) {
                tableBody.innerHTML =
                    '<tr><td colspan="5" class="text-center text-gray-500 py-6">No job openings found</td></tr>';
            } else {
                tableBody.innerHTML = items.map(r => `
                    <tr>
                        <td class="px-6 py-3">${escapeHtml(r.title)}</td>
                        <td class="px-6 py-3 max-w-xs truncate">${escapeHtml(r.description ?? '')}</td>
                        <td class="px-6 py-3">${r.positions_needed}</td>
                        <td class="px-6 py-3">
                            <span class="px-2 py-1 rounded-full text-xs ${r.status === 'Open' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}">${r.status}</span>
                        </td>
                        <td class="px-6 py-3 flex gap-2">
                            <button class="btn-action btn-edit" onclick="editRecruitment(${r.id})">
                                <i class="fas fa-pen"></i> Edit
                            </button>
                            <button class="btn-action btn-delete" onclick="deleteRecruitment(${r.id})">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                `).join('');
            }

            renderPagination(json.pagination || { current_page: 1, last_page: 1 });
        } catch (err) {
            console.error(err);
            tableBody.innerHTML = `<tr><td colspan="5" class="text-center text-red-500 py-6">Error loading data</td></tr>`;
            paginationDiv.innerHTML = '';
        }
    }

    function renderPagination(p) {
        const current = p.current_page || 1;
        const last = p.last_page || 1;
        let html = '';
        html += `<button ${current === 1 ? 'disabled' : ''} onclick="window.loadRecruitments(${current - 1})">Prev</button>`;
        for (let i = 1; i <= last; i++) {
            html += `<button ${i === current ? 'class="active"' : ''} onclick="window.loadRecruitments(${i})">${i}</button>`;
        }
        html += `<button ${current === last ? 'disabled' : ''} onclick="window.loadRecruitments(${current + 1})">Next</button>`;
        paginationDiv.innerHTML = html;
    }

    window.loadRecruitments = loadRecruitments;

    window.editRecruitment = async function(id) {
        const res = await fetch(`/api/recruitments/${id}`);
        const json = await res.json();
        const r = json.data;
        editingId = r.id;
        document.getElementById('title').value = r.title;
        document.getElementById('description').value = r.description || '';
        document.getElementById('positions_needed').value = r.positions_needed;
        document.getElementById('status').value = r.status;
        formTitle.textContent = 'Edit Job Opening';
        submitBtn.textContent = 'Update';
        formOverlay.classList.add('active');
    };

    window.deleteRecruitment = async function(id) {
        if (!confirm('Delete this job opening?')) return;
        await fetch(`/api/recruitments/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken }
        });
        await loadRecruitments(currentPage);
    };

    addBtn.onclick = () => {
        editingId = null;
        form.reset();
        formTitle.textContent = 'Add Job Opening';
        submitBtn.textContent = 'Save';
        formOverlay.classList.add('active');
    };

    closeBtn.onclick = cancelBtn.onclick = () => formOverlay.classList.remove('active');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const data = {
            title: title.value,
            description: description.value,
            positions_needed: positions_needed.value,
            status: status.value,
        };
        const url = editingId ? `/api/recruitments/${editingId}` : '/api/recruitments';
        const method = editingId ? 'PUT' : 'POST';
        await fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify(data)
        });
        formOverlay.classList.remove('active');
        await loadRecruitments(currentPage);
    });

    loadRecruitments(1);
});
</script>
@endsection
