Accordion menu extension for Yii
------------
This is 2 level accordeon menu for Yii 1.1.x

Examples:
============
	http://belichuk.com/emenu/index.php

How to install:
============

Download project from github and uncompress to  protected/extensions foder.
This extension has been designed as a widget. Its easy to use. 
For examples:
	open your view for edit and define array $items. You can do this in the following way:

	$items = array(
		array(
			'name' => 'Google corp',
			'link' => 'http://google.com',
			'icon' => 'google',
			'active' => 'dashboard',
			'sub' => array(
				array(
					'name' => 'Gmail',
					'link' => 'http://gmail.com',
				),
				array(
					'name' => 'Gmap',
					'link' => 'http://maps.google.com/',
				)
	    	)
	    )
	);

Array key explanation:

* Key name - menu item
* Key link - ancor for menu item
* Key icon - css suffix for menu item icon
* Key active - if current used controller / action equals to key active value - than menu item will be expanded -have additional class 'current'
* Key sub - array with sub menu items


Then place next code:

	$this->widget('ext.menu.EMenu', array('items' => $items));

 Test your application. Take profit 