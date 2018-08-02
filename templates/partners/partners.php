<?php
/**
 * @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var \Zelfi\Model\ZFUser $AppUser
 *
 */

include __DIR__.'/../header-simple.php'; ?>

    <div class="page-content">
        <div class="container">

            <div class="row margin-top-40">
                <div class="col-xs-12">
                    <div class="zf-tabs-big">
                        <ul role="tablist">
                            <?php if ($partners_categories) foreach ($partners_categories as $index => $partners_category): ?>
                            <li role="presentation" <?=$index==0 ? 'class="active"': ''?>><a href="#tab<?=$index?>" aria-controls="tab<?=$index?>" role="tab" data-toggle="tab"><?=$partners_category['name']?></a></li>
                            <?php endforeach; ?>
                            <li class="action"><a data-toggle="modal" data-target="#modalFeedback" href="#">Стать партнером</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="partners-container">
                <div class="row margin-top-40">
                    <div class="col-xs-12">
                        <div class="tab-content">

                            <?php if ($partners_categories) foreach ($partners_categories as $index => $partners_category): ?>
                                <?php if ($partners_category['id']==1){ ?>
                                    <div role="tabpanel" class="tab-pane fade in <?=$index==0 ? 'active' : ''?>" id="tab<?=$index?>">
                                        <?php if ($partners_category['partners']) foreach ($partners_category['partners'] as $partner){ ?>
                                            <div class="col-xs-12">
                                                <div class="partners-item-wide">
                                                    <div class="row">
                                                        <div class="col-xs-3">
                                                            <a href="<?=$partner['url']?>">
                                                                <img class="partners-item-wide-cover" src="<?=$partner['cover']?>" />
                                                            </a>
                                                        </div>
                                                        <div class="col-xs-9">
                                                            <p class="partners-item-wide-description">
                                                                <?=$partner['description']?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                    </div>
                                <?php } else { ?>
                                    <div role="tabpanel" class="tab-pane fade in <?=$index==0 ? 'active' : ''?>" id="tab<?=$index?>">
                                        <?php if ($partners_category['partners']) foreach ($partners_category['partners'] as $partner){ ?>
                                            <div class="col-xs-3">
                                                <div class="partners-item">
                                                    <div class="square">
                                                        <div class="square-content">
                                                            <div class="content">
                                                                <div class="partners-item-description">
                                                                    <p>
                                                                        <?=$partner['description']?>
                                                                    </p>
                                                                    <a target="_blank" href="<?=$partner['url']?>">подробнее >></a>
                                                                </div>

                                                                <img class="partners-item-cover" src="<?=$partner['cover']?>" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                    </div>
                                <?php } ?>

                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

<?php include __DIR__.'/../footer.php' ?>