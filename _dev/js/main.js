import './../sass/main.sass';

const onLoad = () => {
    // Fast deploy to Netlify
    const deployBtn = document.querySelector('#deploy');
    if (deployBtn) {
        deployBtn.addEventListener("click", () => {
            window.location.href = 'https://app.netlify.com/start/deploy?repository=https://github.com/webandras/php-md';
        });
    }

    toggleDarkMode();

    // dark mode switcher
    function toggleDarkMode() {
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

    //
    const languageSwitcherTriggerBtn = document.getElementById("language-switcher-trigger-button");
    const languageSwitcherCurrentLanguage = document.getElementById("language-switcher-current-language");

    document.onclick = function (e) {
        if (e.target.id !== 'main-sidenav' &&
            e.target.id !== 'close-btn' &&
            e.target.id !== 'toggle-menu' &&
            e.target.id !== 'toggle-menu-hamburger-icon'
        ) {
            if (e.target.offsetParent && e.target.offsetParent.id !== 'main-sidenav')
                closeOffcanvasNavigation();
        }


        if (languageSwitcherTriggerBtn !== null && e.target.id !== 'language-switcher-dropdown' &&
            e.target.id !== 'language-switcher-trigger-button' &&
            e.target.id !== 'language-switcher-current-language'
        ) {
            if (e.target.offsetParent && e.target.offsetParent.id !== 'language-switcher-dropdown')
                toggleLanguageDropdown('hide');
        }
    }

    if (languageSwitcherTriggerBtn) {
        // Sidebar open menu
        languageSwitcherTriggerBtn.addEventListener('click', function () {
            toggleLanguageDropdown('show')
        });
        languageSwitcherCurrentLanguage.addEventListener('click', function () {
            toggleLanguageDropdown('show')
        });
    }

    function toggleLanguageDropdown(state) {
        const langDropdown = document.querySelector('.language-switcher-dropdown');
        langDropdown.style.display = (state === 'hide') ? 'none' : 'flex'
    }

};

// only execute when DOM is ready
window.addEventListener("DOMContentLoaded", onLoad);