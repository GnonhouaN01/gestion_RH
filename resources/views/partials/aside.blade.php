        <div class="sidebar fixed lg:relative lg:flex lg:w-64 bg-white shadow-lg z-30 flex-col h-full">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 px-4 py-10 border-b">
                <h1 class="text-3xl font-bold text-gray-800 my-10 ">WeHR</h1>
                {{-- <button class="lg:hidden text-gray-600" id="close-menu">
                    <i class="fas fa-times text-xl"></i>
                </button> --}}
            </div>

            <!-- Navigation -->
            <div class="p-4 pt-8 flex-1">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">MAIN MENU</h3>
                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center px-4 py-3 bg-blue-50 text-primary rounded-lg">
                       
                        <img src="{{asset('icons/ic_dashboard.png')}}" alt="" style="padding-right:15px ">
                        <span class="font-medium" style="color:#FF5151">Dashboard</span>
                    </a>
                    <a href="{{ route('recruitments.page') }}"
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                       <img src="{{asset('icons/Group 7.png')}}" alt="" style="padding-right:15px ">
                        <span class="font-medium">Recruitment</span>
                    </a>
                    <a href="{{route('schedules.page')}}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <img src="{{asset('icons/ic_calendar.png')}}" alt="" style="padding-right:15px ">
                        <span class="font-medium">Schedule</span>
                    </a>
                    <a href="{{ route('employee.page') }}"
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <img src="{{asset('icons/Group 3.png')}}" alt="" style="padding-right:15px ">
                        <span class="font-medium">Employee</span>
                    </a>
                    <a href="{{ route('departments.page') }}"
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <img src="{{asset('icons/ic_department.png')}}" alt="" style="padding-right:15px ">
                        <span class="font-medium">Department</span>
                    </a>
                </nav>

                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mt-8 mb-4">OTHER</h3>
                <nav class="space-y-2">
                    <a href="{{ route('support.page') }}"
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                       <img src="{{asset('icons/ic_support.png')}}" alt="" style="padding-right:15px ">
                        <span class="font-medium">Support</span>
                    </a>
                    <a href="{{ route('settings.page') }}"
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                       <img src="{{asset('icons/ic_settings.png')}}" alt="" style="padding-right:15px ">
                        <span class="font-medium">Settings</span>
                    </a>
                </nav>
            </div>
        </div>
