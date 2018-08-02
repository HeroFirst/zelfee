<?php include 'header-simple.php'; ?>

        <div class="page-content">
            <div class="container">

                <div class="row margin-top-30">
                    <div class="col-xs-12">
                        <div class="zf-tabs">
                            <ul>
                                <ul>
                                    <?php if ($types) foreach ($types as $index => $type): ?>
                                        <li <?=($type_active == $type['id']) ? 'class="active"' : ''?>><a href="?type=<?=$type['id']?>"><?=$type['name']?></a></li>
                                    <?php endforeach; ?>
                                    <li <?=(!$type_active) ? 'class="active"' : ''?>><a href="?all">Все</a></li>
                                </ul>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row margin-top-20">
                    <div class="news-items">

                        <?php
                        if ($hot_news):
                            $item = $hot_news;
                            require 'news/item-news-big.php';
                        endif;

                        if ($news):
                            foreach ($news as $index => $item):
                                require 'news/item-news-3.php';
                            endforeach;
                        endif; ?>

                    </div>
                </div>

                <div class="row margin-top-60 hide">
                    <div class="col-xs-12 text-center">
                        <a href="#" class="button button-pink button-fixed-width">Еще новости</a>
                    </div>
                </div>

            </div>
        </div>

<?php include 'footer.php' ?>