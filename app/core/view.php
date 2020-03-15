<?php

class View
{
	function generate($contentView, $templateView, $data = null)
	{
		if(!empty($data)){
			foreach($data as $key => $value){
				$$key = $value;
			}
		}
		$controller = str_replace('Controller', '', debug_backtrace()[1]['class']);
		$contentView = "{$_SERVER['DOCUMENT_ROOT']}/app/views/{$controller}/{$contentView}.php";
		include "{$_SERVER['DOCUMENT_ROOT']}/app/views/layouts/$templateView.php";
	}
}