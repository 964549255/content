<?php

namespace plugins\content\controller;

use cmf\controller\PluginAdminBaseController;
use plugins\content\model\ContentFieldModel;
use plugins\content\model\ContentModelModel;
use think\Db;

class AdminFieldController extends PluginAdminBaseController
{
    public function index()
    {
        /*获取模型编号*/
        $model_id = input("get.model_id");
        /*获取分页参数*/
        $query = input("get.");
        $page = input("get.page", 1);
        $rows = input("get.rows", 10);
        $path = cmf_plugin_url("Content://admin_field/index");
        /*获取字段数据*/
        $datas = (new ContentFieldModel())->order("SORT, ID")->where("model_id", $model_id)->paginate([
            "page" => $page,
            "path" => $path,
            "query" => $query,
            "list_rows" => $rows,
            "type" => "bootstrap",
        ]);
        return $this->fetch("", [
            "datas" => $datas,
            "pages" => $datas->render(),
            "model_id" => $model_id,
        ]);
    }

    public function add()
    {
        /*获取请求参数*/
        $submit = input("post.submit");
        $params = input("post.params/a");
        /*判断请求参数*/
        if (!empty($submit)) {
            /*处理字段数据*/
            if (empty($params["length"])) {
                $params["length"] = 0;
            }
            /*获取模型键名*/
            $model_field = (new ContentModelModel())->where("id", $params["model_id"])->value("field");
            /*添加字段数据*/
            ContentFieldModel::create($params, true);
            /*获取语句*/
            $sql = ContentFieldModel::getSql("add", [
                "model_field" => $model_field
            ], $params);
            /*执行语句*/
            Db::execute($sql);
            return true;
        } else {
            return $this->fetch();
        }
    }

    public function edit()
    {
        /*获取字段编号*/
        $id = input("get.id");
        /*获取请求参数*/
        $submit = input("post.submit");
        $params = input("post.params/a");
        /*判断请求参数*/
        if (!empty($submit)) {
            /*处理字段数据*/
            if (empty($params["length"])) {
                $params["length"] = 0;
            }
            /*获取模型键名*/
            $model_field = (new ContentModelModel())->where("id", $params["model_id"])->value("field");
            /*获取字段键名*/
            $field_field = $params["field"];
            /*获取字段原始键名*/
            $field_field_origin = (new ContentFieldModel())->where("id", $id)->value("field");
            /*修改字段数据*/
            ContentFieldModel::update($params, [
                "id" => $id
            ], true);
            /*判断字段键名变化*/
            if ($field_field != $field_field_origin) {
                /*处理数据*/
                $params["field_origin"] = $field_field_origin;
                /*获取语句*/
                $sql = ContentFieldModel::getSql("change", [
                    "model_field" => $model_field
                ], $params);
                /*执行语句*/
                Db::execute($sql);
            } else {
                /*获取语句*/
                $sql = ContentFieldModel::getSql("modify", [
                    "model_field" => $model_field
                ], $params);
                /*执行语句*/
                Db::execute($sql);
            }
            return true;
        } else {
            /*获取字段数据*/
            $data = !empty($id) ? (new ContentFieldModel())->where("id", $id)->find() : [];
            return $this->fetch("", [
                "data" => $data
            ]);
        }
    }

    public function deleteAll()
    {
        /*获取字段编号*/
        $ids = input("get.ids/a");
        /*判断字段编号*/
        if (!empty($ids)) {
            /*遍历字段编号*/
            foreach ($ids as $id) {
                /*获取模型编号*/
                $model_id = (new ContentFieldModel())->where("id", $id)->value("model_id");
                /*获取模型键名*/
                $model_field = (new ContentModelModel())->where("id", $model_id)->value("field");
                /*获取字段键名*/
                $field_field = (new ContentFieldModel())->where("id", $id)->value("field");
                /*删除字段数据*/
                ContentFieldModel::destroy($id);
                /*获取语句*/
                $sql = ContentFieldModel::getSql("drop", [
                    "model_field" => $model_field
                ], [
                    "field" => $field_field
                ]);
                /*执行语句*/
                Db::execute($sql);
            }
            return true;
        }
    }

    public function changeSort()
    {
        /*获取字段编号*/
        $id = input("get.id");
        /*获取字段排序*/
        $sort = input("get.sort");
        /*
         * 判断字段编号
         * 判断字段排序
         */
        if (!empty($id) && !empty($sort)) {
            /*修改字段数据*/
            ContentFieldModel::update([
                "sort" => $sort
            ], [
                "id" => $id
            ], true);
            return true;
        }
    }

    public function changeStatus()
    {
        /*获取字段编号*/
        $id = input("get.id");
        /*获取字段状态*/
        $status = input("get.status");
        /*
         * 判断字段编号
         * 判断字段状态
         */
        if (!empty($id) && !empty($status)) {
            /*修改字段数据*/
            ContentFieldModel::update([
                "status" => $status
            ], [
                "id" => $id
            ], true);
            return true;
        }
    }

    public function destroy()
    {
        /*获取字段编号*/
        $id = input("get.id");
        /*判断字段编号*/
        if (!empty($id)) {
            /*获取模型编号*/
            $model_id = (new ContentFieldModel())->where("id", $id)->value("model_id");
            /*获取模型键名*/
            $model_field = (new ContentModelModel())->where("id", $model_id)->value("field");
            /*获取字段键名*/
            $field_field = (new ContentFieldModel())->where("id", $id)->value("field");
            /*删除字段数据*/
            ContentFieldModel::destroy($id);
            /*获取语句*/
            $sql = ContentFieldModel::getSql("drop", [
                "model_field" => $model_field
            ], [
                "field" => $field_field
            ]);
            /*执行语句*/
            Db::execute($sql);
            return true;
        }
    }
}