<?php

namespace plugins\content\model;

use think\Model;

class ContentCategoryModel extends Model
{
    /*判断子栏目数据*/
    public function hasCategorys($category_id)
    {
        return (new ContentCategoryModel())->where("category_id", $category_id)->count() == 0 ? false : true;
    }

    /*获取所有栏目数据*/
    public function getCategorys($categorys, $layer, $id)
    {
        $categorys->each(function ($data) use ($layer, $id) {
            /*处理栏目数据*/
            $data["prefix"] = str_repeat("| -- ", $layer);
            $data["hasCategorys"] = $this->hasCategorys($data["id"]);
            /*判断子栏目数据*/
            if ($data["hasCategorys"]) {
                /*处理子栏目数据*/
                $data["categorys"] = $this->getCategorys((new ContentCategoryModel())->order("SORT, ID")->where([
                    "category_id" => ["EQ", $data["id"]],
                    "id" => ["NEQ", $id]
                ])->select(), ++$layer, $id);
            }
            return $data;
        });
        return $categorys;
    }

    /*获取所有栏目数据（状态）*/
    public function getCategorysWithStatus($categorys, $layer, $status, $id)
    {
        $categorys->each(function ($data) use ($layer, $status, $id) {
            /*处理栏目数据*/
            $data["prefix"] = str_repeat("| -- ", $layer);
            $data["hasCategorys"] = $this->hasCategorys($data["id"]);
            /*判断子栏目数据*/
            if ($data["hasCategorys"]) {
                /*处理子栏目数据*/
                $data["categorys"] = $this->getCategorysWithStatus((new ContentCategoryModel())->order("SORT, ID")->where([
                    "category_id" => ["EQ", $data["id"]],
                    "status" => ["EQ", $status],
                    "id" => ["NEQ", $id]
                ])->select(), ++$layer, $status, $id);
            }
            return $data;
        });
        return $categorys;
    }

    /*获取所有栏目数据（类型）*/
    public function getCategorysWithType($categorys, $layer, $type, $id)
    {
        $categorys->each(function ($data) use ($layer, $type, $id) {
            /*处理栏目数据*/
            $data["prefix"] = str_repeat("| -- ", $layer);
            $data["hasCategorys"] = $this->hasCategorys($data["id"]);
            /*判断子栏目数据*/
            if ($data["hasCategorys"]) {
                /*处理子栏目数据*/
                $data["categorys"] = $this->getCategorysWithStatus((new ContentCategoryModel())->order("SORT, ID")->where([
                    "category_id" => ["EQ", $data["id"]],
                    "type" => ["EQ", $type],
                    "id" => ["NEQ", $id]
                ])->select(), ++$layer, $type, $id);
            }
            return $data;
        });
        return $categorys;
    }

    /*修改子栏目状态*/
    public static function executeStatus($categorys, $status)
    {
        $categorys->each(function ($data) use ($status) {
            /*处理栏目数据*/
            ContentCategoryModel::update([
                "status" => $status
            ], [
                "id" => $data["id"]
            ], true);
            /*判断子栏目数据*/
            if ((new ContentCategoryModel())->hasCategorys($data["id"])) {
                /*处理子栏目数据*/
                self::executeStatus((new ContentCategoryModel())->where("category_id", $data["id"])->select(), $status);
            }
        });
    }

    /*删除子栏目数据*/
    public static function executeDelete($categorys)
    {
        $categorys->each(function ($data) {
            /*处理栏目数据*/
            ContentCategoryModel::destroy($data["id"]);
            /*判断子栏目数据*/
            if ((new ContentCategoryModel())->hasCategorys($data["id"])) {
                /*处理子栏目数据*/
                self::executeDelete((new ContentCategoryModel())->where("category_id", $data["id"])->select());
            }
        });
    }

    public function getTypeTextAttr($value, $data)
    {
        $type = [
            "0" => "栏目",
            "1" => "列表",
            "2" => "链接",
        ];
        return $type[$data["type"]];
    }

    public function getModelIdAttr($value)
    {
        return (new ContentModelModel())->where([
            "id" => $value,
            "status" => 1
        ])->find();
    }
}