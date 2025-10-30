@extends('layouts.base')

@section('title', 'Recruitment')

@section('ChildContent')

    <style>
        .sidebar {
            transition: transform 0.3s ease-in-out;
            transform: translateX(-100%);
            width: 256px;
        }
        .sidebar.active {
            transform: translateX(0);
        }
        @media (min-width: 1024px) {
            .sidebar {
                transform: translateX(0);
                position: sticky;
                top: 0;
            }
        }
        .settings-card {
            transition: all 0.3s ease;
        }
        .settings-card:hover {
            transform: translateY(-2px);
        }
        .toggle-checkbox:checked {
            right: 0;
            border-color: #EF4444;
        }
        .toggle-checkbox:checked + .toggle-label {
            background-color: #EF4444;
        }
    </style>


    <div class="flex-1 flex flex-col overflow-x-hidden overflow-y-auto">

        <!-- contenu principal -->
        <main class="p-4 md:p-8">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Settings</h2>
                <p class="text-gray-600">Manage your account settings and preferences</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- colonne de gauche - Navigation -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <nav class="space-y-2">
                            <a href="#profile" class="flex items-center px-4 py-3 bg-whr-active text-whr-red rounded-xl font-semibold transition duration-200 settings-nav-link">
                                <i class="fas fa-user w-6 mr-3"></i>
                                <span>Profile</span>
                            </a>
                            <a href="#security" class="flex items-center px-4 py-3 text-gray-700 hover:bg-whr-active hover:text-whr-red rounded-xl transition duration-200 settings-nav-link">
                                <i class="fas fa-shield-alt w-6 mr-3"></i>
                                <span>Security</span>
                            </a>
                            <a href="#notifications" class="flex items-center px-4 py-3 text-gray-700 hover:bg-whr-active hover:text-whr-red rounded-xl transition duration-200 settings-nav-link">
                                <i class="fas fa-bell w-6 mr-3"></i>
                                <span>Notifications</span>
                            </a>
                            <a href="#preferences" class="flex items-center px-4 py-3 text-gray-700 hover:bg-whr-active hover:text-whr-red rounded-xl transition duration-200 settings-nav-link">
                                <i class="fas fa-palette w-6 mr-3"></i>
                                <span>Preferences</span>
                            </a>
                            <a href="#system" class="flex items-center px-4 py-3 text-gray-700 hover:bg-whr-active hover:text-whr-red rounded-xl transition duration-200 settings-nav-link">
                                <i class="fas fa-cog w-6 mr-3"></i>
                                <span>System</span>
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- colonne de droite -->
                <div class="lg:col-span-2">
                    <!-- Profile Section -->
                    <div id="profile" class="settings-section">
                        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-6">Profile Settings</h3>
                            
                            <div class="flex items-center space-x-6 mb-6">
                                <div class="relative">
                                    <div class="w-20 h-20 rounded-full overflow-hidden bg-gray-200">
                                        <img src="https://i.pravatar.cc/150?img=1" alt="Profile" class="w-full h-full object-cover">
                                    </div>
                                    <button class="absolute bottom-0 right-0 w-6 h-6 bg-whr-red rounded-full flex items-center justify-center">
                                        <i class="fas fa-camera text-white text-xs"></i>
                                    </button>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Admira John</h4>
                                    <p class="text-gray-600 text-sm">HR Manager</p>
                                    <button class="text-whr-red text-sm font-semibold hover:text-red-700 mt-1">
                                        Change Avatar
                                    </button>
                                </div>
                            </div>

                            <form class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                        <input type="text" value="Admira" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-whr-red focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                        <input type="text" value="John" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-whr-red focus:border-transparent">
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" value="admira.john@company.com" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-whr-red focus:border-transparent">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                    <input type="tel" value="+1 (555) 123-4567" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-whr-red focus:border-transparent">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                                    <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-whr-red focus:border-transparent">
                                        <option>Human Resources</option>
                                        <option>IT Department</option>
                                        <option>Finance</option>
                                        <option>Marketing</option>
                                    </select>
                                </div>

                                <div class="flex justify-end pt-4">
                                    <button type="submit" class="bg-whr-red text-white px-6 py-2 rounded-lg font-semibold hover:bg-red-600 transition-colors">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Securite -->
                    <div id="security" class="settings-section hidden">
                        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-6">Security Settings</h3>
                            
                            <div class="space-y-6">
                                <div class="flex justify-between items-center p-4 border border-gray-200 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Change Password</h4>
                                        <p class="text-gray-600 text-sm">Last changed 3 months ago</p>
                                    </div>
                                    <button class="text-whr-red font-semibold hover:text-red-700">
                                        Change
                                    </button>
                                </div>

                                <div class="flex justify-between items-center p-4 border border-gray-200 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Two-Factor Authentication</h4>
                                        <p class="text-gray-600 text-sm">Add an extra layer of security</p>
                                    </div>
                                    <label class="flex items-center cursor-pointer">
                                        <div class="relative">
                                            <input type="checkbox" class="toggle-checkbox sr-only">
                                            <div class="toggle-label w-10 h-6 bg-gray-200 rounded-full"></div>
                                            <div class="toggle-dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition"></div>
                                        </div>
                                    </label>
                                </div>

                                <div class="flex justify-between items-center p-4 border border-gray-200 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Login Activity</h4>
                                        <p class="text-gray-600 text-sm">View your recent login history</p>
                                    </div>
                                    <button class="text-whr-red font-semibold hover:text-red-700">
                                        View
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notifications  -->
                    <div id="notifications" class="settings-section hidden">
                        <div class="bg-white rounded-2xl shadow-lg p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-6">Notification Preferences</h3>
                            
                            <div class="space-y-4">
                                <div class="flex justify-between items-center p-4 border border-gray-200 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Email Notifications</h4>
                                        <p class="text-gray-600 text-sm">Receive notifications via email</p>
                                    </div>
                                    <label class="flex items-center cursor-pointer">
                                        <div class="relative">
                                            <input type="checkbox" checked class="toggle-checkbox sr-only">
                                            <div class="toggle-label w-10 h-6 bg-whr-red rounded-full"></div>
                                            <div class="toggle-dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition transform translate-x-4"></div>
                                        </div>
                                    </label>
                                </div>

                                <div class="flex justify-between items-center p-4 border border-gray-200 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Push Notifications</h4>
                                        <p class="text-gray-600 text-sm">Receive push notifications</p>
                                    </div>
                                    <label class="flex items-center cursor-pointer">
                                        <div class="relative">
                                            <input type="checkbox" checked class="toggle-checkbox sr-only">
                                            <div class="toggle-label w-10 h-6 bg-whr-red rounded-full"></div>
                                            <div class="toggle-dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition transform translate-x-4"></div>
                                        </div>
                                    </label>
                                </div>

                                <div class="flex justify-between items-center p-4 border border-gray-200 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">SMS Notifications</h4>
                                        <p class="text-gray-600 text-sm">Receive notifications via SMS</p>
                                    </div>
                                    <label class="flex items-center cursor-pointer">
                                        <div class="relative">
                                            <input type="checkbox" class="toggle-checkbox sr-only">
                                            <div class="toggle-label w-10 h-6 bg-gray-200 rounded-full"></div>
                                            <div class="toggle-dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition"></div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preferences -->
                    <div id="preferences" class="settings-section hidden">
                        <div class="bg-white rounded-2xl shadow-lg p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-6">User Preferences</h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Language</label>
                                    <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-whr-red focus:border-transparent">
                                        <option>English</option>
                                        <option>French</option>
                                        <option>Spanish</option>
                                        <option>German</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Time Zone</label>
                                    <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-whr-red focus:border-transparent">
                                        <option>Eastern Time (ET)</option>
                                        <option>Central Time (CT)</option>
                                        <option>Pacific Time (PT)</option>
                                        <option>GMT</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Date Format</label>
                                    <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-whr-red focus:border-transparent">
                                        <option>MM/DD/YYYY</option>
                                        <option>DD/MM/YYYY</option>
                                        <option>YYYY-MM-DD</option>
                                    </select>
                                </div>

                                <div class="flex justify-end pt-4">
                                    <button class="bg-whr-red text-white px-6 py-2 rounded-lg font-semibold hover:bg-red-600 transition-colors">
                                        Save Preferences
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Mobile Overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden hidden" id="mobile-overlay"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Navigation mobile
            const menuToggle = document.getElementById('menu-toggle');
            const closeMenu = document.getElementById('close-menu');
            const sidebar = document.querySelector('.sidebar');
            const mobileOverlay = document.getElementById('mobile-overlay');

            menuToggle.addEventListener('click', () => {
                sidebar.classList.add('active');
                mobileOverlay.classList.remove('hidden');
            });

            closeMenu.addEventListener('click', () => {
                sidebar.classList.remove('active');
                mobileOverlay.classList.add('hidden');
            });

            mobileOverlay.addEventListener('click', () => {
                sidebar.classList.remove('active');
                mobileOverlay.classList.add('hidden');
            });

            // Settings navigation
            const navLinks = document.querySelectorAll('.settings-nav-link');
            const sections = document.querySelectorAll('.settings-section');

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove active class from all links
                    navLinks.forEach(nav => {
                        nav.classList.remove('bg-whr-active', 'text-whr-red', 'font-semibold');
                        nav.classList.add('text-gray-700');
                    });
                    
                    // Add active class to clicked link
                    this.classList.add('bg-whr-active', 'text-whr-red', 'font-semibold');
                    this.classList.remove('text-gray-700');
                    
                    // Hide all sections
                    sections.forEach(section => {
                        section.classList.add('hidden');
                    });
                    
                    // Show target section
                    const targetId = this.getAttribute('href').substring(1);
                    document.getElementById(targetId).classList.remove('hidden');
                });
            });

            // Toggle switch functionality
            const toggleSwitches = document.querySelectorAll('.toggle-checkbox');
            toggleSwitches.forEach(toggle => {
                toggle.addEventListener('change', function() {
                    const label = this.nextElementSibling;
                    const dot = label.querySelector('.toggle-dot');
                    
                    if (this.checked) {
                        label.classList.add('bg-whr-red');
                        label.classList.remove('bg-gray-200');
                        dot.style.transform = 'translateX(16px)';
                    } else {
                        label.classList.add('bg-gray-200');
                        label.classList.remove('bg-whr-red');
                        dot.style.transform = 'translateX(0)';
                    }
                });
            });

            // Form submissions
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    alert('Settings saved successfully!');
                });
            });
        });
    </script>

@endsection