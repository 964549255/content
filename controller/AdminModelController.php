<?php

namespace plugins\content\controller;

use cmf\controller\PluginAdminBaseController;
use plugins\content\model\ContentFieldModel;
use plugins\content\model\ContentModelModel;
use think\Db;

class AdminModelController extends PluginAdminBaseController
{
    public function index()
    {
        /*获取分页参数*/
        $query = input("get.");
        $page = input("get.page", 1);
        $rows = input("get.rows", 10);
        $path = cmf_plugin_url("Content://admin_model/index");
        /*获取模型数据*/
        $datas = (new ContentModelModel())->order("SORT, ID")->paginate([
            "page" => $page,
            "path" => $path,
            "query" => $query,
            "list_rows" => $rows,
            "type" => "bootstrap",
        ]);
        return $this->fetch("", [
            "datas" => $datas,
            "pages" => $datas->render(),
        ]);
    }

    public function add()
    {
        /*获取请求参数*/
        $submit = input("post.submit");
        $params = input("post.params/a");
        /*判断请求参数*/
        if (!empty($submit)) {
            /*获取模型键名*/
            $model_field = $params["field"];
            /*
             * 添加模型数据
             * 获取模型编号
             */
            $model_id = ContentModelModel::create($params, true)->id;
            /*获取字段数据*/
            $fields = ContentModelModel::getFields($model_id);
            /*遍历字段数据*/
            foreach ($fields as $field) {
                /*添加字段数据*/
                ContentFieldModel::create($field, true);
            }
            /*获取语句*/
            $sql = ContentModelModel::getSql("create", [
                "model_field" => $model_field,
                "fields" => $fields
            ]);
            /*执行语句*/
            Db::execute($sql);
            return true;
        } else {
            return $this->fetch();
        }
    }

    public function edit()
    {
        /*获取模型编号*/
        $id = input("get.id");
        /*获取请求参数*/
        $submit = input("post.submit");
        $params = input("post.params/a");
        /*判断请求参数*/
        if (!empty($submit)) {
            /*获取模型键名*/
            $model_field = $params["field"];
            /*获取模型原始键名*/
            $model_field_origin = (new ContentModelModel())->where("id", $id)->value("field");
            /*修改模型数据*/
            ContentModelModel::update($params, [
                "id" => $id
            ], true);
            /*判断模型键名变化*/
            if ($model_field != $model_field_origin) {
                /*获取语句*/
                $sql = ContentModelModel::getSql("rename", [
                    "model_field" => $model_field,
                    "model_field_origin" => $model_field_origin
                ]);
                /*执行语句*/
                Db::execute($sql);
            }
            return true;
        } else {
            /*获取模型数据*/
            $data = !empty($id) ? (new ContentModelModel())->where("id", $id)->find() : [];
            return $this->fetch("", [
                "data" => $data
            ]);
        }
    }

    public function deleteAll()
    {
        /*获取模型编号*/
        $ids = input("get.ids/a");
        /*判断模型编号*/
        if (!empty($ids)) {
            /*遍历模型编号*/
            foreach ($ids as $id) {
                /*获取模型键名*/
                $model_field = (new ContentModelModel())->where("id", $id)->value("field");
                /*删除模型数据*/
                ContentModelModel::destroy($id);
                /*删除字段数据*/
                ContentFieldModel::destroy([
                    "model_id" => $id
                ]);
                /*获取语句*/
                $sql = ContentModelModel::getSql("drop", [
                    "model_field" => $model_field
                ]);
                /*执行语句*/
                Db::execute($sql);
            }
            return true;
        }
    }

    public function changeSort()
    {
        /*获取模型编号*/
        $id = input("get.id");
        /*获取模型排序*/
        $sort = input("get.sort");
        /*
         * 判断模型编号
         * 判断模型排序
         */
        if (!empty($id) && !empty($sort)) {
            /*修改模型数据*/
            ContentModelModel::update([
                "sort" => $sort
            ], [
                "id" => $id
            ], true);
            return true;
        }
    }

    public function changeStatus()
    {
        /*获取模型编号*/
        $id = input("get.id");
        /*获取模型状态*/
        $status = input("get.status");
        /*
         * 判断模型编号
         * 判断模型状态
         */
        if (!empty($id) && !empty($status)) {
            /*修改模型数据*/
            ContentModelModel::update([
                "status" => $status
            ], [
                "id" => $id
            ], true);
            return true;
        }
    }

    public function destroy()
    {
        /*获取模型编号*/
        $id = input("get.id");
        /*判断模型编号*/
        if (!empty($id)) {
            /*获取模型键名*/
            $model_field = (new ContentModelModel())->where("id", $id)->value("field");
            /*删除模型数据*/
            ContentModelModel::destroy($id);
            /*删除字段数据*/
            ContentFieldModel::destroy([
                "model_id" => $id
            ]);
            /*获取语句*/
            $sql = ContentModelModel::getSql("drop", [
                "model_field" => $model_field
            ]);
            /*执行语句*/
            Db::execute($sql);
            return true;
        }
    }
}