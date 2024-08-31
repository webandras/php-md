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
	 * @param  RenderedContentWithFrontMatter  $result
	 * @return string
	 */
	public function getPostContent(RenderedContentWithFrontMatter $result): string
	{
		// Grab the post content
		return $result->getContent();
	}

	/**
	 * @param  RenderedContentWithFrontMatter  $result
	 * @return array
	 */
	public function getPostFrontMatter(RenderedContentWithFrontMatter $result): array
	{
		// Grab the front matter
		return $result->getFrontMatter();
	}


	/**
	 * @param  string  $filePath
	 * @param  string  $destinationDirectory
	 * @param  array  $data
	 * @return bool
	 */
	public function savePost(string $filePath, string $destinationDirectory, array $data): bool
	{
		$filename = $this->getFileName($filePath);
		$destinationFilePath = $destinationDirectory.$filename.'.html';

		return file_put_contents($destinationFilePath, $data['content']) !== FALSE;
	}


	/**
	 * @param  array  $post
	 * @return void
	 */
	public function setPostHeader(array &$post): void
	{
		$headers = $post['frontmatter'];
		$title = "<h1>{$headers['title']}</h1>";
		$date = "<p>Posted by: {$headers['author']}, at <time>{$headers['date']}</time></p>";
		$excerpt = "<p><b>{$headers['excerpt']}</b><p>";
		$coverImage = '<img class="cover" src="'.BASE_URL.'public/assets/images/'.$headers['cover_image'].'" alt="'.$headers['title'].'">';

		$post['content'] = $title.PHP_EOL.
			$date.PHP_EOL.
			$coverImage.PHP_EOL.
			$excerpt.PHP_EOL.
			$post['content'];
	}


	/**
	 * @param  bool  $frontMatterOnly
	 * @return array|null
	 * @throws Exception
	 */
	public function generatePosts(bool $frontMatterOnly = FALSE): array|null
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
				$frontMatter = $this->getPostFrontMatter($result);

				if ($frontMatterOnly === TRUE)
				{
					$frontMatter['slug'] = BASE_URL.'public/posts/'.$this->getFileName($filePath).'.html';

					$date = $frontMatter['date'].':00';

					try
					{
						$dt = new DateTime($date, new DateTimeZone('Europe/Budapest'));
						$frontMatter['date'] = $dt->format('Y-m-d H:i');
					} catch (Exception $ex)
					{
						if (ENV === 'dev')
						{
							var_dump($ex);
						}
						die;
					}

					$posts[] = $frontMatter;
				} else
				{
					$post['frontmatter'] = $frontMatter;
					$post['content'] = $this->getPostContent($result);

					$this->setPostHeader($post);

					ob_start();
					require $this->rootDir.'/layouts/post.php';
					$post['content'] = ob_get_contents();
					ob_end_clean();

					$this->savePost($filePath, $destinationDirectory, $post);
				}
			}
		}

		return $posts ?? NULL;
	}


	private function getFileName(string $filePath): string
	{
		$parts = explode('/', $filePath);
		return substr($parts[sizeof($parts) - 1], 0, -3);
	}


}
