<?php defined('BASEPATH') OR exit('No direct script access allowed');
include_once "Gitblog.php";
class Port extends Gitblog {
    function send(){
		//加载配置文件
		$this->load->library('Yaml');
		$configPath = str_replace("\\", "/", dirname(APPPATH)) . '/' . GB_CONF_FILE;
		$this->confObj = $this->yaml->getConfObject($configPath);
		$this->load->library('Twig', array("theme" => $this->confObj['theme']));
		
        //加载模板
		$this->setData("data", $_POST);
		$res = $this->render('md-template.html');
        //写文件
        try{
            $file = sprintf('%s/blog/%s.md', str_replace("\\", "/", dirname(APPPATH)), md5(trim($_POST['title'])));
            $hfile = fopen($file, "w");
            if(!$hfile) throw new Exception("file open error");
            fwrite($hfile, $res);
            fclose($hfile);
        }catch(Exception $e){
            return '<script>alert("error:'.$e->getMessage().'");</script>';
        }
    }
}
