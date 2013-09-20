<?php 

class RssHelper {

	protected $titleChannel;
	protected $linkChannel;
	protected $descriptionChannel;
	protected $webmaster;
	protected $imageTitleChannel;
	protected $language = 'fr';
	protected $ttl = '60';
	protected $title;
	protected $link;
	protected $category;
	protected $description;
	protected $author;
	protected $pubDate;
	protected $guid;
	protected $source;

	protected $loaded = "";
	


	public function startRss() {
		$this->loaded .= '<?xml version="1.0" encoding="UTF-8" ?>
			<rss version="2.0">
			<channel>
			<title>'.$this->titleChannel.'</title>
			<link>'.$this->linkChannel.'</link>
			<description>'.$this->descriptionChannel.'</description>
			<ttl>'.$this->ttl.'</ttl>

			';
	}
	public function loadItem() {
		$this->loaded .= '
			<item>
				<title><![CDATA['.$this->title.']]></title>
				<link>'.$this->link.'</link>
				<description><![CDATA['.$this->description.']]></description>
				<author>'.$this->author.'</author>
				<category><![CDATA['.$this->category.']]></category>
				<guid isPermaLink="true"><![CDATA['.$this->guid.']]></guid>
				<pubDate>'.$this->pubDate.'</pubDate>
				<source>'.$this->source.'</source>
			</item>	
		';
	}
	public function endRss() {
		$this->loaded .= '
			</channel>
			</rss>
			
			';
	}
	public function writeRss($file) {
		$fp = fopen($file,"w+");
		ftruncate($fp,0);
		fwrite($fp, $this->loaded);
		fclose($fp);
	}
	
	//the channel's setters
	public function TitleChannel($data) {
		$this->titleChannel = $data;
		return $this;
	}
	public function LinkChannel($data) {
		$this->linkChannel = $data;
		return $this;

	}
	public function DescriptionChannel($data) {
		$this->descriptionChannel = $data;
		return $this;

	}
	public function Webmaster($data) {
		$this->webmaster = $data;
		return $this;

	}
	public function ImageTitleChannel($data) {
		$this->imageTitleChannel = $data;
		return $this;

	}
	public function Language($data) {
		$this->language = $data;
		return $this;

	}
	public function Ttl($data) {
		$this->ttl = $data;
		return $this;
	}
	//the item's setters
	public function Title($data) {
		$this->title = $data;
		return $this;

	}
	public function Link($data) {
		$this->link  = $data;
		return $this;

	}

	public function Category($data) {
		$this->category = $data;
		return $this;

	}
	public function Description($data) {
		$this->description = $data;
		return $this;

	}
	public function Author ($data) {
		$this->author = $data;
		return $this;

	}
	public function PubDate($data) {
		$this->pubDate = $data;
		return $this;

	}
	public function Guid($data) {
		$this->guid = $data;
		return $this;

	}
	public function Source() {
		$this->source = $this->linkChannel;
		return $this;

	}
}

?>
