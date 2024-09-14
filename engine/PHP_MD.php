<?php

require_once __DIR__.'/PHP_MD_Base.php';
require_once dirname(__DIR__).'/extension/PHP_MD_Trait.php';

use League\CommonMark\Exception\CommonMarkException;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;

/**
 * Class for generating HTML file output from parsed markdown files
 */
class PHP_MD extends PHP_MD_Base
{
    use PHP_MD_Trait;

    public function __construct()
    {
        parent::__construct();
    }


	/**
	 * @param  string  $language
	 * @param  array   $data
	 * @param  bool    $force_build
	 *
	 * @return array
	 */
    public function generate_posts(string $language = DEFAULT_LANGUAGE, array $data = [], bool $force_build = false): array
    {
	    $this->posts           = [];
	    $source_directory      = $this->root_dir . '/posts/' . $this->get_language_segment($language);
	    $destination_directory = $this->root_dir . '/public/posts/' . $this->get_language_segment($language);
	    $files                 = glob($source_directory.'/*.md');
	    $lc_time               = $this->get_lc_time($language);
	    $this->force_build     = $force_build;
	    $last_build_date       = $this->get_build_time();

        // Read all markdown files and convert them to html
        foreach ($files as $filepath) {
            $markdown = file_get_contents($filepath);
			$file_modification_date = filemtime($filepath);

			// Do not run markdown conversion if the file hasn't been modified since the last build, unless the force option is used
			if ($this->force_build === false && $last_build_date !== 0 && $file_modification_date < $last_build_date) {
				continue;
			}

            try {
                $result = $this->converter->convert($markdown);
            } catch (CommonMarkException $ex) {
                var_dump($ex);
                die;
            }

            if ($result instanceof RenderedContentWithFrontMatter) {
                $frontMatter = $this->transform_front_matter(
                    $this->get_post_front_matter($result),
                    $filepath,
                    $language,
                    $data['timezone'],
                    $lc_time
                );

                $this->posts[]          = $frontMatter;
                $data['frontmatter']    = $frontMatter;
                $data['content']        = $this->get_post_content($result);
                $data['template_name']  = 'single';

                $content = $this->render_view_and_return($data);

                $this->save_html($destination_directory, $content, $filepath);
            }
        }

        $this->posts = array_reverse($this->posts, true);

        return $this->posts;
    }


    /**
     * @param  string  $language
     * @param  array  $data
     *
     * @return void
     */
    public function generate_index_page(string $language = DEFAULT_LANGUAGE, array $data = []): void
    {
        $destination_directory  = $this->root_dir.'/public/'.$this->get_language_segment($language);
		$data['posts']          = array_slice($this->posts, 0, POST_LIMIT);
        $data['template_name']  = 'index';

        $content = $this->render_view_and_return($data);

        $this->save_html($destination_directory, $content);
    }


    /**
     * @param  string  $language
     * @param  array  $data
     *
     * @return void
     */
    public function generate_archive_page(string $language = DEFAULT_LANGUAGE, array $data = []): void
    {
        $destination_directory  = $this->root_dir . '/public/' . $this->get_language_segment($language);
        $data['posts']          = $this->posts;
        $data['template_name']  = 'archive';
        $data['lc_time']        = $this->get_lc_time($language);

        try {
            /* Create post list grouped by month/year */
            $year_month_groups = [];
            foreach ($this->posts as $post) {
                $post_date  = new \DateTime($post['date_original'], new \DateTimeZone($data['timezone']));
                $formatter  = $this->get_local_datetime_formatter($data['lc_time'], $data['timezone'], $data['pattern']);

                $year_month_groups[$post_date->format('M Y')] = $formatter->format($post_date);
            }
            $data['year_month_groups'] = array_unique($year_month_groups);
        } catch (Exception $ex) {
            var_dump($ex);
            die;
        }

        $content = $this->render_view_and_return($data);

        $this->save_html($destination_directory, $content, '', $data['template_name']);
    }


    /**
     * @param  string  $language
     * @param  array  $data
     *
     * @return void
     */
    public function generate_404_page(string $language = DEFAULT_LANGUAGE, array $data = []): void
    {
        $destination_directory  = $this->root_dir . '/public/' . $this->get_language_segment($language);
        $data['template_name']  = '404';

        $content = $this->render_view_and_return($data);

        $this->save_html($destination_directory, $content, '', '404');
    }

}
