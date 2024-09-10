<?php

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;
use League\CommonMark\MarkdownConverter;

class PHP_MD_Base
{
    /**
     * @var MarkdownConverter
     */
    protected MarkdownConverter $converter;


    /**
     * @var array
     */
    protected array $posts = [];


    /**
     * @var string
     */
    protected string $root_dir;


    public function __construct() {
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
    protected function get_post_content(RenderedContentWithFrontMatter $result
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
    protected function get_post_front_matter(RenderedContentWithFrontMatter $result
    ): array {
        return $result->getFrontMatter();
    }


    /**
     * @param  array  $front_matter
     * @param  string  $filepath
     * @param  string  $language
     * @param  string  $timezone
     * @param  string  $date_format
     *
     * @return array|void
     */
    protected function transform_front_matter(
        array $front_matter,
        string $filepath,
        string $language,
        string $timezone = DEFAULT_TIMEZONE,
        string $date_format = DEFAULT_DATE_FORMAT
    ) {
        $front_matter['slug'] = BASE_URL.'posts/'. $this->get_language_segment($language) . $this->get_filename($filepath).'.html';
        $date = $front_matter['date'].':00';

        try {
            $dt = new DateTime($date, new \DateTimeZone(DEFAULT_TIMEZONE));
            $local_dt = $dt->setTimezone(new DateTimeZone($timezone));

            $front_matter['date'] = $local_dt->format($date_format);
        } catch (Exception $ex) {
            var_dump($ex);
            die;
        }

        return $front_matter;
    }


    /**
     * @param  string  $language
     *
     * @return string
     */
    protected function get_language_segment(string $language): string
    {
        return $language !== DEFAULT_LANGUAGE ? ($language.'/') : '';
    }


    /**
     * Gets a filename from a file path
     *
     * @param  string  $filePath
     *
     * @return string
     */
    protected function get_filename(string $filePath): string
    {
        $parts = explode('/', $filePath);

        return substr($parts[sizeof($parts) - 1], 0, -3);
    }


    /**
     * Saves file to a specified location, and with a specified filename
     *
     * @param  string  $destination_directory
     * @param  string  $content
     * @param  string  $filePath
     * @param  string  $fileName
     *
     * @return bool
     */
    protected function save_html(
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
     * Renders the view with the data passed to it, and returns output buffer content
     *
     * @param  array  $data
     *
     * @return string
     */
    protected function render_view_and_return(array $data): string {
        $data['root_dir'] = $this->root_dir;
        extract($data);

        ob_start();
        require $this->root_dir.'/templates/views/' . $template_name . '.php';
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }


}
