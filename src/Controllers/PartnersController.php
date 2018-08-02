<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 28.11.2016
 * Time: 15:14
 */

namespace Zelfi\Controllers;


use MartynBiz\Slim3Controller\Controller;
use Zelfi\DB\ZFMedoo;
use Zelfi\Enum\HelperAttributes;
use Zelfi\Model\ZFUser;
use Zelfi\Utils\RendererHelper;

class PartnersController extends Controller
{
    function get_partners(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->addCurrentId(5)
            ->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $partners_categories = ZFMedoo::get()->select('partners_types', '*');

        if ($partners_categories){
            foreach ($partners_categories as $index => $partners_category) {
                $partners_categories[$index]['partners'] = ZFMedoo::get()->select('partners', '*', [
                    'AND' => [
                        'type' => $partners_category['id'],
                        'city' => [0, $zfUser->getCity()]
                ]
                ]);
            }
        }

        $args['partners_categories'] = $partners_categories;

        return $this->render('/partners/partners.php', $args);
    }
}