<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#6B7280',
                        accent: '#8B5CF6',
                        success: '#10B981',
                        warning: '#F59E0B',
                        danger: '#EF4444'
                    }
                }
            }
        }
    </script>
    
    <style>
        .sidebar {
            transition: all 0.3s ease;
        }
        .card-hover {
            transition: transform 0.2s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
        }
        
        /* Styles pour la recherche globale */
        #search-results {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f5f9;
        }
        #search-results::-webkit-scrollbar {
            width: 6px;
        }
        #search-results::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 0 0 12px 12px;
        }
        #search-results::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        #search-results::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        #search-results {
            animation: slideDown 0.2s ease-out;
        }
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.active {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    @yield('content')
    
    <script >
        
        // Toggle sidebar on mobile
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            if (menuToggle) {
                menuToggle.addEventListener('click', function() {
                    document.querySelector('.sidebar').classList.toggle('active');
                });
            }

            // Système de recherche globale
            class GlobalSearch {
                constructor() {
                    this.searchInput = document.getElementById('global-search');
                    this.searchResults = document.getElementById('search-results');
                    this.clearButton = document.getElementById('clear-search');
                    this.searchTimeout = null;
                    
                    if (this.searchInput) {
                        this.init();
                    }
                }

                init() {
                    this.searchInput.addEventListener('input', (e) => {
                        this.handleSearch(e.target.value);
                    });

                    if (this.clearButton) {
                        this.clearButton.addEventListener('click', () => {
                            this.clearSearch();
                        });
                    }

                    document.addEventListener('click', (e) => {
                        if (this.searchInput && !this.searchInput.contains(e.target) && 
                            this.searchResults && !this.searchResults.contains(e.target)) {
                            this.hideResults();
                        }
                    });

                    this.searchInput.addEventListener('keydown', (e) => {
                        this.handleKeyboardNavigation(e);
                    });
                }

                async handleSearch(query) {
                    if (query.length > 0) {
                        this.clearButton.classList.remove('hidden');
                    } else {
                        this.clearButton.classList.add('hidden');
                        this.hideResults();
                        return;
                    }

                    clearTimeout(this.searchTimeout);
                    this.searchTimeout = setTimeout(async () => {
                        if (query.length < 2) {
                            this.hideResults();
                            return;
                        }
                        await this.performSearch(query);
                    }, 300);
                }

                async performSearch(query) {
                    try {
                        this.showLoading();
                        const response = await fetch(`/api/search/global?q=${encodeURIComponent(query)}&limit=8`);
                        const result = await response.json();

                        if (result.success) {
                            this.displayResults(result.data, query);
                        } else {
                            this.displayError('Erreur lors de la recherche');
                        }
                    } catch (error) {
                        console.error('Search error:', error);
                        this.displayError('Erreur de connexion');
                    }
                }

                displayResults(results, query) {
                    if (results.length === 0) {
                        this.searchResults.innerHTML = `
                            <div class="p-4 text-center text-gray-500">
                                <i class="fas fa-search text-2xl mb-2 text-gray-300"></i>
                                <p>Aucun résultat trouvé pour "<strong>${this.escapeHtml(query)}</strong>"</p>
                            </div>
                        `;
                        this.showResults();
                        return;
                    }

                    const resultsHTML = results.map(result => `
                        <a href="${result.url}" class="block p-4 hover:bg-gray-50 border-b border-gray-100 last:border-b-0 transition-colors group">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center group-hover:bg-blue-50 transition-colors">
                                    <i class="${result.icon} ${result.color}"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-semibold text-gray-800 truncate">${this.escapeHtml(result.title)}</h4>
                                        <span class="text-xs px-2 py-1 rounded-full ${this.getTypeBadgeClass(result.type)}">
                                            ${this.getTypeLabel(result.type)}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 truncate">${this.escapeHtml(result.subtitle)}</p>
                                    ${result.description ? `<p class="text-xs text-gray-500 mt-1 truncate">${this.escapeHtml(result.description)}</p>` : ''}
                                </div>
                            </div>
                        </a>
                    `).join('');

                    const header = `
                        <div class="p-3 border-b border-gray-200 bg-gray-50 rounded-t-xl">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-semibold text-gray-700">Résultats de recherche</span>
                                <span class="text-xs text-gray-500">${results.length} résultat(s)</span>
                            </div>
                        </div>
                    `;

                    this.searchResults.innerHTML = header + resultsHTML;
                    this.showResults();
                }

                showLoading() {
                    this.searchResults.innerHTML = `
                        <div class="p-4 text-center">
                            <div class="flex items-center justify-center space-x-2 text-gray-500">
                                <i class="fas fa-spinner fa-spin"></i>
                                <span>Recherche en cours...</span>
                            </div>
                        </div>
                    `;
                    this.showResults();
                }

                displayError(message) {
                    this.searchResults.innerHTML = `
                        <div class="p-4 text-center text-red-500">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            ${message}
                        </div>
                    `;
                    this.showResults();
                }

                showResults() {
                    this.searchResults.classList.remove('hidden');
                }

                hideResults() {
                    this.searchResults.classList.add('hidden');
                }

                clearSearch() {
                    this.searchInput.value = '';
                    this.clearButton.classList.add('hidden');
                    this.hideResults();
                    this.searchInput.focus();
                }

                handleKeyboardNavigation(e) {
                    const results = this.searchResults.querySelectorAll('a');
                    const currentFocus = document.activeElement;
                    let currentIndex = -1;

                    if (results.length === 0) return;

                    results.forEach((result, index) => {
                        if (result === currentFocus) {
                            currentIndex = index;
                        }
                    });

                    switch (e.key) {
                        case 'ArrowDown':
                            e.preventDefault();
                            const nextIndex = currentIndex < results.length - 1 ? currentIndex + 1 : 0;
                            results[nextIndex].focus();
                            break;
                        case 'ArrowUp':
                            e.preventDefault();
                            const prevIndex = currentIndex > 0 ? currentIndex - 1 : results.length - 1;
                            results[prevIndex].focus();
                            break;
                        case 'Escape':
                            this.hideResults();
                            this.searchInput.focus();
                            break;
                        case 'Enter':
                            if (currentFocus !== this.searchInput && results.length > 0) {
                                e.preventDefault();
                                currentFocus.click();
                            }
                            break;
                    }
                }

                getTypeLabel(type) {
                    const labels = {
                        'employee': 'Employé',
                        'department': 'Département',
                        'recruitment': 'Recrutement'
                    };
                    return labels[type] || type;
                }

                getTypeBadgeClass(type) {
                    const classes = {
                        'employee': 'bg-blue-100 text-blue-800',
                        'department': 'bg-green-100 text-green-800',
                        'recruitment': 'bg-purple-100 text-purple-800'
                    };
                    return classes[type] || 'bg-gray-100 text-gray-800';
                }

                escapeHtml(unsafe) {
                    if (!unsafe) return '';
                    return unsafe
                        .replace(/&/g, "&amp;")
                        .replace(/</g, "&lt;")
                        .replace(/>/g, "&gt;")
                        .replace(/"/g, "&quot;")
                        .replace(/'/g, "&#039;");
                }
            }

            // Initialiser la recherche globale
            new GlobalSearch();
        });

    </script>
</body>
</html>