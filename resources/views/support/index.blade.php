@extends('layouts.base')

@section('title', 'Support')

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
        .support-card {
            transition: all 0.3s ease;
        }
        .support-card:hover {
            transform: translateY(-5px);
        }
    </style>

    
    <div class="flex-1 flex flex-col overflow-x-hidden overflow-y-auto">

        <!-- contenu principal -->
        <main class="p-4 md:p-8">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Support Center</h2>
                <p class="text-gray-600">Get help and support for your WeHR system</p>
            </div>

            <!--  Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div class="support-card bg-white rounded-2xl shadow-lg p-6 text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-question-circle text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">FAQ</h3>
                    <p class="text-gray-600 text-sm mb-4">Find answers to frequently asked questions</p>
                    <button class="text-blue-600 text-sm font-semibold hover:text-blue-700">
                        Browse FAQs <i class="fas fa-arrow-right ml-1"></i>
                    </button>
                </div>

                <div class="support-card bg-white rounded-2xl shadow-lg p-6 text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-book text-green-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Documentation</h3>
                    <p class="text-gray-600 text-sm mb-4">Detailed guides and tutorials</p>
                    <button class="text-green-600 text-sm font-semibold hover:text-green-700">
                        View Docs <i class="fas fa-arrow-right ml-1"></i>
                    </button>
                </div>

                <div class="support-card bg-white rounded-2xl shadow-lg p-6 text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-video text-purple-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Video Tutorials</h3>
                    <p class="text-gray-600 text-sm mb-4">Step-by-step video guides</p>
                    <button class="text-purple-600 text-sm font-semibold hover:text-purple-700">
                        Watch Videos <i class="fas fa-arrow-right ml-1"></i>
                    </button>
                </div>
            </div>

            <!-- Contact  -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Contact Support</h3>
                    <div class="w-10 h-10 bg-whr-red rounded-full flex items-center justify-center">
                        <i class="fas fa-headset text-white text-lg"></i>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center" style="flex-shrink: 0;">
                                <i class="fas fa-phone-alt text-blue-600 text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Phone Support</h4>
                                <p class="text-gray-600 text-sm">+1 (555) 123-4567</p>
                                <p class="text-gray-500 text-xs">Mon-Fri, 9AM-6PM EST</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center " style="flex-shrink: 0;">
                                <i class="fas fa-envelope text-green-600 text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Email Support</h4>
                                <p class="text-gray-600 text-sm">support@wehr.com</p>
                                <p class="text-gray-500 text-xs">24/7 response within 4 hours</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center" style="flex-shrink: 0;">
                                <i class="fas fa-comments text-purple-600 text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Live Chat</h4>
                                <p class="text-gray-600 text-sm">Available 24/7</p>
                                <p class="text-gray-500 text-xs">Instant connection with agents</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6">
                        <h4 class="font-semibold text-gray-800 mb-4">Send us a Message</h4>
                        <form class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-whr-red focus:border-transparent" placeholder="Brief description of your issue">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                                <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-whr-red focus:border-transparent h-24" placeholder="Describe your issue in detail"></textarea>
                            </div>
                            <button type="submit" class="w-full bg-whr-red text-white py-3 rounded-lg font-semibold hover:bg-red-600 transition-colors">
                                Send Message
                            </button>
                        </form>
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

            // FAQ accordion functionality
            const faqButtons = document.querySelectorAll('.border-gray-200 button');
            faqButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const answer = button.parentElement.nextElementSibling;
                    answer.classList.toggle('hidden');
                    
                    const icon = button.querySelector('i');
                    if (icon.classList.contains('fa-chevron-down')) {
                        icon.classList.remove('fa-chevron-down');
                        icon.classList.add('fa-chevron-up');
                    } else {
                        icon.classList.remove('fa-chevron-up');
                        icon.classList.add('fa-chevron-down');
                    }
                });
            });

            // Form submission
            const supportForm = document.querySelector('form');
            supportForm.addEventListener('submit', function(e) {
                e.preventDefault();
                alert('Thank you! Your message has been sent to our support team. We will get back to you within 4 hours.');
                this.reset();
            });
        });
    </script>


@endsection