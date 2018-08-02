<?php
/* @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var \Zelfi\Model\ZFUser $AppUser */
if ($AppRendererHelper != null){
  $FooterScripts = $AppRendererHelper->getFooterScripts();
  $FooterData = $AppRendererHelper->getFooterData();
}

?>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Main Footer -->
<footer class="main-footer">
  <!-- To the right -->
  <div class="pull-right hidden-xs">
    <strong><a href="//skraynov.ru">slavakraynov</a></strong>
  </div>
  <!-- Default to the left -->
  Copyright &copy; 2015-<?= date('Y') ?> Зеленый фитнес
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Create the tabs -->
  <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
    <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
    <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
  </ul>
  <!-- Tab panes -->
  <div class="tab-content">
    <!-- Home tab content -->
    <div class="tab-pane active" id="control-sidebar-home-tab">

      <h3 class="control-sidebar-heading">Tasks Progress</h3>
      <ul class="control-sidebar-menu">
        <li>
          <a href="javascript::;">
            <h4 class="control-sidebar-subheading">
              Custom Template Design
                <span class="pull-right-container">
                  <span class="label label-danger pull-right">70%</span>
                </span>
            </h4>

            <div class="progress progress-xxs">
              <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
            </div>
          </a>
        </li>
      </ul>
      <!-- /.control-sidebar-menu -->

    </div>
    <!-- /.tab-pane -->
    <!-- Stats tab content -->
    <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
    <!-- /.tab-pane -->
    <!-- Settings tab content -->
    <div class="tab-pane" id="control-sidebar-settings-tab">
      <form method="post">
        <h3 class="control-sidebar-heading">General Settings</h3>

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Report panel usage
            <input type="checkbox" class="pull-right" checked>
          </label>

          <p>
            Some information about this general settings option
          </p>
        </div>
        <!-- /.form-group -->
      </form>
    </div>
    <!-- /.tab-pane -->
  </div>
</aside>
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<script src="/assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="/assets/plugins/jQueryUI/jquery-ui.min.js"></script>
<script src="/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="/assets/adminlte/js/app.min.js"></script>
<script src="/assets/plugins/jsrender/jsrender.min.js"></script>
<script src='/assets/plugins/elfinder/js/elfinder.min.js'></script>
<script src='/assets/plugins/summernote/summernote.min.js'></script>
<script src="/assets/plugins/summernote/plugin/summernote-ext-elfinder/summernote-ext-elfinder.js"></script>
<script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="/assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="/assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="/assets/plugins/select2/select2.full.min.js"></script>
<script src="/assets/plugins/iCheck/icheck.min.js"></script>
<?php
if ($FooterScripts != null)
  foreach ($FooterScripts as $script):?>
    <script src="/assets/js/<?=$script?>.js"></script>
  <?php endforeach; ?>

<?php
if ($FooterData != null)
  foreach ($FooterData as $data):
    require_once __DIR__.'/data/'.$data.'.php';
  endforeach; ?>

</body>
</html>
