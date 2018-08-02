<?php
/**
 * @var \Zelfi\Model\ZFUser $AppUser
 * @var \Zelfi\Model\ZFCities $AppCities
 * @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var array $AppPrivateData
 *
 */

?>

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?=$AppUser->getInfoItem('photo_small')?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?=$AppUser->getInfoItem('first_name')?> <?=$AppUser->getInfoItem('last_name')?></p>
        <!-- Status -->
        <a href="#"><i class="fa fa-circle text-success"></i> В сети</a>
      </div>
    </div>

      <div class="city-select-panel">
          <select class="form-control" onchange="location = '?filter-city=' + this.value;">
              <option <?=$AppPrivateData['filter_city']==0 ? 'selected' : ''?> value="0">Все города</option>
              <?php if ($AppCities->getCities()) foreach ($AppCities->getCities() as $index => $city): ?>
                  <option <?=$AppPrivateData['filter_city']==$city['id'] ? 'selected' : ''?>  value="<?=$city['id']?>">
                      <?=$city['name']?>
                  </option>
              <?php endforeach; ?>
          </select>
      </div>

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">

      <?php

      foreach ($AppRendererHelper->getMenuPrivate() as $index => $item){
          if (is_null($item['min-role']) || $item['min-role']>=$AppUser->getRole()) {
              if (!$item['isHeader']) {
                  if ($item['submenu'] && count($item['submenu']) > 0) { ?>
                      <li class="treeview <?= ($item['id'] == $AppRendererHelper->getCurrentId()) ? 'active' : '' ?>">
                          <a href="#"><i class="fa <?= $item['icon'] ?>"></i> <span><?= $item['title'] ?></span>
                              <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                          </a>
                          <ul class="treeview-menu">
                              <?php foreach ($item['submenu'] as $index2 => $submenu_item) {
                                  if (is_null($submenu_item['min-role']) || $submenu_item['min-role'] >= $AppUser->getRole()): ?>
                                      <li class="<?= ($submenu_item['id'] == $AppRendererHelper->getSubMenuCurrentId()) ? 'active' : '' ?>">
                                          <a href="<?= $submenu_item['link'] ?>"><?= $submenu_item['title'] ?></a></li>
                                  <?php endif; ?>
                              <?php } ?>
                          </ul>
                      </li>
                      <?php
                  } else { ?>
                      <li><a href="<?= $item['link'] ?>"><i class="fa <?= $item['icon'] ?>"></i>
                              <span><?= $item['title'] ?></span>
                          </a></li>
                      <?php
                  }
              } else {
                  ?>
                  <li class="header"><?= $item['title'] ?></li>
                  <?php
              }
          }
      } ?>

        <li class="treeview">
            <a href="#"><i class="fa fa-users"></i> <span>Команды</span>
                              <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu" style="display: none;">
                <li class="">
                    <a href="/private/users/teams/create">Добавить команду</a></li>
                <li class="">
                    <a href="/private/users/teams/all">Все команды</a></li>

            </ul>
        </li>




    </ul>
    <!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>