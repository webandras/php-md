<?php

use League\CommonMark\Environment\Environment;
use League\CommonMark\Exception\CommonMarkException;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;
use League\CommonMark\MarkdownConverter;

/**
 * Class for generating HTML file output from parsed markdown files
 */
class PHP_MD
{
    /**
     * @var MarkdownConverter
     */
    private MarkdownConverter $converter;


    /**
     * @var array
     */
    public array $posts = [];


    /**
     * @var string
     */
    private string $root_dir;


    public function __construct()
    {
        // Define your configuration, if needed
        $markdownConfig = [];

        // Configure the Environment with all the CommonMark parsers/renderers
        $environment = new Environment($markdownConfig);
        $environment->addExtension(new CommonMarkCoreExtension());

        // Add the extension
        $environment->addExtension(new FrontMatterExtension());

        // Instantiate the converter engine and start converting some Markdown!
        $this->converter = new MarkdownConverter($environment);

        $this->root_dir = dirname(__DIR__);
    }


    /**
     * Grab the post content
     *
     * @param  RenderedContentWithFrontMatter  $result
     *
     * @return string
     */
    public function get_post_content(RenderedContentWithFrontMatter $result
    ): string {
        return $result->getContent();
    }


    /**
     * Grab the front matter
     *
     * @param  RenderedContentWithFrontMatter  $result
     *
     * @return array
     */
    public function get_post_front_matter(RenderedContentWithFrontMatter $result
    ): array {
        return $result->getFrontMatter();
    }


    /**
     * @param  string  $destination_directory
     * @param  string  $content
     * @param  string  $filePath
     * @param  string  $fileName
     *
     * @return bool
     */
    public function save_html(
        string $destination_directory,
        string $content,
        string $filePath = '',
        string $fileName = 'index'
    ): bool {
        $filename             = ($filePath !== '') ? $this->get_filename($filePath) : $fileName;
        $destination_filepath = $destination_directory.$filename.'.html';

        if (!is_dir($destination_directory)) {
            mkdir($destination_directory, 0755);
        }

        return file_put_contents($destination_filepath, $content) !== false;
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
        $source_directory      = $this->root_dir.'/posts/'.($language !== DEFAULT_LANGUAGE ? ($language.'/') : '');
        $destination_directory = $this->root_dir.'/public/posts/'.($language !== DEFAULT_LANGUAGE ? ($language.'/') : '');
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
                $data['page_name']   = 'post';
                $data['root_dir']    = $this->root_dir;
                extract($data);

                ob_start();
                require $this->root_dir.'/templates/views/single.php';
                $content = ob_get_contents();
                ob_end_clean();

                $this->save_html($destination_directory, $content, $filepath);
            }
        }

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
        $destination_directory = $this->root_dir.'/public/'.($language !== DEFAULT_LANGUAGE ? ($language.'/') : '');
        $data['posts']         = $this->posts;
        $data['page_name']     = 'index';
        $data['root_dir']      = $this->root_dir;
        extract($data);

        ob_start();
        require $this->root_dir.'/templates/views/index.php';
        $content = ob_get_contents();
        ob_end_clean();

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
        $destination_directory = $this->root_dir.'/public/'.($language !== DEFAULT_LANGUAGE ? ($language.'/') : '');
        $data['posts']                 = $this->posts;
        $data['page_name']             = 'archive';
        $data['root_dir']              = $this->root_dir;
        extract($data);

        ob_start();
        require $this->root_dir.'/templates/views/archive.php';
        $content = ob_get_contents();
        ob_end_clean();

        $this->save_html($destination_directory, $content, '', $page_name);
    }


    /**
     * @param  string  $filePath
     *
     * @return string
     */
    private function get_filename(string $filePath): string
    {
        $parts = explode('/', $filePath);

        return substr($parts[sizeof($parts) - 1], 0, -3);
    }


    /**
     * @param  array  $front_matter
     * @param  string  $filepath
     * @param  string  $language
     *
     * @return array|void
     */
    private function transform_front_matter(
        array $front_matter,
        string $filepath,
        string $language
    ) {
        $front_matter['slug'] = BASE_URL.'posts/'.($language !== DEFAULT_LANGUAGE ? ($language.'/') : '').$this->get_filename($filepath).'.html';
        $date = $front_matter['date'].':00';

        try {
            $dt = new DateTime($date, new DateTimeZone(DEFAULT_TIMEZONE));
            $front_matter['date'] = $dt->format(DEFAULT_DATE_FORMAT);
        } catch (Exception $ex) {
            var_dump($ex);
            die;
        }

        return $front_matter;
    }

}
