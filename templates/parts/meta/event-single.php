<?php
/**
 * @var $event
 */

?>

<meta name="title" content="<?=$event['title']?>" />
<meta name="description" content="<?=$event['description_short']?>" />
<link rel="image_src" href="<?=$event['cover_social'] ? $event['cover_social'] : $event['cover'] ?>" />

<meta property="og:title" content="<?=$event['title']?>" />
<meta property="og:description"<?=$event['description_short']?>" />
<meta property="og:url" content="http://<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>" />
<meta property="og:image" content="<?=$event['cover_social'] ? $event['cover_social'] : $event['cover'] ?>" />