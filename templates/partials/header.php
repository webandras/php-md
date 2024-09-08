<header class="header">
    <nav class="container container-lg">
        <a href="<?= BASE_URL.get_language_segment($language_code) ?>">
            <img src="<?= BASE_URL.'assets/images/php-md-logo.png' ?>" alt="<?= out($website_name) ?> logo" height="50px" width="95.83px"/>
            <span></span>
        </a>

        <section class="header--section-1">
            <section id="navbar-default">
                <ul>
                    <li>
                        <a href="<?= BASE_URL.get_language_segment($language_code) ?>" <?php echo set_active_page_link($template_name) ?>><?= $home_text ?></a>
                    </li>
                    <li>
                        <a href="<?= BASE_URL.get_language_segment($language_code) ?>archive" <?php echo set_active_page_link($template_name, 'archive') ?>><?= $archive_text ?></a>
                    </li>
                </ul>
            </section>

            <section class="header--section-2">
                <button id="theme-toggle" type="button" title="<?= $dark_mode_text ?>">
                    <svg id="theme-toggle-dark-icon" class="hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon" class="hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                              fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <button id="toggle-menu" title="<?= $open_menu_text ?>" data-collapse-toggle="navbar-default" type="button"
                        aria-controls="navbar-default" aria-expanded="false"
                >
                    <span class="sr-only"><?= $open_menu_text ?></span>
                    <svg aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                              clip-rule="evenodd"
                        ></path>
                    </svg>
                </button>
            </section>
        </section>
    </nav>
</header>

<article class="sidenav" id="main-sidenav">
    <a href="javascript:void(0)" role="button" aria-label="<?= $close_sidenav_text ?>" id="close-btn" class="close-btn">&times;</a>
    <section id="mobile-nav"></section>
</article>

