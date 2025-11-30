<header class="sticky top-0 z-999 flex w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="flex flex-grow items-center justify-between px-4 py-4 shadow-sm md:px-6 2xl:px-11">

        <!-- Left Side -->
        <div class="flex items-center gap-2 sm:gap-4">
            <!-- Hamburger Toggle -->
            <button @click="sidebarToggle = !sidebarToggle"
                class="z-99999 flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-100 lg:hidden dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700">
                <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M3.25 6C3.25 5.58579 3.58579 5.25 4 5.25L20 5.25C20.4142 5.25 20.75 5.58579 20.75 6C20.75 6.41421 20.4142 6.75 20 6.75L4 6.75C3.58579 6.75 3.25 6.41422 3.25 6ZM3.25 18C3.25 17.5858 3.58579 17.25 4 17.25L20 17.25C20.4142 17.25 20.75 17.5858 20.75 18C20.75 18.4142 20.4142 18.75 20 18.75L4 18.75C3.58579 18.75 3.25 18.4142 3.25 18ZM4 11.25C3.58579 11.25 3.25 11.5858 3.25 12C3.25 12.4142 3.58579 12.75 4 12.75L12 12.75C12.4142 12.75 12.75 12.4142 12.75 12C12.75 11.5858 12.4142 11.25 12 11.25L4 11.25Z"
                        fill="" />
                </svg>
            </button>

            <!-- Breadcrumb -->
            @if(isset($breadcrumbs) && count($breadcrumbs) > 0)
                <nav class="hidden sm:flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        @foreach($breadcrumbs as $breadcrumb)
                            <li class="inline-flex items-center">
                                @if(!$loop->first)
                                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="m1 9 4-4-4-4" />
                                    </svg>
                                @endif
                                @if($loop->last)
                                    <span
                                        class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $breadcrumb['label'] }}</span>
                                @else
                                    <a href="{{ $breadcrumb['url'] }}"
                                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-white">
                                        {{ $breadcrumb['label'] }}
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </nav>
            @endif
        </div>

        <!-- Right Side -->
        <div class="flex items-center gap-3 2xl:gap-7">

            <!-- Dark Mode Toggle -->
            <button @click="darkMode = !darkMode"
                class="flex h-10 w-10 items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                <svg x-show="!darkMode" class="h-5 w-5 fill-current" viewBox="0 0 24 24" fill="none">
                    <path
                        d="M21.0672 11.8568L20.4253 11.469L21.0672 11.8568ZM12.1432 2.93276L11.7553 2.29085V2.29085L12.1432 2.93276ZM7.37554 20.013L7.017 19.3647L7.37554 20.013ZM2.98699 14.1824L2.33863 13.8239V13.8239L2.98699 14.1824ZM12 5.25C8.27208 5.25 5.25 8.27208 5.25 12H3.75C3.75 7.44365 7.44365 3.75 12 3.75V5.25ZM5.25 12C5.25 15.7279 8.27208 18.75 12 18.75V20.25C7.44365 20.25 3.75 16.5563 3.75 12H5.25ZM12 18.75C15.7279 18.75 18.75 15.7279 18.75 12H20.25C20.25 16.5563 16.5563 20.25 12 20.25V18.75ZM18.75 12C18.75 8.27208 15.7279 5.25 12 5.25V3.75C16.5563 3.75 20.25 7.44365 20.25 12H18.75ZM17.6269 11.469C17.1435 8.50369 14.4963 6.35651 11.7553 2.29085L12.5311 3.57467C14.9004 7.08375 17.0949 8.86516 17.4253 11.469L17.6269 11.469ZM7.73408 20.6613C10.9657 21.8863 14.6264 20.8815 17.0672 18.1445L18.2426 19.1555C15.4839 22.2378 11.2461 23.3944 7.017 19.3647L7.73408 20.6613ZM2.33863 13.8239C1.11369 17.0555 2.11853 20.7162 4.85556 23.157L5.86656 21.9816C3.44837 19.8228 2.63536 16.5361 3.63536 13.5409L2.33863 13.8239ZM11.7553 2.29085C7.72556 3.51579 4.06482 6.25283 2.33863 13.8239L3.63536 13.5409C5.23602 6.47808 8.58895 4.20012 12.5311 3.57467L11.7553 2.29085ZM17.0672 18.1445C18.8955 16.0281 19.75 13.2664 17.6269 11.469L17.4253 11.469C19.2584 13.0019 18.5045 15.4345 17.2426 17.1555L17.0672 18.1445Z"
                        fill="" />
                </svg>
                <svg x-show="darkMode" class="h-5 w-5 fill-current" style="display: none;" viewBox="0 0 24 24"
                    fill="none">
                    <path
                        d="M12 18C15.3137 18 18 15.3137 18 12C18 8.68629 15.3137 6 12 6C8.68629 6 6 8.68629 6 12C6 15.3137 8.68629 18 12 18Z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M12 2V4" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M12 20V22" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M4.93 4.93L6.34 6.34" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M17.66 17.66L19.07 19.07" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M2 12H4" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M20 12H22" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M6.34 17.66L4.93 19.07" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M19.07 4.93L17.66 6.34" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>

            <!-- Notifications -->
            <div x-data="{ dropdownOpen: false }" @click.outside="dropdownOpen = false" class="relative">
                <button @click="dropdownOpen = !dropdownOpen"
                    class="relative flex h-10 w-10 items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                    <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24" fill="none">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M13.73 21a2 2 0 0 1-3.46 0" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="absolute -top-0.5 -right-0.5 z-1 h-2 w-2 rounded-full bg-red-500">
                        <span
                            class="absolute -z-1 inline-flex h-full w-full animate-ping rounded-full bg-red-400 opacity-75"></span>
                    </span>
                </button>

                <!-- Dropdown -->
                <div x-show="dropdownOpen" x-transition
                    class="absolute -right-16 mt-2.5 flex w-80 flex-col rounded-lg border border-gray-200 bg-white shadow-lg sm:right-0 sm:w-96 dark:border-gray-700 dark:bg-gray-800"
                    style="display: none;">
                    <div class="px-4.5 py-3">
                        <h5 class="text-sm font-medium text-gray-700 dark:text-gray-200">Notificações</h5>
                    </div>
                    <ul class="flex h-auto flex-col overflow-y-auto">
                        <li>
                            <div
                                class="flex flex-col gap-2.5 border-t border-gray-200 px-4.5 py-3 hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-gray-700">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Nenhuma notificação nova</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- User Menu -->
            <div x-data="{ dropdownOpen: false }" @click.outside="dropdownOpen = false" class="relative">
                <button @click="dropdownOpen = !dropdownOpen" class="flex items-center gap-4">
                    <span class="hidden text-right lg:block">
                        <span class="block text-sm font-medium text-gray-900 dark:text-white">Sistema</span>
                        <span class="block text-xs text-gray-500 dark:text-gray-400">Administrador</span>
                    </span>

                    <span
                        class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </span>
                </button>
            </div>

        </div>

    </div>
</header>