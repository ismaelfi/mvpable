<div 
    x-data="themeSelector()" 
    x-init="initTheme()" 
    class="fixed bottom-4 right-4 z-50"
>
    <button 
        @click="isOpen = !isOpen" 
        class="flex items-center justify-center p-3 text-base-content bg-base-200 rounded-full shadow-lg hover:bg-base-300 transition-all duration-300 transform hover:scale-110"
        :class="{'rotate-180': isOpen}"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
        </svg>
    </button>

    <div 
        x-show="isOpen" 
        @click.outside="isOpen = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        class="absolute bottom-16 right-0 w-64 max-h-96 overflow-y-auto p-4 bg-base-200 rounded-lg shadow-xl"
    >
        <h3 class="text-lg font-bold mb-3 text-center">Select Theme</h3>
        <div class="grid grid-cols-2 gap-2">
            <template x-for="theme in themes" :key="theme">
                <button 
                    @click="setTheme(theme)"
                    class="btn btn-sm capitalize" 
                    :class="currentTheme === theme ? 'btn-primary' : 'btn-ghost'"
                    x-text="theme"
                ></button>
            </template>
        </div>
    </div>
</div>

<script>
function themeSelector() {
    return {
        isOpen: false,
        currentTheme: localStorage.getItem('theme') || 'light',
        themes: [
            "light", "dark", "cupcake", "bumblebee", "emerald", "corporate", 
            "synthwave", "retro", "cyberpunk", "valentine", "halloween", 
            "garden", "forest", "aqua", "lofi", "pastel", "fantasy", 
            "wireframe", "black", "luxury", "dracula", "cmyk", "autumn", 
            "business", "acid", "lemonade", "night", "coffee", "winter", 
            "dim", "nord", "sunset"
        ],
        initTheme() {
            // Apply the saved theme or default to light
            this.currentTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', this.currentTheme);
            
            // Sync with the existing theme switcher if it exists
            const existingThemeSwitcher = document.getElementById('theme-switcher');
            if (existingThemeSwitcher) {
                existingThemeSwitcher.checked = this.currentTheme === 'dark';
            }
        },
        setTheme(theme) {
            // Update the theme
            this.currentTheme = theme;
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            
            // Sync with the existing theme switcher if it exists
            const existingThemeSwitcher = document.getElementById('theme-switcher');
            if (existingThemeSwitcher) {
                existingThemeSwitcher.checked = theme === 'dark';
            }
            
            // Close the dropdown
            this.isOpen = false;
        }
    };
}
</script>