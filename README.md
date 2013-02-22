## Instalation

	1. Copy the files to your fuel/app/ folder.
	2. Add the breadrumb to your autoloader on fuel/app/bootstrap.php
		Autoloader::add_classes(array(
			'Menu' => APPPATH.'classes/menu.php',
		));

## Routing

The li of the link gets a active class when the link is equal to Uri::string() or when the link have 'part' => true it checks if the link match the beginning of the url (so the parent can get active too), as example below:

## Example using Bootstrap

	// Top Menu
	$top_menu = array(
		'attr'  => array('class' => 'nav'),
		'items' => array(
			array(
				'name' => 'Item 1 <b class="caret"></b>',
				'link' => array(
					'url'  => 'item1',
					'attr' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
					'part' => true
				),
				'attr' => array('class' => 'dropdown'),
				'menu' => array(
					'attr'  => array('class' => 'dropdown-menu'),
					'items' => array(
						array(
							'name' => 'Sub Item 1',
							'link' => 'item1/sub1'
						),
						array(
							'name' => 'Sub Item 2',
							'link' => 'item1/sub2'
						),
					),
				)
			),
			array(
				'name' => 'Item 2 <b class="caret"></b>',
				'link' => array(
					'url'  => 'item2',
					'attr' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
					'part' => true
				),
				'attr' => array('class' => 'dropdown'),
				'menu' => array(
					'attr'  => array('class' => 'dropdown-menu'),
					'items' => array(
						array(
							'name' => 'Sub Item 1',
							'link' => 'item2/sub1'
						),
						array(
							'name' => 'Sub Item 2',
							'link' => 'item2/sub2'
						),
					),
				)
			),
		),
	);

	Menu::forge('top_menu', $top_menu);

## View

	<?php echo Menu::instance('top_menu')->get(); ?>

## License

This is released under the MIT License.

## Documentation

Docs coming soon...

Feel free to contribute sending issues and pull request! :D
