<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 01.11.2016
 * Time: 0:27
 */

namespace Zelfi\Utils;

use cli\table\Renderer;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Request;
use Zelfi\Enum\Strings;
use Zelfi\Menu\MenuConfiguration;

class RendererHelper
{
    var $headerScripts = array();
    var $bodyClasses = array();
    var $headerStyles = array();
    var $headerData = array();
    var $partMeta = array();

    var $footerScripts = array();
    var $footerData = array();
    var $modalMessage = null;

    var $menu;
    var $menuCurrentId = -1;
    var $subMenuCurrentId = -1;

    var $headerTitle = null;
    var $headerSubtitle = null;

    /**
     * @return null
     */
    public function getHeaderTitle()
    {
        return $this->headerTitle;
    }

    /**
     * @param null $headerTitle
     */
    public function setHeaderTitle($headerTitle = null, $headerSubtitle = null)
    {
        $this->headerTitle = $headerTitle;
        $this->headerSubtitle = $headerSubtitle;
    }

    /**
     * @return null
     */
    public function getHeaderSubtitle()
    {
        return $this->headerSubtitle;
    }



    /**
     * @return null
     */
    public function getModalMessage()
    {
        return $this->modalMessage;
    }

    /**
     * @param null $modalMessage
     */
    private function setModalMessage($modalMessage)
    {
        $this->modalMessage = $modalMessage;
    }

    /**
     * @return array
     */
    public function getBodyClasses()
    {
        return $this->bodyClasses;
    }

    /**
     * @param array $bodyClasses
     */
    private function setBodyClasses(array $bodyClasses)
    {
        $this->bodyClasses = $bodyClasses;
    }

    /**
     * @return int
     */
    public function getMenuCurrentId()
    {
        return $this->menuCurrentId;
    }

    /**
     * @param int $menuCurrentId
     */
    private function setMenuCurrentId($menuCurrentId)
    {
        $this->menuCurrentId = $menuCurrentId;
    }

    /**
     * @return int
     */
    public function getSubMenuCurrentId()
    {
        return $this->subMenuCurrentId;
    }

    /**
     * @param int $subMenuCurrentId
     */
    public function setSubMenuCurrentId(int $subMenuCurrentId)
    {
        $this->subMenuCurrentId = $subMenuCurrentId;
    }

    /**
     * @return mixed
     */
    public function getMenu()
    {
        return $this->menu->getMenu();
    }

    public function getMenuPrivate()
    {
        return $this->menu->getMenuPrivate();
    }

    /**
     * @return mixed
     */
    public function getCurrentId()
    {
        return $this->menuCurrentId;
    }

    /**
     * @param mixed $currentId
     */
    private function setCurrentId($currentId)
    {
        $this->menuCurrentId = $currentId;
    }

    /**
     * @return integer
     */
    public function getCurrentMenuItem(int $menuId){
        return $this->getMenuConfiguration()->getById($menuId, $this->getCurrentId());
    }

    /**
     * @return integer
     */
    public function getCurrentSubMenuItem(int $menuId){
        $curMenuItem = $this->getCurrentMenuItem($menuId);

        if ($curMenuItem['submenu'] != null && count($curMenuItem['submenu']) > 0){
            foreach ($curMenuItem['submenu'] as $index => $item){
                if ($item['id'] === $this->getSubMenuCurrentId()) return $item;
            }
        }

        return null;
    }

    /**
     * RendererHelper constructor.
     */
    public function __construct()
    {
        $this->menu = new MenuConfiguration();
    }

    /**
     * @return MenuConfiguration
     */
    private function getMenuConfiguration(){
        return $this->menu;
    }

    /**
     * @return array
     */
    public function getHeaderScripts()
    {
        return $this->headerScripts;
    }

    /**
     * @param array $headerScripts
     */
    private function setHeaderScripts(array $headerScripts)
    {
        $this->headerScripts = $headerScripts;
    }

    /**
     * @return array
     */
    public function getHeaderStyles()
    {
        return $this->headerStyles;
    }

    /**
     * @param array $headerStyles
     */
    private function setHeaderStyles(array $headerStyles)
    {
        $this->headerStyles = $headerStyles;
    }

    /**
     * @return array
     */
    public function getHeaderData()
    {
        return $this->headerData;
    }

    /**
     * @param array $headerData
     */
    private function setHeaderData(array $headerData)
    {
        $this->headerData = $headerData;
    }

    /**
     * @return array
     */
    public function getFooterScripts()
    {
        return $this->footerScripts;
    }

    /**
     * @param array $footerScripts
     */
    private function setFooterScripts(array $footerScripts)
    {
        $this->footerScripts = $footerScripts;
    }

    /**
     * @return array
     */
    public function getPartMeta(): array
    {
        return $this->partMeta;
    }

    /**
     * @param array $partMeta
     */
    private function setPartMeta(array $partMeta)
    {
        $this->partMeta = $partMeta;
    }


    /**
     * @return array
     */
    public function getFooterData()
    {
        return $this->footerData;
    }

    /**
     * @param array $footerData
     */
    private function setFooterData(array $footerData)
    {
        $this->footerData = $footerData;
    }

    /**
     * @return RendererHelper
     */
    public function addCurrentId($menuCurrentId ,$subMenuCurrentId = -1){
        $clone = clone($this);

        $clone->setMenuCurrentId($menuCurrentId);
        $clone->setSubMenuCurrentId($subMenuCurrentId);

        return $clone;
    }

    /**
     * @return RendererHelper
     */
    public function addHeaderData($data){
        $clone = clone($this);

        $clone->setHeaderData($data);

        return $clone;
    }

    /**
     * @return RendererHelper
     */
    public function addFooterData($data){
        $clone = clone($this);

        $clone->setFooterData($data);

        return $clone;
    }

    /**
     * @return RendererHelper
     */
    public function addHeaderScripts($scripts){
        $clone = clone($this);

        $clone->setHeaderScripts($scripts);

        return $clone;
    }

    /**
     * @return RendererHelper
     */
    public function addFooterScripts($scripts){
        $clone = clone($this);

        $clone->setFooterScripts($scripts);

        return $clone;
    }

    /**
     * @return RendererHelper
     */
    public function addPartMeta($meta){
        $clone = clone($this);

        $clone->setPartMeta($meta);

        return $clone;
    }

    /**
     * @return RendererHelper
     */
    public function addStyles($styles){
        $clone = clone($this);

        $clone->setHeaderStyles($styles);

        return $clone;
    }

    /**
     * @return RendererHelper
     */
    public function addBodyClasses($classes){
        $clone = clone($this);

        $clone->setBodyClasses($classes);

        return $clone;
    }

    /**
     * @return RendererHelper
     */
    public function addModalMessage($message){
        $clone = clone($this);

        $clone->setModalMessage($message);

        return $clone;
    }

    /**
     * @return RendererHelper
     */
    public function addHeaderTitle($title = null, $subtitle = null){
        $clone = clone($this);

        $clone->setHeaderTitle($title, $subtitle);

        return $clone;
    }

    /**
     * @return RendererHelper
     */
    public static function get(){
        $rendererHelper = new RendererHelper();

        return $rendererHelper;
    }

    /**
     * @return array
     */
    public function with(RequestInterface &$request, &$args = array()){
        $clone = clone($this);

        $modalMessage = $request->getQueryParam('modal-message');
        if ($modalMessage) {
            $clone->setModalMessage($modalMessage);
        }

        foreach ($request->getAttributes() as $key => $value) {
            $args[$key] = $value;
        }

        $args['AppRendererHelper'] = $clone;

        return $args;
    }

    /**
     * @return RendererHelper
     */
    public function build(RequestInterface &$request, &$args = array()){
        $clone = clone($this);

        foreach ($request->getAttributes() as $key => $value) {
            $args[$key] = $value;
        }

        return $clone;
    }
}