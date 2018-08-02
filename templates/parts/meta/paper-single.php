<?php
/**
 * @var $paper
 */

?>

<meta name="title" content="<?=$paper['title']?>" />
<meta name="description" content="<?=$paper['description_short']?>" />
<link rel="image_src" href="<?=$paper['cover_social'] ? $paper['cover_social'] : $paper['cover'] ?>" />

<meta property="og:title" content="<?=$paper['title']?>" />
<meta property="og:description"<?=$paper['description_short']?>" />
<meta property="og:url" content="http://<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>" />
<meta property="og:image" content="<?=$paper['cover_social'] ? $paper['cover_social'] : $paper['cover'] ?>" />