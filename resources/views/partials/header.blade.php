<!-- Header -->
<header class="bg-white shadow-sm border-b sticky top-0 z-20">
    <div class="flex items-center justify-between h-20 px-4 md:px-8">
        <div class="flex items-center space-x-4">
            <button class="lg:hidden text-gray-600" id="menu-toggle">
                <i class="fas fa-bars text-xl"></i>
            </button>

            <!-- Barre de recherche globale -->
            <div class="relative w-64 md:w-96">
                <div class="relative">
                    <input type="text" id="global-search" placeholder="Search employees, departments, recruitments..."
                        class="w-full pl-4 pr-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200" />
                    <i class="fas fa-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <button id="clear-search"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 hidden">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Résultats de recherche -->
                <div id="search-results"
                    class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-lg border border-gray-200 hidden z-50 max-h-96 overflow-y-auto">
                    <!-- Les résultats seront injectés ici -->
                </div>
            </div>
        </div>

        <div class="flex items-center space-x-4 md:space-x-6">
            <div class="relative p-2 rounded-full hover:bg-gray-100 cursor-pointer">
                <i class="fas fa-bell text-gray-500 text-lg"></i>
                <span class="absolute top-1 right-1 block h-2 w-2 rounded-full ring-2 ring-white bg-danger"></span>
            </div>
            <div class="p-2 rounded-full hover:bg-gray-100 cursor-pointer">
                <i class="fas fa-comment-alt text-gray-500 text-lg"></i>
            </div>

            <div class="relative flex items-center space-x-2 border-l pl-4 cursor-pointer" id="dropdown-button">
                <span class="hidden md:block text-sm font-semibold text-gray-700">Admira John</span>

                <!-- Avatar avec initiales -->
                <div class="w-10 h-10 rounded-full overflow-hidden bg-primary flex items-center justify-center">
                    <span class="text-white font-semibold text-sm">AJ</span>
                </div>

                <i class="fas fa-chevron-down text-gray-500 text-xs"></i>
            </div>
        </div>
    </div>
</header>
