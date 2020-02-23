<?php

namespace plugins\content\controller;

use cmf\controller\PluginAdminBaseController;
use plugins\content\model\ContentFieldModel;
use plugins\content\model\ContentModelModel;
use think\Db;

class AdminModelController extends PluginAdminBaseController
{
    /*获取字段数据*/
    protected function getFields($model_id)
    {
        /*
         * 1-数值型
         * 2-短文本
         * 3-长文本
         * 4-富文本
         * 5-图片
         * 6-图片组
         * 7-视频
         * 8-视频组
         * 9-文件
         * 10-文件组
         */
        return [
            [
                "name" => "缩略图",
                "field" => "thumb",
                "type" => 5,
                "default" => "",
                "length" => 0,
                "vital" => 1,
                "model_id" => $model_id,
            ],
            [
                "name" => "标题",
                "field" => "title",
                "type" => 2,
                "default" => "",
                "length" => 255,
                "vital" => 1,
                "model_id" => $model_id,
            ],
            [
                "name" => "关键词",
                "field" => "keyword",
                "type" => 2,
                "default" => "",
                "length" => 255,
                "vital" => 1,
                "model_id" => $model_id,
            ],
            [
                "name" => "摘要",
                "field" => "summary",
                "type" => 3,
                "default" => "",
                "length" => 0,
                "vital" => 1,
                "model_id" => $model_id,
            ],
            [
                "name" => "内容",
                "field" => "content",
                "type" => 4,
                "default" => "",
                "length" => 0,
                "vital" => 1,
                "model_id" => $model_id,
            ],
            [
                "name" => "添加时间",
                "field" => "insert_time",
                "type" => 1,
                "default" => "",
                "length" => 0,
                "vital" => 1,
                "model_id" => $model_id,
            ],
            [
                "name" => "修改时间",
                "field" => "update_time",
                "type" => 1,
                "default" => "",
                "length" => 0,
                "vital" => 1,
                "model_id" => $model_id,
            ],
            [
                "name" => "作者",
                "field" => "author",
                "type" => 2,
                "default" => "",
                "length" => 255,
                "vital" => 1,
                "model_id" => $model_id,
            ],
            [
                "name" => "排序",
                "field" => "sort",
                "type" => 1,
                "default" => "1000",
                "length" => 0,
                "vital" => 1,
                "model_id" => $model_id,
            ],
            [
                "name" => "所属栏目",
                "field" => "category_id",
                "type" => 1,
                "default" => "",
                "length" => 0,
                "vital" => 1,
                "model_id" => $model_id,
            ],
        ];
    }

    /*获取创建表语句*/
    protected function getCreateSql($model_field, $fields)
    {
        /*获取表前缀*/
        $prefix = config("database.prefix") . "content_model_";
        /*获取语句*/
        $sql = "";
        $sql .= "CREATE TABLE {$prefix}{$model_field} (";
        $sql .= "id int(10) unsigned NOT NULL AUTO_INCREMENT,";
        /*遍历字段数据*/
        foreach ($fields as $field) {
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
            $sql .= "{$field['field']} {$field['type']} {$field['default']} {$field['comment']},";
        }
        $sql .= "PRIMARY KEY (id)";
        $sql .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8;";
        return $sql;
    }

    /*获取重名表语句*/
    protected function getRenameSql($model_field, $model_field_origin)
    {
        /*获取表前缀*/
        $prefix = config("database.prefix") . "content_model_";
        /*获取语句*/
        $sql = "RENAME TABLE {$prefix}{$model_field_origin} TO {$prefix}{$model_field}";
        return $sql;
    }

    /*获取删除表语句*/
    protected function getDropSql($model_field)
    {
        /*获取表前缀*/
        $prefix = config("database.prefix") . "content_model_";
        /*获取语句*/
        $sql = "DROP TABLE IF EXISTS {$prefix}{$model_field}";
        return $sql;
    }

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
            $fields = $this->getFields($model_id);
            /*遍历字段数据*/
            foreach ($fields as $field) {
                /*添加字段数据*/
                ContentFieldModel::create($field, true);
            }
            /*创建表*/
            Db::execute($this->getCreateSql($model_field, $fields));
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
                /*重名表*/
                Db::execute($this->getRenameSql($model_field, $model_field_origin));
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
                /*删除模型数据*/
                ContentModelModel::destroy($id);
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
            /*删除模型数据*/
            ContentModelModel::destroy($id);
            return true;
        }
    }
}