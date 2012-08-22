<?
class EMenu extends CWidget
{
	public $tag = 'ul';
	public $subtag = 'li';
	public $id = "";
	public $items = array();


	public function init()
	{
		if( empty($this->items) )
			return;
		
		$menuClass = 'accordion-menu';
		$content = '';
		$assets = $this->publishAssets();
		$css = $assets . '/css/accordionmenu.css';
		$js = $assets . '/js/accordionmenu.min.js';
		$cs = Yii::app()->clientScript;

		$cs->registerCSSFile( $css );
		$cs->registerScriptFile( $js );
		$cs->registerScript(
			'accordionMenu',
			"$('.".$menuClass."').accordionMenu();", 
			CClientScript::POS_READY
		);
		
		$route = array(
			'controller' => Yii::app()->controller->id,
			'action' => Yii::app()->controller->action->id
		);    	
	
		foreach ($this->items as $item) {
			$content .= $this->renderTag($item, 1, $route);
		}

		$htmlOptions = array(
			'id' => empty($this->id) ? null : $this->id,
			'class' => $menuClass
		);

		echo CHtml::tag($this->tag, $htmlOptions, $content);
	}

	private function renderTag($item, $level=1, $route = array())
	{
		$menu = '';
		$submenu = '';
		$toggle  = '';
		$nextlevel = $level + 1;

		if( isset($item['sub']) && is_array($item['sub']) ){
			foreach ($item['sub'] as $sub) {
				$submenu .= $this->renderTag($sub, $nextlevel, $route);
			}
			$toggle = CHtml::tag('span', array('class'=>'arrow'), '');
		}

		$content = CHtml::link($item['name'], $item['link']);			  
		$subclass = 'level'.$level;    
		$toggleclass = 'toggler';
			
		if( !empty($item['active']) ){
			$active = explode('/', $item['active']);
			if( ($level == 1) &&  ($route['controller'] == $active[0]) ){
				$subclass .= ' current active';
				$toggleclass .= ' active';
			}

			if( array_diff($route, $active) == array() )
				$subclass .= ' active';
		}

		if( $level == 1 ){
			$icon_class = isset($item['icon']) ? $item['icon'] : 'none';
			$icon_class = 'menu_icon ' . 'icon-' . $icon_class;
			$icon   = CHtml::tag('span', array('class'=> $icon_class), '');
			$toggleOptions = array(
				'class' => $toggleclass
			);
			$toggleContent = $icon . $toggle . $content;
			$content  = CHtml::tag('div', $toggleOptions, $toggleContent);
		}		

		if( !empty($submenu) ){
			$htmlOptions = array('class' => 'level'.$nextlevel);
			$submenu = CHtml::tag($this->tag, $htmlOptions, $submenu);	
			$content .= $submenu;
		}		

		$menu .= CHtml::tag($this->subtag, array('class'=>$subclass), $content);		
		return $menu;
	}

	private function publishAssets()
	{
		$package = array(
		   'basePath'=> 'ext.menu.assets',
		   'depends' => array('jquery')
		);
		$assets = Yii::app()->clientScript
							->addPackage('emenu', $package)
							->registerPackage('emenu')
							->getPackageBaseUrl('emenu');
		return $assets;
	}

}