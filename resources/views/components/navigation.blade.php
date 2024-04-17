<nav 
x-data="{ isOpen: false }" class="flex-1 space-y-1 bg-white px-2" 
aria-label="Sidebar">
    <div>
        <!-- Current: "bg-gray-100 text-gray-900", Default: "bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900" -->
        <a href="#"
            class="bg-gray-100 text-gray-900 group w-full flex items-center pl-7 pr-2 py-2 text-sm font-medium rounded-md">Dashboard</a>
    </div>

    <div class="space-y-1">
        <!-- Current: "bg-gray-100 text-gray-900", Default: "bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900" -->
        <button type="button"
            class="bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900 group w-full flex items-center pr-2 py-2 text-left text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
            aria-controls="sub-menu-1" aria-expanded="false">
            <!-- Expanded: "text-gray-400 rotate-90", Collapsed: "text-gray-300" -->
            <svg class="text-gray-300 mr-2 h-5 w-5 flex-shrink-0 transform transition-colors duration-150 ease-in-out group-hover:text-gray-400"
                viewBox="0 0 20 20" aria-hidden="true">
                <path d="M6 6L14 10L6 14V6Z" fill="currentColor" />
            </svg>
            Team
        </button>
        <!-- Expandable link section, show/hide based on state. -->
        <div class="space-y-1" id="sub-menu-1">
            <a href="#"
                class="group flex w-full items-center rounded-md py-2 pl-10 pr-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">Overview</a>

            <a href="#"
                class="group flex w-full items-center rounded-md py-2 pl-10 pr-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">Members</a>

            <a href="#"
                class="group flex w-full items-center rounded-md py-2 pl-10 pr-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">Calendar</a>

            <a href="#"
                class="group flex w-full items-center rounded-md py-2 pl-10 pr-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">Settings</a>
        </div>
    </div>

    <div class="space-y-1">
        <!-- Current: "bg-gray-100 text-gray-900", Default: "bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900" -->
        <button type="button"
            class="bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900 group w-full flex items-center pr-2 py-2 text-left text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
            aria-controls="sub-menu-2" aria-expanded="false">
            <!-- Expanded: "text-gray-400 rotate-90", Collapsed: "text-gray-300" -->
            <svg class="text-gray-300 mr-2 h-5 w-5 flex-shrink-0 transform transition-colors duration-150 ease-in-out group-hover:text-gray-400"
                viewBox="0 0 20 20" aria-hidden="true">
                <path d="M6 6L14 10L6 14V6Z" fill="currentColor" />
            </svg>
            Projects
        </button>
        <!-- Expandable link section, show/hide based on state. -->
        <div class="space-y-1" id="sub-menu-2">
            <a href="#"
                class="group flex w-full items-center rounded-md py-2 pl-10 pr-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">Overview</a>

            <a href="#"
                class="group flex w-full items-center rounded-md py-2 pl-10 pr-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">Members</a>

            <a href="#"
                class="group flex w-full items-center rounded-md py-2 pl-10 pr-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">Calendar</a>

            <a href="#"
                class="group flex w-full items-center rounded-md py-2 pl-10 pr-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">Settings</a>
        </div>
    </div>

    <div class="space-y-1">
        <!-- Current: "bg-gray-100 text-gray-900", Default: "bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900" -->
        <button type="button"
            class="bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900 group w-full flex items-center pr-2 py-2 text-left text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
            aria-controls="sub-menu-3" aria-expanded="false">
            <!-- Expanded: "text-gray-400 rotate-90", Collapsed: "text-gray-300" -->
            <svg class="text-gray-300 mr-2 h-5 w-5 flex-shrink-0 transform transition-colors duration-150 ease-in-out group-hover:text-gray-400"
                viewBox="0 0 20 20" aria-hidden="true">
                <path d="M6 6L14 10L6 14V6Z" fill="currentColor" />
            </svg>
            Calendar
        </button>
        <!-- Expandable link section, show/hide based on state. -->
        <div class="space-y-1" id="sub-menu-3">
            <a href="#"
                class="group flex w-full items-center rounded-md py-2 pl-10 pr-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">Overview</a>

            <a href="#"
                class="group flex w-full items-center rounded-md py-2 pl-10 pr-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">Members</a>

            <a href="#"
                class="group flex w-full items-center rounded-md py-2 pl-10 pr-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">Calendar</a>

            <a href="#"
                class="group flex w-full items-center rounded-md py-2 pl-10 pr-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">Settings</a>
        </div>
    </div>

    <div class="space-y-1">
        <!-- Current: "bg-gray-100 text-gray-900", Default: "bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900" -->
        <button type="button"
            class="bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900 group w-full flex items-center pr-2 py-2 text-left text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
            aria-controls="sub-menu-4" aria-expanded="false">
            <!-- Expanded: "text-gray-400 rotate-90", Collapsed: "text-gray-300" -->
            <svg class="text-gray-300 mr-2 h-5 w-5 flex-shrink-0 transform transition-colors duration-150 ease-in-out group-hover:text-gray-400"
                viewBox="0 0 20 20" aria-hidden="true">
                <path d="M6 6L14 10L6 14V6Z" fill="currentColor" />
            </svg>
            Documents
        </button>
        <!-- Expandable link section, show/hide based on state. -->
        <div class="space-y-1" id="sub-menu-4">
            <a href="#"
                class="group flex w-full items-center rounded-md py-2 pl-10 pr-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">Overview</a>

            <a href="#"
                class="group flex w-full items-center rounded-md py-2 pl-10 pr-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">Members</a>

            <a href="#"
                class="group flex w-full items-center rounded-md py-2 pl-10 pr-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">Calendar</a>

            <a href="#"
                class="group flex w-full items-center rounded-md py-2 pl-10 pr-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">Settings</a>
        </div>
    </div>

    <div class="space-y-1">
        <!-- Current: "bg-gray-100 text-gray-900", Default: "bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900" -->
        <button type="button"
            class="bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900 group w-full flex items-center pr-2 py-2 text-left text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
            aria-controls="sub-menu-5" aria-expanded="false">
            <!-- Expanded: "text-gray-400 rotate-90", Collapsed: "text-gray-300" -->
            <svg class="text-gray-300 mr-2 h-5 w-5 flex-shrink-0 transform transition-colors duration-150 ease-in-out group-hover:text-gray-400"
                viewBox="0 0 20 20" aria-hidden="true">
                <path d="M6 6L14 10L6 14V6Z" fill="currentColor" />
            </svg>
            Reports
        </button>
        <!-- Expandable link section, show/hide based on state. -->
        <div class="space-y-1" id="sub-menu-5">
            <a href="#"
                class="group flex w-full items-center rounded-md py-2 pl-10 pr-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">Overview</a>

            <a href="#"
                class="group flex w-full items-center rounded-md py-2 pl-10 pr-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">Members</a>

            <a href="#"
                class="group flex w-full items-center rounded-md py-2 pl-10 pr-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">Calendar</a>

            <a href="#"
                class="group flex w-full items-center rounded-md py-2 pl-10 pr-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">Settings</a>
        </div>
    </div>
</nav>


{{-- <a href="#" class="text-gray-700 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <!-- Heroicon name: outline/bars-4 -->
        <svg class="text-gray-400 group-hover:text-gray-500 mr-3 flex-shrink-0 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" 
          d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" />
        </svg>
        My tasks
      </a>

      <a href="#" class="text-gray-700 hover:text-gray-900 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <!-- Heroicon name: outline/clock -->
        <svg class="text-gray-400 group-hover:text-gray-500 mr-3 flex-shrink-0 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" 
          d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Recent
      </a> --}}
</div>
{{-- <div class="mt-8">
      <!-- Secondary navigation -->
      <h3 class="px-3 text-sm font-medium text-gray-500" id="desktop-teams-headline">Teams</h3>
      <div class="mt-1 space-y-1" role="group" aria-labelledby="desktop-teams-headline">
        <a href="#" class="group flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">
          <span class="w-2.5 h-2.5 mr-4 bg-indigo-500 rounded-full" aria-hidden="true"></span>
          <span class="truncate">Engineering</span>
        </a>

        <a href="#" class="group flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">
          <span class="w-2.5 h-2.5 mr-4 bg-green-500 rounded-full" aria-hidden="true"></span>
          <span class="truncate">Human Resources</span>
        </a>

        <a href="#" class="group flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">
          <span class="w-2.5 h-2.5 mr-4 bg-yellow-500 rounded-full" aria-hidden="true"></span>
          <span class="truncate">Customer Success</span>
        </a>
      </div> --}}
</div>
</nav>
