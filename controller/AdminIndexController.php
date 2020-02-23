<?php

namespace plugins\content\controller;

use cmf\controller\PluginAdminBaseController;

class AdminIndexController extends PluginAdminBaseController
{
    /**
     * @adminMenu(
     *     "name" => "栏目管理",
     *     "parent" => "menu",
     *     "display" => true,
     *     "hasView" => true,
     *     "order" => 1000,
     * )
     */
    public function index()
    {

    }

    /**
     * @adminMenu(
     *     "name" => "内容管理",
     *     "parent" => "admin/Plugin/default",
     *     "display" => true,
     *     "hasView" => true,
     *     "order" => 1000,
     * )
     */
    public function menu()
    {

    }
}