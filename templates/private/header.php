<?php
/**
 * @var \Zelfi\Model\ZFUser $AppUser
 * @var \Zelfi\Model\ZFUser $AppUser
 * @var \Zelfi\Model\ZFCities $AppCities
 * @var Zelfi\Utils\RendererHelper $AppRendererHelper
 *
 */

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Зеленый Фитнес | Панель управления</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <?php require_once 'header_styles.php' ?>
  <?php require_once 'header_scripts.php' ?>

</head>

<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

  <?php require_once 'header_top.php' ?>

  <?php require_once 'menu.php' ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$AppRendererHelper->getHeaderTitle() ? $AppRendererHelper->getHeaderTitle() : $AppRendererHelper->getCurrentMenuItem(\Zelfi\Menu\MenuConfiguration::MENU_PRIVATE_ID)['title']?>
        <?php
        if (!$AppRendererHelper->getHeaderSubtitle()):
        if ($AppRendererHelper->getCurrentSubMenuItem(\Zelfi\Menu\MenuConfiguration::MENU_PRIVATE_ID)):?>
          <small><?=$AppRendererHelper->getCurrentSubMenuItem(\Zelfi\Menu\MenuConfiguration::MENU_PRIVATE_ID)['title']?></small>
        <?php endif; ?>
        <?php else: ?>
          <small><?=$AppRendererHelper->getHeaderSubtitle()?></small>
        <?php endif; ?>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">