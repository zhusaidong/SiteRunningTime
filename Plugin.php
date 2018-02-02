<?php
if(!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
* 在底部显示系统的运行时长
*
* @package SiteRunningTime
* @author 上官元恒
* @link https://blog.zhusaidong.cn
* @version 1.5.0
*/
class SiteRunningTime_Plugin implements Typecho_Plugin_Interface
{
	//这个是插件的激活接口，主要填写一些插件的初始化程序
	public static function activate()
	{
		Typecho_Plugin::factory('Widget_Archive')->footer_srt = ['SiteRunningTime_Plugin','show'];
		return '插件安装成功，请进入设置';
	}
	//这个是插件的禁用接口，主要就是插件在禁用时对一些资源的释放
	public static function deactivate()
	{
		return '插件卸载成功';
	}
	//插件的配置面板，用于制作插件的标准配置菜单
	public static function config(Typecho_Widget_Helper_Form $form)
	{
		$form->addInput(new Typecho_Widget_Helper_Form_Element_Text('srt_time', null, null, _t('系统开始运行时间'), '请输入该博客开始运行的时间,如(2008-08-08 08:08:08 )'));
		$form->addInput(new Typecho_Widget_Helper_Form_Element_Text('srt_text', null, '该站点运行了%y年%m月%d日%h时%i分%s秒', _t('输出格式'), '输出格式(%y:年,%m:月,%d:日,%h:时,%i:分,%s:秒)'));
		$form->addInput(new Typecho_Widget_Helper_Form_Element_Radio ('srt_autoRefresh', [1=>'自动',2=>'不自动'], _t(1) , _t('时间自动刷新'), null));
		$form->addInput(new Typecho_Widget_Helper_Form_Element_Textarea('srt_textStyle', null, '', _t('文本样式'), '输出文本的css代码'));
	}
	//插件的个性化配置面板
	public static function personalConfig(Typecho_Widget_Helper_Form $form){}
	
	//show
	public static function show($archive)
	{
		$option 	= Helper::options();
		$srt 		= $option->plugin('SiteRunningTime');
		$pluginUrl 	= $option->pluginUrl;
		//判断是否配置好
		if(is_null($srt->srt_time) or is_null($srt->srt_text))
		{
			return;
		}
		
		$startTime   = $srt->srt_time;
		$autoRefresh = $srt->srt_autoRefresh;
		$textStyle   = $srt->srt_textStyle;
		
		$text        = [
			'%y'=>'<label class="year">0</label>',
			'%m'=>'<label class="month">0</label>',
			'%d'=>'<label class="day">0</label>',
			'%h'=>'<label class="hour">0</label>',
			'%i'=>'<label class="minute">0</label>',
			'%s'=>'<label class="second">0</label>',
		];
		$startTimeText            = str_replace(array_keys($text),array_values($text),$srt->srt_text);
		
		//输出
		echo '<script src="'.$pluginUrl.'/SiteRunningTime/js/SiteRunningTime.js"></script>'."\n";
		echo
<<<eof
<style>
	$textStyle
</style>
<script>
	SiteRunningTime(
		{
			startTime:"$startTime",
			autoRefresh:"$autoRefresh",
			startTimeText:'$startTimeText',
		});
</script>
eof;
	}
}
