<nav class="breadcrumb" aria-label="breadcrumb">
    <ol>
        <li>
            <a href="<?= BASE_URL. get_language_segment($current_language_code) ?>" class="breadcrumb--home-link">
                <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path
                            d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"
                    ></path>
                </svg>
                <span><?= $breadcrumb_home_text ?></span>
            </a>
        </li>

        <li aria-current="page">
            <div>
                <svg fill="currentColor" class="icon" viewBox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"
                    ></path>
                </svg>
                <?php
                if (isset($frontmatter)) { ?>
                    <span><?= $frontmatter['title'] ?></span>
                    <?php
                } else { ?>
                    <span><?= $template_name ?></span>
                    <?php
                } ?>
            </div>
        </li>
    </ol>
</nav>

