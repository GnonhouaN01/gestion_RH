@extends('layouts.base')

@section('title', 'Dashboard Administrateur')

@section('ChildContent')
    <main class="flex-1 overflow-y-auto p-4 md:p-6">
        <div class="mb-6 hidden lg:block">
            <h1 class="text-2xl font-bold " >Dashboard</h1>
        </div>

        <!-- BLOCS PRINCIPAUX -->
        <div class="grid grid-cols-1 xl:grid-cols-[1.7fr_1fr] gap-6">

            <!-- BLOC 1 - Gauche -->
            <div class="space-y-6">

                <!-- Première ligne -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <!--  la partie Available Position -->
                    <div class=" rounded-xl shadow-sm p-6" style="background-color:#FFEFE7 ">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Available Position</p>
                                <h3 id="available_positions" class="text-3xl font-bold mt-2 text-gray-800">--</h3>
                                <p class="text-warning text-sm mt-1 font-medium">Urgently needed</p>
                            </div>

                        </div>
                    </div>

                    <!-- la partie  Job Open -->
                    <div class=" rounded-xl shadow-sm p-6" style="background-color:#E8F0FB ">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Job Open</p>
                                <h3 id="active_recruitments" class="text-3xl font-bold mt-2 text-gray-800">--</h3>
                                <p class="text-success text-sm mt-1 font-medium">Active hiring</p>
                            </div>

                        </div>
                    </div>

                    <!--  la partie New Employees -->
                    <div class=" rounded-xl shadow-sm p-6"  style="background-color:#FDEBF9 ">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">New Employees</p>
                                <h3 id="new_employees" class="text-3xl font-bold mt-2 text-gray-800">--</h3>
                                <p class="text-primary text-sm mt-1 font-medium">New arrivals</p>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Deuxième ligne -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Total Employees -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="font-bold text-gray-800 text-lg mb-4">Total Employees</h3>
                        <div class="flex items-end justify-between">
                            <div>
                                <h2 id="total_employees" class="text-4xl font-bold text-gray-800">--</h2>
                                <p class="text-gray-500 text-sm mt-2 font-medium">All Employees</p>
                            </div>
                            <div class="text-right">
                                <p class="text-success text-sm font-semibold">+2% <i class="fas fa-arrow-up"></i></p>
                                <p class="text-gray-500 text-xs mt-1">Past month</p>
                            </div>
                        </div>
                    </div>

                    <!-- le total de Departments -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="font-bold text-gray-800 text-lg mb-4">Total Departments</h3>
                        <div class="flex items-end justify-between">
                            <div>
                                <h2 id="total_departments" class="text-4xl font-bold text-gray-800">--</h2>
                                <p class="text-gray-500 text-sm mt-2 font-medium">Departments</p>
                            </div>
                            <div class="text-right">
                                <p class="text-success text-sm font-semibold">+1% <i class="fas fa-arrow-up"></i></p>
                                <p class="text-gray-500 text-xs mt-1">Past month</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Annonces -->
                <!-- Troisième ligne: Announcement -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-gray-800 text-lg">Announcement</h3>
                        <span class="text-gray-500 text-sm" id="announcement_date">Today</span>
                    </div>

                    <!-- Conteneur dynamique -->
                    <div id="announcement_list" class="space-y-1  " style="background-color:#E0E0E0; border:2px solid #ccc; border-radius:8px;padding:10px;">
                        <!-- L'emplacement des données de emplacement -->
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-100 text-center">
                        <a href="#" class=" text-sm font-medium hover:text-blue-700 transition-colors" style="color: #FF5151">
                            See All Announcement
                        </a>
                    </div>
                </div>

            </div>

            <!-- BLOC 2 - Droite -->
            <div class="space-y-6">
                <!-- Activités recentes -->
                <div class="text-white rounded-xl shadow-sm p-6" style="background-color: #1B204A">
                    <h3 class="font-bold text-white text-lg mb-4">Recently Activity</h3>
                    <p class="text-gray-300 text-sm mb-1">10.40 AM, Fri 10 Sept 2021</p>
                    <p class="font-medium text-white text-base mb-2">You Posted a New Job</p>
                    <p class="text-gray-300 text-sm leading-relaxed mb-4">
                        Kindly check the requirements and terms of work and make sure everything is right.
                    </p>
                    <div class="flex justify-between items-center pt-4 border-t border-gray-600">
                        <p class="text-gray-300 text-sm font-medium">Today you made <span
                                class="text-white font-semibold">12 Activities</span></p>
                        <a href="#"
                            class="bg-[#FF5151] text-white px-4 py-2 text-xs font-medium rounded-lg hover:bg-red-600 transition-colors">See
                            All</a>
                    </div>
                </div>

                <!-- la partie schedule -->

                <div class="bg-white rounded-xl shadow-sm p-6 min-h-[280px] flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-center mb-5">
                            <h3 class="font-bold text-gray-800 text-lg">Upcoming Schedule</h3>
                            <span id="schedule_date" class="text-gray-500 text-sm">Loading...</span>
                        </div>

                        <!-- Conteneur dynamique -->
                        <div id="schedule_list" class="space-y-5" style="background-color:#E0E0E0; border:2px solid #ccc; border-radius:8px;padding:10px;">
                            <!-- L'emplacement des données de horaires -->
                        </div>
                    </div>

                    <div class="mt-6 pt-5 border-t border-gray-100 text-center ">
                         <a href="#"
                            class="px-4 py-2 text-sm font-medium rounded-lg " style="color: #FF5151">Create a New Schedule</a>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!--  le js pour la récupération des données via API -->
<script>
document.addEventListener('DOMContentLoaded', async () => {
    try {
        // Appel de l'API du Dashboard
        const response = await fetch('/api/dashboard');
        console.log(response)
        const { data } = await response.json();

        // Les statistiques prrincipales
        document.getElementById('total_employees').textContent = data.total_employees ?? 0;
        document.getElementById('total_departments').textContent = data.total_departments ?? 0;
        document.getElementById('active_recruitments').textContent = data.active_recruitments ?? 0;
        document.getElementById('available_positions').textContent = data.active_recruitments ?? 0;
        document.getElementById('new_employees').textContent = data.total_employees ?? 0;

        
        // La partie announcement: on reccupère les données depuis la bd et on affiche dans la partie ciblé qui est announcement
        const announcementContainer = document.getElementById('announcement_list');
        if (announcementContainer && Array.isArray(data.recruitment_descriptions)) {
            announcementContainer.innerHTML = '';

            data.recruitment_descriptions.forEach((item) => {
                const truncatedDescription =
                    item.description && item.description.length > 90
                        ? item.description.substring(0, 90) + '...'
                        : item.description ?? '';

                const announcement = document.createElement('div');
                announcement.classList.add('pb-3', 'border-b', 'border-gray-100');
                announcement.innerHTML = `
                    <p class="font-medium text-gray-800 text-base">${item.title}</p>
                    <p class="text-gray-500 text-sm mt-1">${truncatedDescription}</p>
                    <p class="text-gray-400 text-xs mt-1">
                        ${new Date(item.created_at).toLocaleDateString('fr-FR')}
                    </p>
                `;
                announcementContainer.appendChild(announcement);
            });
        }

        
        // La section schedule
        const scheduleContainer = document.getElementById('schedule_list');
        const scheduleDate = document.getElementById('schedule_date');
        if (scheduleContainer && Array.isArray(data.upcoming_schedules)) {
            scheduleContainer.innerHTML = '';

            // 🔹 Affiche la date du jour
            scheduleDate.textContent = new Date().toLocaleDateString('fr-FR', {
                weekday: 'short',
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });

            // Parcours des plannings
            data.upcoming_schedules.forEach((schedule) => {
                const formattedTime = new Date(schedule.start_time).toLocaleTimeString('fr-FR', {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                const scheduleItem = document.createElement('div');
                scheduleItem.classList.add('pb-3', 'border-b', 'border-gray-100');

                scheduleItem.innerHTML = `
                    <span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded font-semibold mb-2">
                        Schedule
                    </span>
                    <div class="flex justify-between items-center">
                        <p class="font-medium text-gray-800 text-sm">${schedule.title}</p>
                        <p class="text-gray-500 text-xs">${formattedTime}</p>
                    </div>
                    <p class="text-gray-500 text-sm mt-1">${schedule.notes ?? ''}</p>
                `;

                scheduleContainer.appendChild(scheduleItem);
            });
        }

    } catch (error) {
        console.error('❌ Erreur lors du chargement du dashboard :', error);
    }
});
</script>



@endsection
