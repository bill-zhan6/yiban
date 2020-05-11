<?php
namespace app\index\controller;
use app\common\model\Teacher;
use think\Controller;
/**
 * @Author: Marte
 * @Date:   2019-10-08 14:12:11
 * @Last Modified by:   Marte
 * @Last Modified time: 2019-10-08 16:14:46
 */

class TeacherController  extends Controller           //控制器
{

    public function news()         //触发器
    {     
      //  echo "teacher";
      $Teacher = new Teacher;      //建立模型对象
      $Teacher = $Teacher->order('id','desc')->Select();
      //$teachers = $Teacher->select();
      //foreach ($Teacher as $value => $K) {
        //$Teacher[$value]['title1']=substr($k['title1'],0,42);
      //}

      // var_dump($teachers);

      // 取回对应的视图文件
      $this->assign('a',$Teacher);
      $htmls = $this->fetch();
      // 将视图文件发送给用户
      return $htmls;
    }


    public function test()
    {
       // 取回对应的视图文件

      $htmls = $this->fetch('index');
      // 将视图文件发送给用户
      return $htmls;
    }


    public function insert()
    {
      //新建测试数据
      $teacher = array();
      $teacher['title1']="王五";
      $teacher['title2']="1";
      $teacher['title3']="22";
      //var_dump($teacher);
      //
      //
      $Teacher2 = new Teacher();
      $Teacher2->title1="赵四";
      $Teacher2->title2="1";
      $Teacher2->title3="33";
      $state2=$Teacher2->save();
      if($state2)
        return  '添加数据成功'. $Teacher2->Id;





      //$Teacher = new Teacher();
      //$state=$Teacher->data($teacher)->save();
      //var_dump($state);
    }




    public function app() {
      //return "app action.........";
      //获取视图数据
      $htmls = $this->fetch();
      //把视图数据发给用户
      return $htmls;
    }
}