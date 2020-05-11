<?php
namespace app\index\controller;
use app\common\model\Dagongsi;
use app\common\model\News;
use app\common\model\Login;
use app\common\model\Music;
use app\common\model\Dianying;
use think\Controller;
use think\Session;
/**
 * @Author: Marte
 * @Date:   2019-10-08 14:12:11
 * @Last Modified by:   Marte
 * @Last Modified time: 2019-10-08 16:14:46
 */

class NewsController  extends Controller           //控制器
{

    public function ht()         //触发器
    {     
           //建立模型对象
      //$News = $News->order('id','desc')->Select();
      
      if(!session('name'))
      $this->error ("用户名密码错误，请重新登录",url('login'));

      $pageSize = 4;
      $News = new News; 
      $News = $News->paginate($pageSize);
      $this->assign('a',$News);

      $htmls = $this->fetch();
      // 将视图文件发送给用户
      return $htmls;
    }

     public function add()         //触发器
    {     

      if(!session('name'))
      $this->error ("用户名密码错误，请重新登录",url('login'));

      $htmls = $this->fetch();
      // 将视图文件发送给用户
      return $htmls;
    }


    public function insert() 
    {
        $News = new News();
        $file = request()->file('image'); 
        // 移动到框架应用根目录/public/uploads/ 目录下 
        if($file){ 
          $info = $file->validate(['size'=>1000000,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');}
        $cover=$info->getSaveName();//将图片的地址定义为$cover存进数据库
        $News['photo']=$cover;
        $News['title1']=$_POST["bt"];
		$News['author']=$_POST["zz"];
        $News['content']=$_POST["nr"];
      
        $state2=$News->save();
        if ($state2)
            return $this->success("新闻添加成功", url('ht'));
        else
            return '新增失败:' . $News2->getError();
    }

     public function deletea()
    {
        
        $x= \think\Request::instance()->param('ida/d');

        $News=News::get($x);
        if(!is_null($News))

            if($News->delete())
                $this->success("删除成功", url('ht'));
        else
            return "删除失败";
    }

    public function update(){
        //接收表单数据，然后数据库更新！
        // 接受地址栏的id值
        $x=\think\Request::instance()->param('id/d');

        $News=News::get($x);
        //发送数据
        $this->assign('New', $News);
        $htmls = $this->fetch();

        //发送视图文件给用户
        return $htmls;

    }

    public function save() {
        //接收数据
        $News = new News();
         $file = request()->file('image'); 
        // 移动到框架应用根目录/public/uploads/ 目录下 
        if($file){ 
          $info = $file->validate(['size'=>1000000,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');}
        $cover=$info->getSaveName();//将图片的地址定义为$cover存进数据库
        $News['photo']=$cover;

        $new=\think\Request::instance()->post();
        //更新数据
        $state=$News->isUpdate(true)->save($new);

        if($state)
            return $this->success("更新成功",url('ht'));
        else
            return $this->error("修改失败").url('update');
      }
    
    public function search(){
      //接受查询表单提交的数据
      $x=$_GET["cx"];
      //echo $x;

      $News = new News;
      $news= $News->where('title1','like','%'.$x.'%')->paginate();

      $this->assign('a',$news);
      $htmls= $this->fetch();
      return $htmls;

    }

    public function login(){
      $Login= new Login;
      $htmls=$this->fetch('login');

      return $htmls;
    }

    public function Logincheck(){
      //接收登录页提交的密码
      $x=$_POST["name"];
      $y=$_POST["password"];

      $map=array('name'=>$x,'password'=>$y);

      $Login= new Login;
      
      $logins= $Login->where($map)->select();

      if($logins)
      {
        session('name',$x);
        $this->success("登录成功",url('ht'));
      }
        else
            $this->error ("用户名密码错误，请重新登录",url('login'));
      
    }


    public function Logout(){
      Session::delete('id');
      Session::delete('name');
      $this->success("注销成功",url('login'));


    }
    public function zc(){
      $Login= new Login;
      $htmls=$this->fetch('zc');

      return $htmls;
    }
    public function zccheck (){
        $Login= new Login;
       array('name','','帐号名称已经存在！',0,'unique',1);

        $Login->name = $_POST["name"];
        $Login->password = $_POST["pwd"];

        $state2=$Login->save();
        if ($state2)
            return $this->success("注册成功", url('login'));
        else
             return $this->error("注册失败", url('zc'));
  }


    public function index()         //触发器
    {     
     $News = new News;      //建立模型对象
      $News = $News->order('id','desc')->Select();
      $this->assign('a',$News);

       $Music = new Music;      //建立模型对象
      $Music = $Music->order('id','desc')->Select();
      $this->assign('b',$Music);

      $htmls = $this->fetch();
      // 将视图文件发送给用户
      return $htmls;
      
    }
    public function dy()         //触发器
    {     
      $Dianying = new Dianying;      //建立模型对象
      $Dianying = $Dianying->order('id','desc')->Select();
      $this->assign('a',$Dianying);

      $htmls = $this->fetch();
      // 将视图文件发送给用户
      return $htmls;
      
    }

}