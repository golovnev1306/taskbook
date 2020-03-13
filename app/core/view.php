<?php

class View
{
	//public $template_view; // здесь можно указать общий вид по умолчанию.
	
	function generate($contentView, $templateView, $data = null)
	{
		if(!empty($data)){
			foreach($data as $key => $value){
				$$key = $value;
			}
		}
		include "{$_SERVER['DOCUMENT_ROOT']}/app/views/layouts/".$templateView;
	}
}