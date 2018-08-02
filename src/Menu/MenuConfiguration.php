<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 08.10.2016
 * Time: 11:32
 */

namespace Zelfi\Menu;

class MenuConfiguration
{
    const MENU_ID = 1;
    const MENU_PRIVATE_ID = 2;

    var $private_dir = "/private/";

    var $menuPrivate;

    var $menu;

    public function __construct()
    {
        $this->menuPrivate = array(
            [
                "isHeader" => true,
                "title" => "Общее",
                "isVisible" => true
            ],
            [
                "id" => 0,
                "title" => "Домашний экран",
                "link" => $this->private_dir,
                "icon" => "fa-home",
                "class" => "home",
                "isVisible" => true
            ],
            [
                "id" => 1,
                "title" => "События и площадки",
                "link" => "#",
                "icon" => "fa-calendar",
                "class" => "events",
                "isVisible" => true,
                "submenu" => [
                    [
                        "id" => 0,
                        "title" => "Добавить новое событие",
                        "link" => $this->private_dir."events/new",
                        "class" => "events-new",
                        "isVisible" => true
                    ],
                    [
                        "id" => 1,
                        "title" => "Все события",
                        "link" => $this->private_dir."events/all",
                        "class" => "events-all",
                        "isVisible" => true
                    ],
                    [
                        "id" => 2,
                        "title" => "Все площадки",
                        "link" => $this->private_dir."places/all",
                        "class" => "places-all",
                        "isVisible" => true
                    ]
                ]
            ],
            [
                "id" => 2,
                "title" => "Новости",
                "link" => "#",
                "icon" => "fa-newspaper-o",
                "class" => "news",
                "isVisible" => true,
                "submenu" => [
                    [
                        "id" => 0,
                        "title" => "Добавить новую",
                        "link" => $this->private_dir."news/new",
                        "class" => "news-new",
                        "isVisible" => true
                    ],
                    [
                        "id" => 1,
                        "title" => "Все новости",
                        "link" => $this->private_dir."news/all",
                        "class" => "news-all",
                        "isVisible" => true
                    ],
                    [
                        "id" => 2,
                        "title" => "Категории",
                        "link" => $this->private_dir."news/categories",
                        "class" => "news-categories-all",
                        "isVisible" => true
                    ]
                ]
            ],
            [
                "id" => 3,
                "title" => "Записи",
                "link" => "#",
                "icon" => "fa-info-circle",
                "class" => "paper",
                "isVisible" => true,
                "submenu" => [
                    [
                        "id" => 0,
                        "title" => "Добавить новую",
                        "link" => $this->private_dir."paper/new",
                        "class" => "paper-new",
                        "isVisible" => true
                    ],
                    [
                        "id" => 1,
                        "title" => "Все записи",
                        "link" => $this->private_dir."paper/all",
                        "class" => "paper-all",
                        "isVisible" => true
                    ],
                    [
                        "id" => 2,
                        "title" => "Категории",
                        "link" => $this->private_dir."news/categories",
                        "class" => "paper-categories-all",
                        "isVisible" => true
                    ]
                ]
            ],
            [
                "id" => 4,
                "title" => "Галереи",
                "link" => "#",
                "icon" => "fa-image",
                "class" => "gallery",
                "isVisible" => true,
                "submenu" => [
                    [
                        "id" => 0,
                        "title" => "Добавить новую",
                        "link" => $this->private_dir."galleries/new",
                        "class" => "gallery-new",
                        "isVisible" => true
                    ],
                    [
                        "id" => 1,
                        "title" => "Все галереи",
                        "link" => $this->private_dir."galleries/all",
                        "class" => "gallery-all",
                        "isVisible" => true
                    ]
                ]
            ],
            [
                "id" => 5,
                "title" => "Пользователи",
                "link" => "#",
                "icon" => "fa-user",
                "class" => "users",
                "isVisible" => true,
                "submenu" => [
                    [
                        "id" => 0,
                        "title" => "Добавить нового",
                        "link" => $this->private_dir."users/new",
                        "class" => "users-new",
                        "isVisible" => true
                    ],
                    [
                        "id" => 1,
                        "title" => "Все пользователи",
                        "link" => $this->private_dir."users/all",
                        "class" => "users-all",
                        "isVisible" => true
                    ],
                    [
                        "id" => 2,
                        "title" => "Команды",
                        "link" => $this->private_dir."users/teams",
                        "class" => "users-teams-all",
                        "isVisible" => true
                    ]
                ]
            ],
            [
                "id" => 9,
                "title" => "Партнеры",
                "link" => $this->private_dir."partners",
                "icon" => "fa-briefcase",
                "class" => "partners",
                "isVisible" => true,
                "submenu" => [
                    [
                        "id" => 0,
                        "title" => "Добавить нового",
                        "link" => $this->private_dir."partners/new",
                        "class" => "users-new",
                        "isVisible" => true
                    ],
                    [
                        "id" => 1,
                        "title" => "Все партнеры",
                        "link" => $this->private_dir."partners/all",
                        "class" => "users-all",
                        "isVisible" => true
                    ]
                ]
            ],
            [
                "id" => 10,
                "title" => "Магазин",
                "link" => $this->private_dir."store",
                "icon" => "fa-shopping-cart",
                "class" => "store",
                "isVisible" => true ,
                "submenu" => [
                    [
                        "id" => 0,
                        "title" => "Все товары",
                        "link" => $this->private_dir."store/all",
                        "class" => "store-all",
                        "isVisible" => true
                    ],
                    [
                        "id" => 1,
                        "title" => "Заказы",
                        "link" => $this->private_dir."store/orders/new",
                        "class" => "store-orders",
                        "isVisible" => true
                    ]
                ]
            ],
            [
                "id" => 6,
                "title" => "Балльная система",
                "link" => $this->private_dir."balls-system",
                "icon" => "fa-star",
                "class" => "balls-system",
                "isVisible" => true,
                "submenu" => [
                    [
                        "id" => 0,
                        "title" => "Все пользователи",
                        "link" => $this->private_dir."balls-system/users/all",
                        "class" => "balls-system-users-all",
                        "isVisible" => true
                    ],
                    [
                        "id" => 1,
                        "title" => "Бонусы за посещение",
                        "link" => $this->private_dir."balls-system/bonuses/attending-events",
                        "class" => "balls-system-attending-events",
                        "isVisible" => true
                    ],
                    [
                        "id" => 2,
                        "title" => "Бонусы за видео",
                        "link" => $this->private_dir."balls-system/bonuses/users-video/new",
                        "class" => "balls-system-users-video",
                        "isVisible" => true
                    ]
                ]
            ],
            [
                "isHeader" => true,
                "title" => "Управление сайтом",
                "isVisible" => true
            ],
            [
                "id" => 7,
                "title" => "Настройки",
                "link" => "#",
                "icon" => "fa-sliders",
                "class" => "settings",
                "isVisible" => true,
                "submenu" => [
                    [
                        "id" => 0,
                        "title" => "Общее",
                        "link" => $this->private_dir."settings/common",
                        "class" => "settings-common",
                        "isVisible" => true
                    ],
                    [
                        "id" => 1,
                        "min-role" => 1,
                        "title" => "Сервисное меню",
                        "link" => $this->private_dir."settings/service",
                        "class" => "settings-service",
                        "isVisible" => true
                    ]
                ]
            ],
            [
                "id" => 8,
                "min-role" => 1,
                "title" => "DEBUG",
                "link" => "#",
                "icon" => "fa-bug",
                "class" => "debug",
                "isVisible" => true
            ],
        );

        $this->menu = array(
            array(
                "id" => 0,
                "class" => "home",
                "isVisible" => false
            ),
            array(
                "id" => 1,
                "title" => "О нас",
                "link" => "/about",
                "class" => "about",
                "counter" => 0,
                "isVisible" => true
            ),
            array(
                "id" => 4,
                "title" => "Новости",
                "link" => "/news",
                "class" => "news",
                "counter" => 0,
                "isVisible" => true
            ),
            array(
                "id" => 2,
                "title" => "Афиша",
                "link" => "/events",
                "class" => "events",
                "counter" => 0,
                "isVisible" => true
            ),
            array(
                "id" => 3,
                "title" => "Стань лучше",
                "link" => "/paper",
                "class" => "article",
                "counter" => 0,
                "isVisible" => true
            ),
            array(
                "id" => 6,
                "title" => "Команда",
                "link" => "/team",
                "class" => "team",
                "counter" => 0,
                "isVisible" => false
            ),
            array(
                "id" => 5,
                "title" => "Партнеры",
                "link" => "/partners",
                "class" => "partners",
                "counter" => 0,
                "isVisible" => true
            ),
            array(
                "id" => 7,
                "title" => "Магазин",
                "link" => "/store",
                "class" => "store",
                "counter" => 0,
                "isVisible" => true
            ),
            array(
                "id" => 8,
                "title" => "Конкурсы",
                "link" => "/contest",
                "class" => "contest",
                "counter" => 0,
                "isVisible" => false
            ),
            array(
                "id" => 9,
                "title" => "Пользователь",
                "class" => "user",
                "isVisible" => false
            )
        );
    }


    public function getById($menuId, $id){
        $menu = null;

        switch ($menuId){
            case 1:
                $menu = $this->getMenu();
                break;
            case 2:
                $menu = $this->getMenuPrivate();
                break;
        }

        foreach ($menu as $index => $item){
            if ($item['id'] === $id){
                return $item;
            }
        }

        return null;
    }

    public function getMenu(){
        return $this->menu;
    }

    public function setMenu($menu)
    {
        $this->menu = $menu;
    }

    /**
     * @return array
     */
    public function getMenuPrivate()
    {
        return $this->menuPrivate;
    }

    /**
     * @param array $menuPrivate
     */
    public function setMenuPrivate($menuPrivate)
    {
        $this->menuPrivate = $menuPrivate;
    }

}