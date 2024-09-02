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
class PHPMD {
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
	private string $rootDir;


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

		$this->rootDir = dirname(__DIR__);
	}


	/**
     * Grab the post content
     *
     * @param  RenderedContentWithFrontMatter  $result
	 *
	 * @return string
	 */
	public function getPostContent(RenderedContentWithFrontMatter $result): string
	{
		return $result->getContent();
	}


	/**
     * Grab the front matter
     *
	 * @param  RenderedContentWithFrontMatter  $result
	 * @return array
	 */
	public function getPostFrontMatter(RenderedContentWithFrontMatter $result): array
	{
		return $result->getFrontMatter();
	}


    /**
     * @param  string  $destinationDirectory
     * @param  string  $content
     * @param  string  $filePath
     *
     * @return bool
     */
    public function saveHtml(string $destinationDirectory, string $content, string $filePath = ''): bool
	{
		$filename = ($filePath !== '') ?  $this->getFileName($filePath) : 'index';
		$destinationFilePath = $destinationDirectory.$filename.'.html';

		return file_put_contents($destinationFilePath, $content) !== FALSE;
	}


	/**
	 * @param  array  $data
	 * @return string
	 */
	public function addHeaderToContent(array $data): string
	{
        extract($data);

		$title = "<h1>{$frontmatter['title']}</h1>";
		$date = "<p>Posted by: {$frontmatter['author']}, at <time>{$frontmatter['date']}</time></p>";
		$excerpt = "<p><b>{$frontmatter['excerpt']}</b><p>";
		$coverImage = '<img class="cover" src="'.BASE_URL.'public/assets/images/'.$frontmatter['cover_image'].'" alt="'.$frontmatter['title'].'">';

        return '<header>'.PHP_EOL.
                $title.PHP_EOL.
                $date.PHP_EOL.
                $coverImage.PHP_EOL.
                $excerpt.PHP_EOL.
            '</header>'.PHP_EOL.
            $content;
	}


    /**
     * @return array|null
     */
	public function generatePosts(): array|null
	{
		$sourceDirectory = $this->rootDir.'/posts';
		$destinationDirectory = $this->rootDir.'/public/posts/';
		$files = glob($sourceDirectory.'/*.md');

		// Read all markdown files and convert them to html
		foreach ($files as $filePath)
		{
			$markdown = file_get_contents($filePath);

			try
			{
				$result = $this->converter->convert($markdown);
			} catch (CommonMarkException $ex)
			{
				if (ENV === 'dev')
				{
					var_dump($ex);
				}
				die;
			}

			if ($result instanceof RenderedContentWithFrontMatter)
			{
				$frontMatter = $this->transformFrontMatter(
                    $this->getPostFrontMatter($result),
                    $filePath
                );

                $this->posts[] = $frontMatter;
                $data['frontmatter'] = $frontMatter;
                $data['content'] = $this->getPostContent($result);
                $content = $this->addHeaderToContent($data);

                ob_start();
                require $this->rootDir.'/templates/single.php';
                $content = ob_get_contents();
                ob_end_clean();

                $this->saveHtml($destinationDirectory, $content, $filePath);
            }

		}

		return $this->posts ?? NULL;
	}


    /**
     * @return void
     */
    public function generateIndexPage(): void
    {
        $destinationDirectory = $this->rootDir.'/public/';
        $posts = $this->posts;

        ob_start();
        require $this->rootDir.'/templates/index.php';
        $content = ob_get_contents();
        ob_end_clean();

        $this->saveHtml($destinationDirectory, $content);
    }


    /**
     * @param  string  $filePath
     *
     * @return string
     */private function getFileName(string $filePath): string
	{
		$parts = explode('/', $filePath);
		return substr($parts[sizeof($parts) - 1], 0, -3);
	}


    /**
     * @param  array  $frontMatter
     * @param  string  $filePath
     *
     * @return array|void
     */
    private function transformFrontMatter(array $frontMatter, string $filePath) {
        $frontMatter['slug'] = BASE_URL.'public/posts/'.$this->getFileName($filePath).'.html';
        $date = $frontMatter['date'].':00';

        try {
            $dt = new DateTime($date, new DateTimeZone('Europe/Budapest'));
            $frontMatter['date'] = $dt->format('Y-m-d H:i');
        } catch (Exception $ex) {
            if (ENV === 'dev') {
                var_dump($ex);
            }
            die;
        }

        return $frontMatter;
    }

}
