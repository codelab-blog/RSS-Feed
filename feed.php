<?php

define('BASE_URL', 'http://localhost');

$db = new PDO('mysql:host=127.0.0.1;dbname=codelab', 'root', 'root');

$posts = $db->query("
	SELECT title, subtitle, slug, date
	FROM posts
	ORDER BY date DESC
")->fetchAll(PDO::FETCH_ASSOC);


$data = '<?xml version="1.0" encoding="ISO-8859-1"?>';
$data .= '<rss version="2.0">';
$data .= '<channel>';
$data .= '<title>CODELAB</title>';
$data .= '<link>'.BASE_URL.'/</link>';
$data .= '<description>Resource Blog For Coders</description>';
foreach ($posts as $post) {
    $data .= '<item>';
    $data .= '<title>'.htmlentities($post['title']).'</title>';
		$data .= '<link>'.BASE_URL.'/post/'.$post['slug'].'</link>';
		$data .= '<guid>'.BASE_URL.'/post/'.$post['slug'].'</guid>';
		$data .= '<pubDate>'.date(DATE_RSS, strtotime($post['date'])).'</pubDate>';
		$data .= '<description><![CDATA['.$post['subtitle'].'<a href="'.BASE_URL.'/post/'.$post['slug'].'">Read Full Post</a>]]></description>';
    $data .= '</item>';
}
$data .= '</channel>';
$data .= '</rss>';

header('Content-Type: application/xml');
echo $data;
?>