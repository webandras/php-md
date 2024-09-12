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
    protected function get_post_content(RenderedContentWithFrontMatter $result ): string
    {
        return $result->getContent();
    }


    /**
     * Grab the front matter
     *
     * @param  RenderedContentWithFrontMatter  $result
     *
     * @return array
     */
    protected function get_post_front_matter(RenderedContentWithFrontMatter $result ): array
    {
        return $result->getFrontMatter();
    }


    /**
     * Transforms/formats frontmatter properties of the blogpost
     *
     * @param  array  $front_matter
     * @param  string  $filepath
     * @param  string  $language
     * @param  string  $timezone
     * @param  string  $lc_time
     *
     * @return array|void
     */
    protected function transform_front_matter(
        array $front_matter,
        string $filepath,
        string $language,
        string $timezone = DEFAULT_TIMEZONE,
        string $lc_time = 'en_GB'
    ) {
        $front_matter['slug']   = BASE_URL . 'posts/' . $this->get_language_segment($language) . $this->get_filename($filepath).'.html';
        $datetime               = $front_matter['date'].':00';

        try {
            $dt = date_create($datetime);
            $formatter = $this->get_local_datetime_formatter($lc_time, $timezone);
            $local_dt = $formatter->format($dt);

            $front_matter['date'] = $local_dt;
            $front_matter['date_original'] = $datetime;
        } catch (Exception $ex) {
            var_dump($ex);
            die;
        }

        return $front_matter;
    }


    /**
     * Get language folder name for generating urls
     *
     * @param  string  $language
     *
     * @return string
     */
    protected function get_language_segment(string $language): string
    {
        return $language !== DEFAULT_LANGUAGE ? ($language.'/') : '';
    }


    /**
     * Returns datetime in locale format and timezone
     *
     * @param  string  $lc_time  (format: "en_GB", "hu_HU", "lt_LT" etc.)
     * @param  string  $timezone
     * @param  string|null  $pattern
     *
     * @return IntlDateFormatter|null
     */
    protected function get_local_datetime_formatter(string $lc_time, string $timezone, string $pattern = null): ?IntlDateFormatter
    {
        $format = new IntlDateFormatter(
            $lc_time,
            IntlDateFormatter::LONG,
            IntlDateFormatter::SHORT,
            $timezone,
            IntlDateFormatter::GREGORIAN,
            $pattern
        );

        return $format;
    }


    /**
     * Get language code in a format like this: 'en_GB'
     *
     * @param  string  $language_code
     *
     * @return string
     */
    protected function get_lc_time(string $language_code = 'en-gb'): string {
        $lc_time = explode('-', $language_code);
        $lc_time = implode('_', [$lc_time[0], strtoupper($lc_time[1])]);

        return $lc_time;
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
        $filename               = ($filePath !== '') ? $this->get_filename($filePath) : $fileName;
        $destination_filepath   = $destination_directory . $filename . '.html';

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
        require $this->root_dir . '/templates/views/' . $template_name . '.php';
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }


}
