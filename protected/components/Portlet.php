<?php
Yii::import('zii.widgets.CPortlet');

class Portlet extends CPortlet
{
	public $arrowCssClass='portlet-arrow';
	public $imageCssClass='portlet-image';
	public $hidden=true;
	public $image;

	protected function renderDecoration()
	{
		if($this->title!==null)
		{
			echo "<div class=\"{$this->decorationCssClass}\">\n";
			echo "<div id=\"{$this->id}-image\" class=\"{$this->imageCssClass}\"></div>";
			echo "<h2 class=\"{$this->titleCssClass}\">{$this->title}</h2>\n";
			echo "<div class=\"{$this->arrowCssClass}\"></div>";
			echo "</div>\n";
		}
	}
	
	protected function renderContent()
	{
		Yii::app()->getClientScript()->registerScript('Portlet#'.$this->id, "
if($this->hidden){
$('#{$this->id} .{$this->contentCssClass}').hide();
}
$('#{$this->id} .{$this->decorationCssClass}').click(function(){
	$('#{$this->id} .{$this->contentCssClass}').toggle();
	return false;
});
");
	}
}

?>