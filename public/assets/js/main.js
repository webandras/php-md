const onLoad = () => {
    toggleDarkMode();

    // dark mode switcher
    function toggleDarkMode() {

        // if darkmode disabled
        if (!config.darkMode) {
            return;
        }

        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        // Change the icons inside the button based on previous settings
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        const themeToggleBtn = document.getElementById('theme-toggle');
        themeToggleBtn.addEventListener('click', function () {

            // toggle icons inside button
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            // if set via local storage previously
            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }

                // if NOT set via local storage previously
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            }

        });

    }

    // SIDEBAR MENU
    /* Set the width of the side navigation to 250px */
    function openOffcanvasNavigation() {
        const defaultNavbar = document.getElementById("navbar-default");
        const defaultNavbarClone = defaultNavbar.cloneNode(true);

        // delete previous cloned content
        const mobileNav = document.getElementById("mobile-nav");
        mobileNav.innerText = '';
        mobileNav.appendChild(defaultNavbarClone);
        document.getElementById("main-sidenav").style.width = "250px";
    }

    /* Set the width of the side navigation to 0, delete cloned menu */
    function closeOffcanvasNavigation() {
        document.getElementById("main-sidenav").style.width = "0";
        document.getElementById("mobile-nav").innerText = '';
    }

    // Sidebar close button
    document.getElementById('close-btn').addEventListener('click', closeOffcanvasNavigation);

    // Sidebar open menu
    document.getElementById("toggle-menu").addEventListener('click', openOffcanvasNavigation);

};

// only execute when DOM is ready
window.addEventListener("DOMContentLoaded", onLoad);