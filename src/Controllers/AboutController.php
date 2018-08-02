<?php
/**
 * Created by PhpStorm.
 * Date: 28.11.2016
 * Time: 15:14
 */

namespace Zelfi\Controllers;


use MartynBiz\Slim3Controller\Controller;
use Zelfi\Enum\HelperAttributes;
use Zelfi\Utils\RendererHelper;

class AboutController extends Controller
{
    function get_history(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->addCurrentId(1)
            ->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        return $this->render('/about/history.php', $args);
    }

    function get_blog(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->addCurrentId(1)
            ->addBodyClasses([
                'page-about-blog'
            ])
            ->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        return $this->render('/about/blog.php', $args);
    }

    function get_smi(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->addCurrentId(1)
            ->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        return $this->render('/about/smi.php', $args);
    }
}