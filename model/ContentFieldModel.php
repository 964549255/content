<?php

namespace plugins\content\model;

use think\Model;

class ContentFieldModel extends Model
{
    /*获取语句*/
    public static function getSql($operation, $param, $field)
    {
        /*获取表前缀*/
        $prefix = config("database.prefix") . "content_model_";
        /*创建语句容器*/
        $sql = "";
        /*判断操作类型*/
        switch ($operation) {
            case "add":
            case "change":
            case "modify":
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
                /*判断操作类型*/
                switch ($operation) {
                    case "add":
                        $sql .= "ALTER TABLE {$prefix}{$param['model_field']} ADD {$field['field']} {$field['type']} {$field['default']} {$field['comment']}";
                        break;
                    case "change":
                        $sql .= "ALTER TABLE {$prefix}{$param['model_field']} CHANGE {$field['field_origin']} {$field['field']} {$field['type']} {$field['default']} {$field['comment']}";
                        break;
                    case "modify":
                        $sql .= "ALTER TABLE {$prefix}{$param['model_field']} MODIFY {$field['field']} {$field['type']} {$field['default']} {$field['comment']}";
                        break;
                }
                break;
            case "drop":
                $sql .= "ALTER TABLE {$prefix}{$param['model_field']} DROP {$field['field']}";
                break;
        }
        return $sql;
    }

    public function getTypeTextAttr($value, $data)
    {
        $type = [
            "1" => "数值",
            "2" => "短文本",
            "3" => "长文本",
            "4" => "富文本",
            "5" => "图片",
            "6" => "图片组",
            "7" => "视频",
            "8" => "视频组",
            "9" => "文件",
            "10" => "文件组",
        ];
        return $type[$data["type"]];
    }
}