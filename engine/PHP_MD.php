<?php

require_once __DIR__.'/PHP_MD_Base.php';
require_once __DIR__.'/PHP_MD_Trait.php';

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
     * @param  array  $data
     *
     * @return array|null
     */
    public function generate_posts(string $language = DEFAULT_LANGUAGE, array $data = []): array|null
    {
        $this->posts           = [];
        $source_directory      = $this->root_dir.'/posts/'.$this->get_language_segment($language);
        $destination_directory = $this->root_dir.'/public/posts/'.$this->get_language_segment($language);
        $files                 = glob($source_directory.'/*.md');

        // Read all markdown files and convert them to html
        foreach ($files as $filepath) {
            $markdown = file_get_contents($filepath);

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
                    $language
                );

                $this->posts[]       = $frontMatter;
                $data['frontmatter'] = $frontMatter;
                $data['content']     = $this->get_post_content($result);
                $data['template_name']   = 'single';

                $content = $this->render_view_and_return($data);

                $this->save_html($destination_directory, $content, $filepath);
            }
        }

        $this->posts = array_reverse($this->posts, true);

        return $this->posts ?? null;
    }


    /**
     * @param  string  $language
     * @param  array  $data
     *
     * @return void
     */
    public function generate_index_page(string $language = DEFAULT_LANGUAGE, array $data = []): void
    {
        $destination_directory = $this->root_dir.'/public/'.$this->get_language_segment($language);
        $data['posts']         = $this->posts;
        $data['template_name'] = 'index';

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
        $destination_directory = $this->root_dir.'/public/'.$this->get_language_segment($language);
        $data['posts']                 = $this->posts;
        $data['template_name']         = 'archive';

        $content = $this->render_view_and_return($data);

        $this->save_html($destination_directory, $content, '', $data['template_name']);
    }

}
