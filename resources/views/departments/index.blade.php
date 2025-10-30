@extends('layouts.base')

@section('title', 'Departments')

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
        padding: 6px 12px;
        border-radius: 6px;
        transition: all 0.2s ease;
    }
    .pagination button:hover:not(:disabled) {
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
</style>

<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Departments</h1>
        <button id="add-department-btn" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors flex items-center">
            <i class="fas fa-plus mr-2"></i> Add Department
        </button>
    </div>

    <div id="department-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="text-center py-8 text-gray-500">
            <i class="fas fa-spinner fa-spin text-2xl mb-2"></i>
            <p>Loading departments...</p>
        </div>
    </div>

    <div id="pagination" class="pagination mt-6"></div>
</div>

<!-- MODAL FORM -->
<div id="department-form-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex justify-center items-center p-4">
    <div class="bg-white rounded-xl w-full max-w-md shadow-lg p-6 relative mx-auto">
        <button id="close-department-form" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>

        <h3 id="form-title" class="text-xl font-semibold text-gray-800 mb-4">Add Department</h3>

        <form id="department-form" class="space-y-4">
            <input type="hidden" id="department_id">

            <div>
                <label for="department_name" class="block text-sm font-medium text-gray-700 mb-1">Department Name</label>
                <input type="text" id="department_name" placeholder="Enter department name"
                    class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
            </div>

            <div>
                <label for="department_description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="department_description" placeholder="Enter department description"
                    class="border border-gray-300 rounded-lg px-4 py-2 w-full h-24 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200">
                <button type="button" id="cancel-department-form"
                    class="border border-gray-300 rounded-lg px-6 py-2 hover:bg-gray-50 transition-colors">Cancel</button>
                <button type="submit"
                    class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">Save Department</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const departmentList = document.getElementById('department-list');
    const paginationDiv = document.getElementById('pagination');
    const formOverlay = document.getElementById('department-form-overlay');
    const form = document.getElementById('department-form');
    const formTitle = document.getElementById('form-title');
    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    let editId = null;
    let currentPage = 1;

    async function loadDepartments(page = 1) {
        try {
            departmentList.innerHTML = `
                <div class="col-span-full text-center py-8 text-gray-500">
                    <i class="fas fa-spinner fa-spin text-2xl mb-2"></i>
                    <p>Loading departments...</p>
                </div>
            `;

            const response = await fetch(`/api/departments?page=${page}&per_page=6`);
            const result = await response.json();

            if (!result.success) {
                throw new Error('Failed to load departments');
            }

            if (result.data.length === 0) {
                departmentList.innerHTML = `
                    <div class="col-span-full text-center py-12 text-gray-500">
                        <i class="fas fa-building text-4xl mb-4 text-gray-300"></i>
                        <h3 class="text-lg font-semibold mb-2">No Departments Found</h3>
                        <p class="text-sm mb-4">Get started by creating your first department</p>
                        <button onclick="showAddForm()" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                            <i class="fas fa-plus mr-2"></i> Add Department
                        </button>
                    </div>
                `;
                paginationDiv.innerHTML = '';
                return;
            }

            departmentList.innerHTML = result.data.map(dep => `
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="font-bold text-gray-800 text-lg">${dep.name}</h3>
                        <div class="flex gap-2">
                            <button onclick="editDepartment(${dep.id})" class="text-blue-600 hover:text-blue-800 transition-colors" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteDepartment(${dep.id})" class="text-red-600 hover:text-red-800 transition-colors" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">${dep.description || 'No description provided'}</p>
                    
                    <div class="border-t border-gray-100 pt-3">
                        <h4 class="font-semibold text-sm text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-users mr-2 text-gray-400"></i>
                            Employees (${dep.employees_count || dep.employees?.length || 0})
                        </h4>
                        ${dep.employees && dep.employees.length > 0 ? `
                            <ul class="space-y-1 text-sm text-gray-600">
                                ${dep.employees.slice(0, 4).map(e => `
                                    <li class="flex justify-between items-center">
                                        <span>${e.first_name} ${e.last_name}</span>
                                        ${e.position ? `<span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">${e.position}</span>` : ''}
                                    </li>
                                `).join('')}
                            </ul>
                            ${dep.employees.length > 4 ? `
                                <p class="text-blue-600 text-xs mt-2 font-medium">
                                    + ${dep.employees.length - 4} more employees
                                </p>
                            ` : ''}
                        ` : `
                            <p class="text-gray-400 text-sm italic">No employees in this department</p>
                        `}
                    </div>
                </div>
            `).join('');

            renderPagination(result.pagination);
            currentPage = page;

        } catch (error) {
            console.error('Error loading departments:', error);
            departmentList.innerHTML = `
                <div class="col-span-full text-center py-8 text-red-500">
                    <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                    <p>Error loading departments</p>
                    <button onclick="loadDepartments()" class="mt-2 text-blue-600 hover:text-blue-800 text-sm">
                        <i class="fas fa-redo mr-1"></i> Try Again
                    </button>
                </div>
            `;
        }
    }

    function renderPagination(pagination) {
        if (!pagination || pagination.last_page <= 1) {
            paginationDiv.innerHTML = '';
            return;
        }

        let html = '';
        
        // Previous button
        html += `<button ${pagination.current_page === 1 ? 'disabled' : ''} 
            onclick="loadDepartments(${pagination.current_page - 1})"
            class="pagination-btn flex items-center">
            <i class="fas fa-chevron-left mr-1 text-xs"></i> Prev
        </button>`;

        // Page numbers
        for (let i = 1; i <= pagination.last_page; i++) {
            html += `<button onclick="loadDepartments(${i})" 
                class="pagination-btn ${pagination.current_page === i ? 'active' : ''}">
                ${i}
            </button>`;
        }

        // Next button
        html += `<button ${pagination.current_page === pagination.last_page ? 'disabled' : ''} 
            onclick="loadDepartments(${pagination.current_page + 1})"
            class="pagination-btn flex items-center">
            Next <i class="fas fa-chevron-right ml-1 text-xs"></i>
        </button>`;

        paginationDiv.innerHTML = html;
    }

    // Show add form
    window.showAddForm = () => {
        editId = null;
        form.reset();
        formTitle.textContent = 'Add Department';
        formOverlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };

    // Edit department
    window.editDepartment = async (id) => {
        try {
            const res = await fetch(`/api/departments/${id}`);
            const data = await res.json();
            
            if (data.success) {
                editId = id;
                const dep = data.data;
                document.getElementById('department_name').value = dep.name || '';
                document.getElementById('department_description').value = dep.description || '';
                
                formTitle.textContent = 'Edit Department';
                formOverlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        } catch (error) {
            console.error('Error editing department:', error);
            alert('Error loading department data');
        }
    };

    // Delete department
    window.deleteDepartment = async (id) => {
        if (!confirm('Are you sure you want to delete this department? This action cannot be undone.')) {
            return;
        }

        try {
            const res = await fetch(`/api/departments/${id}`, {
                method: 'DELETE',
                headers: { 
                    'X-CSRF-TOKEN': csrf,
                    'Content-Type': 'application/json'
                }
            });

            const result = await res.json();
            
            if (result.success) {
                loadDepartments(currentPage);
            } else {
                alert(result.message || 'Error deleting department');
            }
        } catch (error) {
            console.error('Error deleting department:', error);
            alert('Error deleting department');
        }
    };

    // Event listeners for the add button
    document.getElementById('add-department-btn').addEventListener('click', showAddForm);

    // Close modal functions
    const closeModal = () => {
        formOverlay.classList.add('hidden');
        document.body.style.overflow = 'auto';
    };

    document.getElementById('close-department-form').addEventListener('click', closeModal);
    document.getElementById('cancel-department-form').addEventListener('click', closeModal);

    // Close modal when clicking outside
    formOverlay.addEventListener('click', (e) => {
        if (e.target === formOverlay) {
            closeModal();
        }
    });

    // Form submission
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const payload = {
            name: document.getElementById('department_name').value,
            description: document.getElementById('department_description').value || null,
        };

        try {
            const url = editId ? `/api/departments/${editId}` : '/api/departments';
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
                loadDepartments(currentPage);
            } else {
                alert(result.message || 'Error saving department');
            }
        } catch (error) {
            console.error('Error saving department:', error);
            alert('Error saving department');
        }
    });

    // Escape key to close modal
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !formOverlay.classList.contains('hidden')) {
            closeModal();
        }
    });

    // Make functions globally available
    window.loadDepartments = loadDepartments;
    
    // Initial load
    loadDepartments();
});
</script>

@endsection