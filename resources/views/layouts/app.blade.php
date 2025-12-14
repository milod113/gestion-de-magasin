<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="app()">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=el-messiri:600,700|cairo:400,600,700&display=swap" rel="stylesheet" />

    <title>{{ config('app.name', 'StockVision') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ========== BRAND SYSTEM ========== */
        :root {
            --brand-red: #dc2626;     /* red-600 */
            --brand-orange: #f97316;  /* orange-500 */
            --brand-amber: #fbbf24;   /* amber-400 */
            --brand-indigo: #4f46e5;  /* indigo-600 */
            --brand-purple: #7c3aed;  /* purple-600 */
        }

        /* ========== LOADING ANIMATION ========== */
        #loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }
        
        .dark #loading-screen {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }
        
        #loading-screen.hidden {
            opacity: 0;
            visibility: hidden;
        }
        
        .loader {
            width: 64px;
            height: 64px;
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .loader::before,
        .loader::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--brand-indigo), var(--brand-purple));
            animation: loading-bounce 1s infinite ease-in-out;
            opacity: 0.6;
        }
        
        .loader::after {
            background: linear-gradient(45deg, var(--brand-red), var(--brand-orange));
            animation-delay: -0.5s;
        }
        
        @keyframes loading-bounce {
            0%, 100% {
                transform: scale(0);
            }
            50% {
                transform: scale(1);
            }
        }
        
        .loading-text {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1e293b;
            letter-spacing: 0.025em;
        }
        
        .dark .loading-text {
            color: #f1f5f9;
        }
        
        .loading-progress {
            width: 200px;
            height: 3px;
            background: rgba(0,0,0,0.1);
            border-radius: 3px;
            margin-top: 1.5rem;
            overflow: hidden;
            position: relative;
        }
        
        .dark .loading-progress {
            background: rgba(255,255,255,0.1);
        }
        
        .loading-progress::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, var(--brand-red), var(--brand-orange), var(--brand-amber));
            animation: loading-progress 1.5s infinite ease-in-out;
        }
        
        @keyframes loading-progress {
            0% {
                left: -100%;
            }
            100% {
                left: 100%;
            }
        }

        /* ========== PROFILE CARD ========== */
        .profile-card {
            background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 60%, #fef3c7 100%);
            border-radius: 18px;
            padding: 1.25rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 6px 22px rgba(0,0,0,0.06);
            transition: all 0.35s ease;
            border: 1px solid rgba(255,255,255,0.7);
        }
        .dark .profile-card {
            background: linear-gradient(135deg, #111827 0%, #1f2937 60%, #0f172a 100%);
            border: 1px solid rgba(255,255,255,0.06);
        }
        .profile-card::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--brand-red), var(--brand-orange), var(--brand-amber));
        }

        .profile-avatar {
            position: relative;
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--brand-red), var(--brand-orange));
            padding: 3px;
            box-shadow: 0 4px 14px rgba(220,38,38,0.35);
            flex-shrink: 0;
        }
        .profile-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 13px;
            object-fit: cover;
            border: 2px solid white;
        }
        .dark .profile-avatar img { border-color: #111827; }

        .status-indicator {
            position: absolute;
            bottom: 3px;
            right: 3px;
            width: 14px; height: 14px;
            border-radius: 50%;
            background: #10b981;
            border: 2px solid white;
        }
        .dark .status-indicator { border-color: #111827; }
        

        .profile-name {
            font-weight: 800;
            font-size: 1.05rem;
            color: #111827;
            margin-bottom: 0.25rem;
        }
        .dark .profile-name { color: #f9fafb; }

        .profile-email {
            font-size: 0.85rem;
            color: #6b7280;
            display: flex;
            align-items: center;
            gap: .35rem;
        }
        .dark .profile-email { color: #9ca3af; }

        .profile-badge {
            display: inline-flex;
            align-items: center;
            gap: .3rem;
            background: linear-gradient(135deg, var(--brand-red), var(--brand-orange));
            color: white;
            padding: .35rem .7rem;
            border-radius: 9999px;
            font-size: .72rem;
            font-weight: 700;
            margin-top: .7rem;
            box-shadow: 0 3px 10px rgba(249,115,22,.35);
        }

        .profile-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
        }

        /* ========== USER DROPDOWN ENHANCED ========== */
        .user-dropdown {
            min-width: 280px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1), 0 4px 24px rgba(0,0,0,0.06);
            border: 1px solid rgba(0,0,0,0.05);
            overflow: hidden;
        }
        
        .dark .user-dropdown {
            background: #1f2937;
            border: 1px solid rgba(255,255,255,0.05);
            box-shadow: 0 20px 60px rgba(0,0,0,0.3), 0 4px 24px rgba(0,0,0,0.2);
        }
        
        .user-dropdown-header {
            background: linear-gradient(135deg, var(--brand-red), var(--brand-orange));
            padding: 1.5rem;
            color: white;
            position: relative;
        }
        
        .user-dropdown-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--brand-red), var(--brand-orange), var(--brand-amber));
        }
        
        .user-dropdown-avatar {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            border: 3px solid rgba(255,255,255,0.3);
        }
        
        .user-dropdown-item {
            padding: 0.75rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #4b5563;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }
        
        .dark .user-dropdown-item {
            color: #d1d5db;
        }
        
        .user-dropdown-item:hover {
            background: #f3f4f6;
            color: #111827;
            border-left: 3px solid var(--brand-orange);
        }
        
        .dark .user-dropdown-item:hover {
            background: #374151;
            color: white;
        }
        
        .user-dropdown-divider {
            height: 1px;
            background: #e5e7eb;
            margin: 0.5rem 0;
        }
        
        .dark .user-dropdown-divider {
            background: #374151;
        }
        
        .user-dropdown-footer {
            background: #f9fafb;
            padding: 1rem 1.25rem;
        }
        
        .dark .user-dropdown-footer {
            background: #111827;
        }

        /* ========== SIDEBAR ACTIVE ========== */
        .sidebar-item.active {
            background: rgba(249,115,22,0.10);
            color: #ea580c;
            border-left: 4px solid #ea580c;
        }
        .dark .sidebar-item.active {
            background: rgba(249,115,22,0.18);
            color: #fdba74;
        }

        /* badges */
        .notification-badge {
            position: absolute;
            top: -0.45rem;
            right: -0.45rem;
            background: #ef4444;
            color: white;
            border-radius: 9999px;
            width: 1.25rem;
            height: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .75rem;
            font-weight: 700;
        }

        /* dropdown */
        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: 0.2s ease;
        }
        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        html { transition: background-color .3s ease, color .3s ease; }

        /* Enhanced sidebar styles */
        .sidebar-item {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .sidebar-item:hover:not(.active) {
            background: rgba(249,115,22,0.05);
        }
        
        .dark .sidebar-item:hover:not(.active) {
            background: rgba(255,255,255,0.03);
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        
        .dark .custom-scrollbar::-webkit-scrollbar-track {
            background: #1f2937;
        }
        
        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #4b5563;
        }
        
        /* Card hover effect */
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .dark .card-hover:hover {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
        }

        /* Statistics cards gradient backgrounds */
        .stats-card-indigo {
            background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        }
        
        .dark .stats-card-indigo {
            background: linear-gradient(135deg, #312e81 0%, #3730a3 100%);
        }
        
        .stats-card-red {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        }
        
        .dark .stats-card-red {
            background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 100%);
        }
        
        .stats-card-green {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        }
        
        .dark .stats-card-green {
            background: linear-gradient(135deg, #065f46 0%, #047857 100%);
        }
        
        .stats-card-purple {
            background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%);
        }
        
        .dark .stats-card-purple {
            background: linear-gradient(135deg, #581c87 0%, #7c3aed 100%);
        }
    </style>
</head>

<body class="font-sans antialiased bg-slate-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200">

<!-- ================= LOADING SCREEN ================= -->
<div id="loading-screen">
    <div class="loader"></div>
    <div class="loading-text">StockVision</div>
    <div class="loading-text text-sm mt-2 text-gray-500 dark:text-gray-400">Chargement...</div>
    <div class="loading-progress"></div>
</div>

<!-- ================= NAVBAR ================= -->
<nav class="bg-white/90 dark:bg-gray-800/90 backdrop-blur border-b border-gray-200 dark:border-gray-700 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- Left -->
            <div class="flex items-center gap-3">
                <!-- Mobile menu -->
                <button @click="mobileSidebarOpen = true" type="button"
                        class="md:hidden text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white transition">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                    <div class="relative">
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-red-500/35 via-orange-500/30 to-amber-400/35 blur-lg opacity-70
                                    group-hover:opacity-100 transition duration-500"></div>

                        <div class="relative w-11 h-11 sm:w-12 sm:h-12 rounded-2xl shadow-lg ring-1 ring-white/40 dark:ring-gray-700/60
                                    bg-gradient-to-br from-indigo-500 to-purple-600 backdrop-blur-md p-2
                                    transition duration-500 group-hover:scale-105 flex items-center justify-center">
                            <i class="ti ti-packages text-white text-lg"></i>
                        </div>
                    </div>

                    <!-- Text -->
                    <div class="leading-tight block">
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight
                                   bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-400
                                   bg-clip-text text-transparent">
                            StockVision
                        </h1>

                        <!-- Subtitle only from md and up -->
                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 hidden md:block">
                            Gestion d'inventaire intelligente
                        </p>
                    </div>
                </a>
            </div>

            <!-- Right -->
            <div class="flex items-center gap-2 sm:gap-4">
                <!-- Dark mode toggle -->
                <button id="dark-toggle"
                        class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition focus:outline-none">
                    <svg id="dark-icon" class="w-5 h-5 text-gray-700 dark:text-gray-300 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                    <svg id="light-icon" class="w-5 h-5 text-gray-700 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </button>

                <!-- Notifications -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition relative">
                        <svg class="h-5 w-5 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="notification-badge">3</span>
                    </button>

                    <div x-show="open" @click.away="open = false"
                        class="dropdown-menu absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700 z-50 overflow-hidden">
                        <div class="p-3 border-b border-gray-200 dark:border-gray-700 font-semibold text-sm">
                            Notifications
                        </div>
                        <div class="max-h-60 overflow-y-auto">
                            <a href="#" class="block hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                    <p class="text-sm font-bold text-gray-800 dark:text-gray-100">
                                        Nouvelle commande reçue
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Fournisseur: ABC Supplies
                                    </p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">
                                        Il y a 2 minutes
                                    </p>
                                </div>
                            </a>
                            <a href="#" class="block hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                    <p class="text-sm font-bold text-gray-800 dark:text-gray-100">
                                        Alerte stock faible
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Article: Papier A4
                                    </p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">
                                        Il y a 5 heures
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- User dropdown -->
                @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-400
                                    flex items-center justify-center text-white font-bold shadow-md">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <span class="hidden md:inline font-semibold text-gray-800 dark:text-gray-100">
                            {{ Auth::user()->name }}
                        </span>
                        <svg class="h-4 w-4 text-gray-500 dark:text-gray-300 transition-transform"
                             :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition
                         class="user-dropdown absolute right-0 mt-2 z-50 overflow-hidden">
                        <div class="user-dropdown-header">
                            <div class="user-dropdown-avatar">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-lg">{{ Auth::user()->name }}</h3>
                                <p class="text-sm opacity-90">{{ Auth::user()->email }}</p>
                                <div class="mt-2">
                                    <span class="inline-flex items-center gap-1 bg-white/20 px-2 py-1 rounded-full text-xs">
                                        <i class="ti ti-shield-check"></i>
                                        Administrator
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="py-2">
                            <a href="#" class="user-dropdown-item">
                                <i class="ti ti-user-circle text-lg"></i>
                                <div>
                                    <div class="font-medium">Mon profil</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Gérer votre compte</div>
                                </div>
                            </a>
                            
                            <a href="#" class="user-dropdown-item">
                                <i class="ti ti-settings text-lg"></i>
                                <div>
                                    <div class="font-medium">Paramètres</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Personnaliser l'interface</div>
                                </div>
                            </a>
                            
                            <a href="#" class="user-dropdown-item">
                                <i class="ti ti-bell-ringing text-lg"></i>
                                <div>
                                    <div class="font-medium">Notifications</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Gérer les alertes</div>
                                </div>
                                <span class="ml-auto bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-xs font-bold px-2 py-1 rounded-full">3</span>
                            </a>
                            
                            <div class="user-dropdown-divider"></div>
                            
                            <a href="#" class="user-dropdown-item">
                                <i class="ti ti-help-circle text-lg"></i>
                                <div>
                                    <div class="font-medium">Aide & Support</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Documentation et FAQ</div>
                                </div>
                            </a>
                            
                            <div class="user-dropdown-footer">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-gradient-to-r from-red-600 to-orange-600 text-white rounded-lg hover:opacity-90 transition font-medium">
                                        <i class="ti ti-logout"></i>
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- ================= LAYOUT ================= -->
<div class="flex">

    <!-- Mobile sidebar backdrop -->
    <div x-show="mobileSidebarOpen" @click="mobileSidebarOpen = false"
         class="fixed inset-0 z-20 bg-black bg-opacity-50 md:hidden transition-normal"
         style="display: none;"></div>

    <!-- Sidebar desktop -->
    <aside class="hidden md:block w-64 bg-white dark:bg-gray-800 min-h-[calc(100vh-4rem)]
                  border-r border-gray-200 dark:border-gray-700 sticky top-16">

        <div class="p-4">

     <!-- Profile -->
            <div class="profile-card mb-6">
                <div class="flex items-start">
                    <div class="profile-avatar">
                        <img src="{{ auth()->user()->profile && auth()->user()->profile->photo ? asset('storage/' . auth()->user()->profile->photo) : asset('images/default-avatar.png') }}"
                             alt="{{ auth()->user()->name }}"
                             onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                        <div class="status-indicator"></div>
                    </div>

                    <div class="ml-4 flex-1 min-w-0">
                        @php
                            $name = auth()->user()->name;
                            $parts = explode(' ', trim($name));
                            $formattedName = (count($parts) >= 2)
                                ? $parts[0] . ' ' . strtoupper(substr($parts[1], 0, 1)) . '.'
                                : $name;
                        @endphp

                        <h5 class="profile-name truncate">{{ $formattedName }}</h5>

                        <div class="profile-email truncate">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="truncate">{{ auth()->user()->email }}</span>
                        </div>

                        <div class="profile-badge">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                      clip-rule="evenodd"/>
                            </svg>
                            Administrator
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search -->
            <div class="relative mb-6">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text"
                       placeholder="Rechercher..."
                       class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700
                              focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm shadow-sm">
            </div>

            <!-- Navigation -->
            <nav class="space-y-1 text-sm custom-scrollbar" style="max-height: calc(100vh - 320px); overflow-y: auto;">

                <a href="{{ route('dashboard') }}"
                   class="sidebar-item flex items-center px-4 py-3 font-semibold rounded-xl hover:bg-gray-100/80 dark:hover:bg-gray-700/80 transition">
                    <span class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-orange-50 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400">
                        <i class="ti ti-layout-dashboard text-sm"></i>
                    </span>
                    <span class="flex-1">Tableau de bord</span>
                </a>

                <!-- Gestion d'Inventaire section -->
                <div class="pt-4 mt-2 border-t border-gray-200 dark:border-gray-700/50">
                    <p class="px-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
                        Gestion d'Inventaire
                    </p>

                    <a href="{{ route('conventions.index') }}"
                       class="sidebar-item flex items-center px-4 py-3 font-medium rounded-xl hover:bg-gray-100/80 dark:hover:bg-gray-700/80 transition">
                        <span class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400">
                            <i class="ti ti-truck text-sm"></i>
                        </span>
                        <span class="flex-1">Conventions et Marchées</span>
                    </a>

                    <a href="{{ route('fournisseurs.index') }}"
                       class="sidebar-item flex items-center px-4 py-3 font-medium rounded-xl hover:bg-gray-100/80 dark:hover:bg-gray-700/80 transition">
                        <span class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400">
                            <i class="ti ti-truck text-sm"></i>
                        </span>
                        <span class="flex-1">Fournisseurs</span>
                    </a>

                    <a href="{{ route('receptions.index') }}"
                       class="sidebar-item flex items-center px-4 py-3 font-medium rounded-xl hover:bg-gray-100/80 dark:hover:bg-gray-700/80 transition">
                        <span class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-orange-50 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400">
                            <i class="ti ti-package text-sm"></i>
                        </span>
                        <span class="flex-1">Réceptions</span>
                    </a>

                    <a href="{{ route('categories.index') }}"
                       class="sidebar-item flex items-center px-4 py-3 font-medium rounded-xl hover:bg-gray-100/80 dark:hover:bg-gray-700/80 transition">
                        <span class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400">
                            <i class="ti ti-category text-sm"></i>
                        </span>
                        <span class="flex-1">Catégories</span>
                    </a>

                    <a href="{{ route('articles.index') }}"
                       class="sidebar-item active flex items-center px-4 py-3 font-medium rounded-xl hover:bg-gray-100/80 dark:hover:bg-gray-700/80 transition">
                        <span class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">
                            <i class="ti ti-package text-sm"></i>
                        </span>
                        <span class="flex-1">Articles</span>
                        <span class="ml-2 inline-flex items-center justify-center h-5 min-w-[20px] px-1.5 rounded-full bg-indigo-600 text-white text-xs font-bold">
                            {{ App\Models\Article::count() }}
                        </span>
                    </a>

                    <a href="{{ route('services.index') }}"
                       class="sidebar-item flex items-center px-4 py-3 font-medium rounded-xl hover:bg-gray-100/80 dark:hover:bg-gray-700/80 transition">
                        <span class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400">
                            <i class="ti ti-box-seam text-sm"></i>
                        </span>
                        <span class="flex-1">Services</span>
                        <span class="ml-2 inline-flex items-center justify-center h-5 min-w-[20px] px-1.5 rounded-full bg-green-600 text-white text-xs font-bold">
                            {{ App\Models\Service::count() }}
                        </span>
                    </a>

                    <a href="{{ route('commandes.index') }}"
                       class="sidebar-item flex items-center px-4 py-3 font-medium rounded-xl hover:bg-gray-100/80 dark:hover:bg-gray-700/80 transition">
                        <span class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                            <i class="ti ti-shopping-cart text-sm"></i>
                        </span>
                        <span class="flex-1">Commandes</span>
                    </a>
                </div>


<!-- Gestion du Parc Immobilier / Biomédical -->
<div class="pt-4 mt-2 border-t border-gray-200 dark:border-gray-700/50">
    <p class="px-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
        Gestion d'Immobilier / Parc biomédical
    </p>

    <!-- Vue globale des équipements -->
    <a href="{{ route('immobilier.equipements.index') }}"
       class="sidebar-item flex items-center px-4 py-3 font-medium rounded-xl hover:bg-gray-100/80 dark:hover:bg-gray-700/80 transition">
        <span class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">
            <i class="ti ti-building-hospital text-sm"></i>
        </span>
        <span class="flex-1">Équipements biomédicaux</span>
    </a>

    <!-- Catégories / familles d'appareils -->
    <a href="{{ route('immobilier.categories-equipements.index') }}"
       class="sidebar-item flex items-center px-4 py-3 font-medium rounded-xl hover:bg-gray-100/80 dark:hover:bg-gray-700/80 transition">
        <span class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400">
            <i class="ti ti-category text-sm"></i>
        </span>
        <span class="flex-1">Catégories d'équipements</span>
    </a>
    <!-- Exemplaires / unités d'appareils -->
<a href="{{ route('immobilier.equipment-units.index') }}"
   class="sidebar-item flex items-center px-4 py-3 font-medium rounded-xl hover:bg-gray-100/80 dark:hover:bg-gray-700/80 transition">
    <span class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">
        <i class="ti ti-barcode text-sm"></i>
    </span>
    <span class="flex-1">Exemplaires d'équipements</span>
</a>


    <!-- Localisation des biens : bâtiment / étage / service / salle -->
    <a href="#"
       class="sidebar-item flex items-center px-4 py-3 font-medium rounded-xl hover:bg-gray-100/80 dark:hover:bg-gray-700/80 transition">
        <span class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400">
            <i class="ti ti-map-pin text-sm"></i>
        </span>
        <span class="flex-1">Localisations</span>
    </a>

    <!-- Suivi par numéro de série / traçabilité -->
    <a href="#"
       class="sidebar-item flex items-center px-4 py-3 font-medium rounded-xl hover:bg-gray-100/80 dark:hover:bg-gray-700/80 transition">
        <span class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400">
            <i class="ti ti-barcode text-sm"></i>
        </span>
        <span class="flex-1">Numéros de série & traçabilité</span>
    </a>

    <!-- Contrats : garantie, maintenance, location -->
    <a href="#"
       class="sidebar-item flex items-center px-4 py-3 font-medium rounded-xl hover:bg-gray-100/80 dark:hover:bg-gray-700/80 transition">
        <span class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
            <i class="ti ti-file-invoice text-sm"></i>
        </span>
        <span class="flex-1">Contrats & garanties</span>
    </a>

    <!-- Maintenance / interventions techniques -->
    <a href="#"
       class="sidebar-item flex items-center px-4 py-3 font-medium rounded-xl hover:bg-gray-100/80 dark:hover:bg-gray-700/80 transition">
        <span class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-orange-50 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400">
            <i class="ti ti-tools text-sm"></i>
        </span>
        <span class="flex-1">Maintenance & interventions</span>
    </a>

    <!-- Inventaires physiques périodiques -->
    <a href="#"
       class="sidebar-item flex items-center px-4 py-3 font-medium rounded-xl hover:bg-gray-100/80 dark:hover:bg-gray-700/80 transition">
        <span class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400">
            <i class="ti ti-clipboard-list text-sm"></i>
        </span>
        <span class="flex-1">Inventaires physiques</span>
    </a>
</div>


                <!-- Statistiques & Rapports section -->
                <div class="pt-4 mt-2 border-t border-gray-200 dark:border-gray-700/50">
                    <p class="px-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
                        Statistiques & Rapports
                    </p>

                    <a href="{{ route('history.chart') }}"
                       class="sidebar-item flex items-center px-4 py-3 font-medium rounded-xl hover:bg-gray-100/80 dark:hover:bg-gray-700/80 transition">
                        <span class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400">
                            <i class="ti ti-chart-bar text-sm"></i>
                        </span>
                        <span class="flex-1">Historique Prix & Quantité</span>
                    </a>

                    <a href="{{ route('statistiques.consommation') }}"
                       class="sidebar-item flex items-center px-4 py-3 font-medium rounded-xl hover:bg-gray-100/80 dark:hover:bg-gray-700/80 transition">
                        <span class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-pink-50 dark:bg-pink-900/30 text-pink-600 dark:text-pink-400">
                            <i class="ti ti-chart-pie text-sm"></i>
                        </span>
                        <span class="flex-1">Statistiques Récapulatives</span>
                    </a>

                    <a href="{{ route('statistiques.details_services') }}"
                       class="sidebar-item flex items-center px-4 py-3 font-medium rounded-xl hover:bg-gray-100/80 dark:hover:bg-gray-700/80 transition">
                        <span class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-cyan-50 dark:bg-cyan-900/30 text-cyan-600 dark:text-cyan-400">
                            <i class="ti ti-chart-line text-sm"></i>
                        </span>
                        <span class="flex-1">Statistiques Mensuelles</span>
                    </a>
                </div>

                <!-- Administration section -->
                <div class="pt-4 mt-2 border-t border-gray-200 dark:border-gray-700/50">
                    <p class="px-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
                        Administration
                    </p>

                    <a href="{{ route('users.index') }}"
                       class="sidebar-item flex items-center px-4 py-3 font-medium rounded-xl hover:bg-gray-100/80 dark:hover:bg-gray-700/80 transition">
                        <span class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-gray-50 dark:bg-gray-900/30 text-gray-600 dark:text-gray-400">
                            <i class="ti ti-users text-sm"></i>
                        </span>
                        <span class="flex-1">Utilisateurs</span>
                    </a>

                    <a href="{{ route('admin.roles.index') }}"
                       class="sidebar-item flex items-center px-4 py-3 font-medium rounded-xl hover:bg-gray-100/80 dark:hover:bg-gray-700/80 transition">
                        <span class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">
                            <i class="ti ti-user-shield text-sm"></i>
                        </span>
                        <span class="flex-1">Rôles & Permissions</span>
                    </a>
                </div>

                <!-- Support section -->
                <div class="pt-4 mt-2 border-t border-gray-200 dark:border-gray-700/50">
                    <p class="px-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
                        Support
                    </p>

                    <a href="#"
                       class="sidebar-item flex items-center px-4 py-3 font-medium rounded-xl hover:bg-gray-100/80 dark:hover:bg-gray-700/80 transition">
                        <span class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400">
                            <i class="ti ti-help text-sm"></i>
                        </span>
                        <span class="flex-1">Aide & Documentation</span>
                    </a>

                    <a href="#"
                       class="sidebar-item flex items-center px-4 py-3 font-medium rounded-xl hover:bg-gray-100/80 dark:hover:bg-gray-700/80 transition">
                        <span class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-orange-50 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400">
                            <i class="ti ti-settings text-sm"></i>
                        </span>
                        <span class="flex-1">Paramètres système</span>
                    </a>
                </div>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 min-w-0">
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow-sm">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <h1 class="text-lg font-bold text-gray-900 dark:text-white">
                        {{ $header }}
                    </h1>
                </div>
            </header>
        @endisset

        <div class="px-3 sm:px-6 lg:px-8 py-4">
            <!-- Page header -->
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">@yield('title', 'Tableau de bord')</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">@yield('subtitle', 'Aperçu de votre inventaire')</p>
                </div>
                <div class="flex space-x-3">
                    @yield('actions')
                </div>
            </div>
            
            <!-- Stats cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 card-hover border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Articles</p>
                            <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">{{ App\Models\Article::count() }}</p>
                        </div>
                        <div class="p-3 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">
                            <i class="ti ti-package text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center text-sm font-medium">
                        <i class="ti ti-trending-up text-green-500 mr-1"></i>
                        <span class="text-green-600 dark:text-green-400">+2.5%</span>
                        <span class="text-gray-500 dark:text-gray-400 ml-1">Depuis le mois dernier</span>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 card-hover border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">En rupture</p>
                            <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">24</p>
                        </div>
                        <div class="p-3 rounded-xl bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400">
                            <i class="ti ti-alert-circle text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center text-sm font-medium">
                        <i class="ti ti-trending-up text-red-500 mr-1"></i>
                        <span class="text-red-600 dark:text-red-400">+1.2%</span>
                        <span class="text-gray-500 dark:text-gray-400 ml-1">Depuis le mois dernier</span>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 card-hover border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Commandes</p>
                            <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">56</p>
                        </div>
                        <div class="p-3 rounded-xl bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400">
                            <i class="ti ti-shopping-cart text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center text-sm font-medium">
                        <i class="ti ti-trending-up text-green-500 mr-1"></i>
                        <span class="text-green-600 dark:text-green-400">+12.7%</span>
                        <span class="text-gray-500 dark:text-gray-400 ml-1">Depuis le mois dernier</span>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 card-hover border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Valeur stock</p>
                            <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">DZD 42,589</p>
                        </div>
                        <div class="p-3 rounded-xl bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400">
                            <i class="ti ti-currency-dollar text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center text-sm font-medium">
                        <i class="ti ti-trending-up text-green-500 mr-1"></i>
                        <span class="text-green-600 dark:text-green-400">+5.3%</span>
                        <span class="text-gray-500 dark:text-gray-400 ml-1">Depuis le mois dernier</span>
                    </div>
                </div>
            </div>
            
            <!-- Main content area -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden border border-gray-100 dark:border-gray-700">
                @yield('content')
            </div>
        </div>
    </main>
</div>

<!-- ================= MOBILE BOTTOM NAV ================= -->
<div class="md:hidden fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 flex justify-around py-2 z-40">
    <a href="{{ route('dashboard') }}" class="flex flex-col items-center text-indigo-600">
        <i class="ti ti-layout-dashboard text-lg"></i>
        <span class="text-xs mt-1 font-semibold">Accueil</span>
    </a>

    <a href="{{ route('articles.index') }}" class="flex flex-col items-center text-gray-500 dark:text-gray-400">
        <i class="ti ti-package text-lg"></i>
        <span class="text-xs mt-1">Articles</span>
    </a>

    <a href="{{ route('commandes.index') }}" class="flex flex-col items-center text-gray-500 dark:text-gray-400">
        <i class="ti ti-shopping-cart text-lg"></i>
        <span class="text-xs mt-1">Commandes</span>
    </a>

    <a href="#" class="flex flex-col items-center text-gray-500 dark:text-gray-400">
        <i class="ti ti-user text-lg"></i>
        <span class="text-xs mt-1">Profil</span>
    </a>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // ========== LOADING ANIMATION ==========
    const loadingScreen = document.getElementById('loading-screen');
    
    // Hide loading screen after page is loaded
    window.addEventListener('load', function() {
        // Add a small delay for better UX
        setTimeout(() => {
            loadingScreen.classList.add('hidden');
        }, 500);
    });
    
    // Fallback in case load event doesn't fire
    setTimeout(() => {
        loadingScreen.classList.add('hidden');
    }, 2000);

    // ========== ALPINE JS APP ==========
    function app() {
        return {
            mobileSidebarOpen: false,
            userDropdownOpen: false,
            notificationsOpen: false,
            
            init() {
                // Initialize any Alpine-specific logic here
                console.log('Alpine app initialized');
            },
            
            toggleUserDropdown() {
                this.userDropdownOpen = !this.userDropdownOpen;
            },
            
            toggleNotifications() {
                this.notificationsOpen = !this.notificationsOpen;
            },
            
            closeAllDropdowns() {
                this.userDropdownOpen = false;
                this.notificationsOpen = false;
            }
        }
    }

    // ========== DARK MODE ==========
    const darkToggle = document.getElementById('dark-toggle');
    const darkIcon = document.getElementById('dark-icon');
    const lightIcon = document.getElementById('light-icon');

    darkToggle.addEventListener('click', function () {
        document.documentElement.classList.toggle('dark');
        darkIcon.classList.toggle('hidden');
        lightIcon.classList.toggle('hidden');

        localStorage.setItem('theme',
            document.documentElement.classList.contains('dark') ? 'dark' : 'light'
        );
        
        // Show loading effect for dark mode transition
        loadingScreen.classList.remove('hidden');
        setTimeout(() => {
            loadingScreen.classList.add('hidden');
        }, 300);
    });

    if (localStorage.getItem('theme') === 'dark' ||
        (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
        darkIcon.classList.remove('hidden');
        lightIcon.classList.add('hidden');
    }

    // Initialize Alpine
    if (typeof Alpine === 'undefined') {
        console.warn('Alpine.js not loaded');
    } else {
        Alpine.data('app', app);
    }

    // ========== DROPDOWNS ==========
    document.querySelectorAll('[x-data]').forEach(el => {
        // This will be handled by Alpine
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', (event) => {
        const userDropdowns = document.querySelectorAll('[x-data] [x-show]');
        userDropdowns.forEach(dropdown => {
            const button = dropdown.previousElementSibling;
            if (!dropdown.contains(event.target) && !button.contains(event.target)) {
                // This will be handled by Alpine's @click.away
            }
        });
    });
    
    // ========== PAGE TRANSITION LOADING ==========
    // Show loading screen during page transitions
    const allLinks = document.querySelectorAll('a:not([target="_blank"])');
    allLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Don't intercept if it's a hash link or external
            if (this.getAttribute('href').startsWith('#') || 
                this.getAttribute('href').startsWith('http')) {
                return;
            }
            
            // Don't intercept if it has a data-no-loading attribute
            if (this.hasAttribute('data-no-loading')) {
                return;
            }
            
            // Show loading screen
            loadingScreen.classList.remove('hidden');
        });
    });
    
    // Handle form submissions
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            loadingScreen.classList.remove('hidden');
        });
    });
});

// Legacy dropdown handling (for compatibility)
function setupLegacyDropdowns() {
    const dropdowns = document.querySelectorAll('.dropdown-menu');
    
    document.addEventListener('click', (e) => {
        dropdowns.forEach(dropdown => {
            if (!dropdown.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });
    });
    
    // Toggle dropdowns
    document.querySelectorAll('[data-toggle="dropdown"]').forEach(button => {
        button.addEventListener('click', (e) => {
            e.stopPropagation();
            const dropdown = button.nextElementSibling;
            dropdown.classList.toggle('show');
        });
    });
}

// Initialize when DOM is loaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', setupLegacyDropdowns);
} else {
    setupLegacyDropdowns();
}
</script>

<!-- Alpine JS -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>