<?php

namespace plugins\content\model;

use think\Model;

class ContentModelModel extends Model
{
    /*获取字段数据*/
    public static function getFields($model_id)
    {
        /*
         * 1-数值
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
                "name" => "状态",
                "field" => "status",
                "type" => 1,
                "default" => "1",
                "length" => 0,
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

    /*获取语句*/
    public static function getSql($operation, $param)
    {
        /*获取表前缀*/
        $prefix = config("database.prefix") . "content_model_";
        /*创建语句容器*/
        $sql = "";
        /*判断操作类型*/
        switch ($operation) {
            case "create":
                $sql .= "CREATE TABLE {$prefix}{$param['model_field']} (";
                $sql .= "id int(10) unsigned NOT NULL AUTO_INCREMENT,";
                /*遍历字段数据*/
                foreach ($param["fields"] as $field) {
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
                $sql .= "PRIMARY KEY (`id`)";
                $sql .= ") ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
                break;
            case "rename":
                $sql .= "RENAME TABLE {$prefix}{$param['model_field_origin']} TO {$prefix}{$param['model_field']}";
                break;
            case "drop":
                $sql .= "DROP TABLE IF EXISTS {$prefix}{$param['model_field']}";
                break;
        }
        return $sql;
    }
}