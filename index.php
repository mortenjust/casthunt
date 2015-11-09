<?
	$html = file_get_contents("https://www.producthunt.com/podcasts");	
	date_default_timezone_set('America/Los_Angeles');

	$re = "/user_id.+?name\&quot\;\:&quot\;(.*?)\&quot\;.+?\&quot\;audio\&quot\;.+?url\&quot\;\:\&quot\;(.*?)&quot\;/"; 
	preg_match_all($re, $html, $casts, PREG_SET_ORDER);	
	getFeed($casts);


	// --- 

	function getPubDate(){
		$now = time();
		return "".date('r', $now);
	}

	function getLastBuildDate(){
		return getPubDate();
	}

	function getItems($casts){
		foreach($casts as $cast){
			$name = $cast[1];
			$url = $cast[2];
			echo getItemFor($name, $url);
		}
	}

	function getItemFor($name, $url){
		?>
		    <item>
		      <itunes:author>Product Hunt</itunes:author>
		      <itunes:keywords/>
		      <itunes:duration>30:00</itunes:duration>
		      <title><?=$name?></title>
		      <guid isPermaLink="true"><?=$url?></guid>
		      <description><?=$name?></description>

		      <category>News</category>
		      <pubDate><?=getPubDate()?></pubDate>
		      <enclosure length="1800" url="<?=$url?>" type="audio/mpeg"/>
		    </item>
		<?
	}

	function getFeed($casts){
	?>
		<rss xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" version="2.0">
		  <channel>
		    <title>Product Hunt Podcasts</title>
		    <link>https://www.producthunt.com/podcasts/</link>
		    <description>Newest in category Podcasts</description>
		    <itunes:author>Product Hunt</itunes:author>
		    <copyright></copyright>

		    <language>en-us</language>
		    <pubDate><?=getPubDate()?></pubDate>
		    <lastBuildDate><?=getLastBuildDate()?></lastBuildDate>
		    <itunes:category text="News"/>
		    <itunes:explicit>No</itunes:explicit>
		    <itunes:image href="https://api.url2png.com/v6/P5329C1FA0ECB6/9d4e65258be99010146fa68aa0f066b6/png/?url=https%3A%2F%2Fwww.producthunt.com%2Fpodcasts%2F"/>

		    <itunes:subtitle>Discover podcasts</itunes:subtitle>
		    <itunes:summary></itunes:summary>
		    <itunes:owner>
		      <itunes:name>Product Hunt</itunes:name>
		      <itunes:email></itunes:email>
		    </itunes:owner>

		    <?=getItems($casts)?>

		  </channel>
		</rss>
	<?
	}