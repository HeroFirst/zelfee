<?php
/**
 * @var $news_item
 */

?>

<meta name="title" content="<?=$news_item['title']?>" />
<meta name="description" content="<?=$news_item['description_short']?>" />
<link rel="image_src" href="<?=$news_item['cover_social'] ? $news_item['cover_social'] : $news_item['cover'] ?>" />

<meta property="og:title" content="<?=$news_item['title']?>" />
<meta property="og:description"<?=$news_item['description_short']?>" />
<meta property="og:url" content="http://<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>" />
<meta property="og:image" content="<?=$news_item['cover_social'] ? $news_item['cover_social'] : $news_item['cover'] ?>" />