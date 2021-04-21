<?php

namespace Admin\Controller;

use Common\Controller\AdminBaseController;
use Org\Util\Data;
use Think\Exception;

class CartoonTypeController extends AdminBaseController
{


    //漫画分类管理
    public function index()
    {
        if (IS_AJAX)
        {
            $where = " detime is null ";
            $data = I('get.');
            $keyword = $data['keyword'];
            unset($data['keyword']);
            unset($data['page']);
            unset($data['limit']);

            if (isset($keyword[0])) {
                $where .= " and `name` like '%{$keyword}%' ";
            }

            //如果传递了父级id 且不为 '' 添加条件
            if (isset($data['pid']) && $data['pid'] !== '') {
                $ids = implode($this->get_children_str($data['pid']), ',');
                $where .= " and id in ({$ids}) ";
            }
            unset($data['pid']);//防止条件组装上pid
            foreach ($data as $k => $v) {
                if (isset($v[0])) {
                    $where .= " and `{$k}`={$v} ";
                }
            }

            $count = M('cartoon_type')->where($where)->count();
            $list = M('cartoon_type')
            ->field('id,pid,name,sign,type_mername,addtime')
            ->where($where)
            ->order('sort,id desc')
            ->select();

            $ids = array_column($list, 'id');
            //treetable需要id为0的父级
            foreach ($list as &$v) {
                if (!in_array($v['pid'], $ids)) {
                    $v['pid'] = 0;
                }
            }
            $res = array(
                'code' => 0
                , 'count' => $count
                , 'msg' => ''
                , 'data' => $list
                , 'where'=>$where

            );
            $this->ajaxReturn($res);
            
        }elseif(IS_GET)
        {
            $this->display('cartoonType/index');
        }
    }

    //漫画添加
    public function add()
    {
        if (IS_AJAX) {
            try {
                parse_str($_POST['para'], $data);
                $pid = (int)$data['pid'];
                $data = I('data.', '', C('DEFAULT_FILTER'), $data);
                $data = array_filter($data);

                $data['type_merid'] = '0';//组合编号
                $data['type_mername'] = strtolower($data['name']);//组合名称
                if(!empty($pid))
                {
                    $info = M('cartoon_type')
                    ->field('type_merid,type_mername')
                    ->where("id={$pid} and detime is null")
                    ->select()[0];
                    if(empty($info))
                    {
                        $this->error('未找到分类内容');
                    }
                    $data['type_merid'] = $info['type_merid'];//组合编号
                    $data['type_mername'] = $info['type_mername'].'|'.strtolower($data['name']);//组合名称
                }

                $param = array();
                $param['pid'] = $pid;
                $param['name'] = strtolower($data['name']);
                $param['sign'] = $data['sign'] ? $data['sign'] : 0;
                $param['sort'] = (int)$data['sort'];
                $param['addtime'] = date('Y-m-d H:i:s');
                $param['type_merid'] = $data['type_merid'];
                $param['type_mername'] = $data['type_mername'];
                $row = M('cartoon_type')->add($param);
                if($row)
                {
                    $param = array();
                    $param['type_merid'] = $data['type_merid'].'|'.$row;
                    M('cartoon_type')->where("id={$row}")->save($param);

                    $this->success('添加成功');
                }else
                {
                    $this->error(M('cartoon_type')->getError());
                }
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
        }elseif(IS_GET)
        {
            $list = M('cartoon_type')
            ->field('id,pid,name,sign,type_mername,addtime')
            ->where('detime is null')
            ->select();
            $pid = 0;
            if (!empty(I('get.id'))) {
                $pid = I('get.id');
            }
            $this->assign('pid', $pid);

            $list = Data::tree($list, 'name', 'id', 'pid');
            $list = array_values($list);
            $this->assign('list', $list);
            $this->display('cartoonType/add');
        }
    }

    //漫画编辑
    public function edit()
    {
        if (IS_GET && !IS_AJAX) {
            $list = M('cartoon_type')
            ->field('id,pid,name,sign,type_mername,addtime')
            ->where('detime is null')
            ->select();
            $list = Data::tree($list, 'name', 'id', 'pid');
            $list = array_values($list);
            $this->assign('list', $list);

            $id = I('get.id');
            $info = M('cartoon_type')->find($id);
            $this->assign('info', $info);
            $this->display('cartoonType/edit');
        } elseif (IS_AJAX) {
            $data = array();
            parse_str($_POST['para'], $data);
            $pid = (int)$data['pid'];
            $data = I('data.', '', C('DEFAULT_FILTER'), $data);
            $data['pid'] = $pid;

            $data['type_merid'] = '0|'.$data['id'];//组合编号
            $data['type_mername'] = strtolower($data['name']);//组合名称
            if(!empty($pid))
            {
                $info = M('cartoon_type')
                ->field('type_merid,type_mername')
                ->where("id={$pid} and detime is null")
                ->select()[0];
                if(empty($info))
                {
                    $this->error('未找到分类内容');
                }
                $data['type_merid'] = $info['type_merid'].'|'.$data['id'];//组合编号
                $data['type_mername'] = $info['type_mername'].'|'.strtolower($data['name']);//组合名称
            }
            $param = array();
            $param['id'] = $data['id'];
            $param['pid'] = $pid;
            $param['name'] = strtolower($data['name']);
            $param['sign'] = $data['sign'] ? $data['sign'] : 0;
            $param['sort'] = (int)$data['sort'];
            $param['type_merid'] = $data['type_merid'];
            $param['type_mername'] = $data['type_mername'];

            $row = M('cartoon_type')->save($data);
            $row === false ? $this->error('网络故障') : $row === 0 ? $this->error('数据无改动', 'nojump', IS_AJAX, 2) : $this->success('操作成功');

        }
    }

    //更改状态
    public function change()
    {
        $data = [];
        $data['id'] = I('param.id');
        $data[I('param.name')] = I('param.val') === 'true' ? 1 : 0;
        M('cartoon_type')->save($data) ? $this->success() : $this->error('网络故障');
    }


    //删除
    public function del()
    {
        if (IS_AJAX) {
            $id = I('post.id');
            if (is_array($id)) {
                $id = implode($id, ',');
            }
            $child = M('cartoon_type')->where(" `pid` in ({$id})")->count();
            if ($child > 0) {
                $this->error('存在子权限，请删除子权限', '', true, 3);
            }
            $data = array();
            $data['detime'] = date('Y-m-d H:i:s');
            $rows = M('cartoon_type')->where(" `id` in ({$id})")->save($data);
            $rows !== false ? $this->success('删除成功') : $this->error('网络故障');
        }
    }


    /**
     * @param string $pid 父级id
     * @return array 该级别下所有孩子包括下下级
     */
    private function get_children_str($pid)
    {
        $ids = array($pid);
        $list = M("cartoon_type")->field("id")->where("pid={$pid} and detime is null")->select();
        foreach ($list as $key => $val) {
            $ids = array_merge($ids, $this->get_children_str($val["id"]));
        }
        return $ids;
    }

}
?>