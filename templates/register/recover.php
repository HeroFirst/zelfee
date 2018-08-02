<?php include __DIR__.'/../header-simple.php'; ?>

    <div class="page-content">
        <div class="container">
            <div class="row margin-top-40">
                <div class="col-xs-12">
                    <div class="box-title-page">
                        <h1>Восстановление аккаунта</h1>
                    </div>
                </div>
            </div>
            <div class="row margin-top-50 flex-container">
                <div class="col-xs-4">

                    <form id="form-recover" action="/recover" method="post" class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Ваш email" required>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row margin-top-50">
                <div class="col-xs-3">
                    <button type="submit" form="form-recover" class="button button-pink button-full-width">Восстановить</button>
                </div>
            </div>

        </div>
    </div>

<?php include __DIR__.'/../footer.php' ?>