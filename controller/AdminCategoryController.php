<?php

namespace plugins\content\controller;

use cmf\controller\PluginAdminBaseController;
use plugins\content\model\ContentCategoryModel;
use plugins\content\model\ContentModelModel;

class AdminCategoryController extends PluginAdminBaseController
{
    public function index()
    {
        /*获取栏目数据*/
        $datas = (new ContentCategoryModel())->getCategorys((new ContentCategoryModel())->order("SORT, ID")->where("category_id", 0)->select(), 0, 0);
        return $this->fetch("", [
            "datas" => $datas,
        ]);
    }

    public function add()
    {
        /*获取栏目编号*/
        $id = input("get.id");
        /*获取请求参数*/
        $submit = input("post.submit");
        $params = input("post.params/a");
        /*判断请求参数*/
        if (!empty($submit)) {
            /*添加栏目数据*/
            ContentCategoryModel::create($params, true);
            return true;
        } else {
            /*获取所有模型数据*/
            $models = (new ContentModelModel())->order("SORT, ID")->where("status", 1)->select();
            /*获取所有栏目数据*/
            $categorys = (new ContentCategoryModel())->getCategorysWithType((new ContentCategoryModel())->order("SORT, ID")->where("category_id", 0)->select(), 0, 1, 0);
            return $this->fetch("", [
                "models" => $models,
                "categorys" => $categorys,
                "id" => $id
            ]);
        }
    }

    public function edit()
    {
        /*获取栏目编号*/
        $id = input("get.id");
        /*获取请求参数*/
        $submit = input("post.submit");
        $params = input("post.params/a");
        /*判断请求参数*/
        if (!empty($submit)) {
            /*修改栏目数据*/
            ContentCategoryModel::update($params, [
                "id" => $id
            ], true);
            return true;
        } else {
            /*获取所有模型数据*/
            $models = (new ContentModelModel())->order("SORT, ID")->where("status", 1)->select();
            /*获取所有栏目数据*/
            $categorys = (new ContentCategoryModel())->getCategorysWithType((new ContentCategoryModel())->order("SORT, ID")->where([
                "category_id" => ["EQ", 0],
                "id" => ["NEQ", $id]
            ])->select(), 0, 1, $id);
            /*获取栏目数据*/
            $data = !empty($id) ? (new ContentCategoryModel())->where("id", $id)->find() : [];
            /*处理栏目数据*/
            $data["hasCategorys"] = (new ContentCategoryModel())->hasCategorys($id);
            return $this->fetch("", [
                "models" => $models,
                "categorys" => $categorys,
                "data" => $data
            ]);
        }
    }

    public function deleteAll()
    {
        /*获取栏目编号*/
        $ids = input("get.ids/a");
        /*判断栏目编号*/
        if (!empty($ids)) {
            /*遍历栏目编号*/
            foreach ($ids as $id) {
                /*删除栏目数据*/
                ContentCategoryModel::destroy($id);
                /*判断子栏目数据*/
                if ((new ContentCategoryModel())->hasCategorys($id)) {
                    ContentCategoryModel::executeDelete((new ContentCategoryModel())->where("category_id", $id)->select());
                }
            }
            return true;
        }
    }

    public function changeSort()
    {
        /*获取栏目编号*/
        $id = input("get.id");
        /*获取栏目排序*/
        $sort = input("get.sort");
        /*
         * 判断栏目编号
         * 判断栏目排序
         */
        if (!empty($id) && !empty($sort)) {
            /*修改栏目数据*/
            ContentCategoryModel::update([
                "sort" => $sort
            ], [
                "id" => $id
            ], true);
            return true;
        }
    }

    public function changeStatus()
    {
        /*获取栏目编号*/
        $id = input("get.id");
        /*获取栏目状态*/
        $status = input("get.status");
        /*
         * 判断栏目编号
         * 判断栏目状态
         */
        if (!empty($id) && !empty($status)) {
            /*修改栏目数据*/
            ContentCategoryModel::update([
                "status" => $status
            ], [
                "id" => $id
            ], true);
            /*判断子栏目数据*/
            if ((new ContentCategoryModel())->hasCategorys($id)) {
                ContentCategoryModel::executeStatus((new ContentCategoryModel())->where("category_id", $id)->select(), $status);
            }
            return true;
        }
    }

    public function destroy()
    {
        /*获取栏目编号*/
        $id = input("get.id");
        /*判断栏目编号*/
        if (!empty($id)) {
            /*删除栏目数据*/
            ContentCategoryModel::destroy($id);
            /*判断子栏目数据*/
            if ((new ContentCategoryModel())->hasCategorys($id)) {
                ContentCategoryModel::executeDelete((new ContentCategoryModel())->where("category_id", $id)->select());
            }
            return true;
        }
    }
}