<?php

namespace plugins\content\controller;

use cmf\controller\PluginAdminBaseController;
use plugins\content\model\ContentFieldModel;
use plugins\content\model\ContentModelModel;
use think\Db;

class AdminFieldController extends PluginAdminBaseController
{
    /*获取添加字段语句*/
    protected function getAddSql($model_field, $field)
    {
        /*获取表前缀*/
        $prefix = config("database.prefix") . "content_model_";
        /*处理字段默认*/
        if (!empty($field["default"])) {
            $field["default"] = "DEFAULT '{$field['default']}'";
        }
        /*处理字段类型*/
        switch ($field["type"]) {
            case 1:
                $field["type"] = "int";
                break;
            case 2:
                $field["type"] = "varchar({$field['length']})";
                break;
            case 3:
                $field["type"] = "text";
                $field["default"] = "";
                break;
            case 4:
                $field["type"] = "text";
                $field["default"] = "";
                break;
            case 5:
                $field["type"] = "text";
                $field["default"] = "";
                break;
            case 6:
                $field["type"] = "text";
                $field["default"] = "";
                break;
            case 7:
                $field["type"] = "text";
                $field["default"] = "";
                break;
            case 8:
                $field["type"] = "text";
                $field["default"] = "";
                break;
            case 9:
                $field["type"] = "text";
                $field["default"] = "";
                break;
            case 10:
                $field["type"] = "text";
                $field["default"] = "";
                break;
        }
        /*处理字段注释*/
        $field["comment"] = "COMMENT '{$field['name']}'";
        /*获取语句*/
        $sql = "ALTER TABLE {$prefix}{$model_field} ADD {$field['field']} {$field['type']} {$field['default']} {$field['comment']}";
        return $sql;
    }

    /*获取修改字段语句（重名字段）*/
    protected function getChangeSql($model_field, $field)
    {
        /*获取表前缀*/
        $prefix = config("database.prefix") . "content_model_";
        /*处理字段默认*/
        if (!empty($field["default"])) {
            $field["default"] = "DEFAULT '{$field['default']}'";
        }
        /*处理字段类型*/
        switch ($field["type"]) {
            case 1:
                $field["type"] = "int";
                break;
            case 2:
                $field["type"] = "varchar({$field['length']})";
                break;
            case 3:
                $field["type"] = "text";
                $field["default"] = "";
                break;
            case 4:
                $field["type"] = "text";
                $field["default"] = "";
                break;
            case 5:
                $field["type"] = "text";
                $field["default"] = "";
                break;
            case 6:
                $field["type"] = "text";
                $field["default"] = "";
                break;
            case 7:
                $field["type"] = "text";
                $field["default"] = "";
                break;
            case 8:
                $field["type"] = "text";
                $field["default"] = "";
                break;
            case 9:
                $field["type"] = "text";
                $field["default"] = "";
                break;
            case 10:
                $field["type"] = "text";
                $field["default"] = "";
                break;
        }
        /*处理字段注释*/
        $field["comment"] = "COMMENT '{$field['name']}'";
        /*获取语句*/
        $sql = "ALTER TABLE {$prefix}{$model_field} CHANGE {$field['field_origin']} {$field['field']} {$field['type']} {$field['default']} {$field['comment']}";
        return $sql;
    }

    /*获取修改字段语句（不重名字段）*/
    protected function getModifySql($model_field, $field)
    {
        /*获取表前缀*/
        $prefix = config("database.prefix") . "content_model_";
        /*处理字段默认*/
        if (!empty($field["default"])) {
            $field["default"] = "DEFAULT '{$field['default']}'";
        }
        /*处理字段类型*/
        switch ($field["type"]) {
            case 1:
                $field["type"] = "int";
                break;
            case 2:
                $field["type"] = "varchar({$field['length']})";
                break;
            case 3:
                $field["type"] = "text";
                $field["default"] = "";
                break;
            case 4:
                $field["type"] = "text";
                $field["default"] = "";
                break;
            case 5:
                $field["type"] = "text";
                $field["default"] = "";
                break;
            case 6:
                $field["type"] = "text";
                $field["default"] = "";
                break;
            case 7:
                $field["type"] = "text";
                $field["default"] = "";
                break;
            case 8:
                $field["type"] = "text";
                $field["default"] = "";
                break;
            case 9:
                $field["type"] = "text";
                $field["default"] = "";
                break;
            case 10:
                $field["type"] = "text";
                $field["default"] = "";
                break;
        }
        /*处理字段注释*/
        $field["comment"] = "COMMENT '{$field['name']}'";
        /*获取语句*/
        $sql = "ALTER TABLE {$prefix}{$model_field} MODIFY {$field['field']} {$field['type']} {$field['default']} {$field['comment']}";
        return $sql;
    }

    /*获取删除字段语句*/
    protected function getDropSql($model_field, $field_field)
    {
        /*获取表前缀*/
        $prefix = config("database.prefix") . "content_model_";
        /*获取语句*/
        $sql = "ALTER TABLE {$prefix}{$model_field} DROP {$field_field}";
        return $sql;
    }

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
            /*获取字段键名*/
            $model_field = (new ContentModelModel())->where("id", $params["model_id"])->value("field");
            /*添加字段数据*/
            ContentFieldModel::create($params, true);
            /*添加字段*/
            Db::execute($this->getAddSql($model_field, $params));
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
                /*修改字段（重名字段）*/
                $params["field_origin"] = $field_field_origin;
                Db::execute($this->getChangeSql($model_field, $params));
            } else {
                /*修改字段（不重名字段）*/
                Db::execute($this->getModifySql($model_field, $params));
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
                ContentModelModel::destroy($id);
                /*删除表*/
                Db::execute($this->getDropSql($model_field, $field_field));
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
            ContentModelModel::destroy($id);
            /*删除表*/
            Db::execute($this->getDropSql($model_field, $field_field));
            return true;
        }
    }
}