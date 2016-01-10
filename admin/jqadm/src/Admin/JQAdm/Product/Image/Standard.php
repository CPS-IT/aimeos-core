<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 * @package Admin
 * @subpackage JQAdm
 */


namespace Aimeos\Admin\JQAdm\Product\Image;


/**
 * Default implementation of product image JQAdm client.
 *
 * @package Admin
 * @subpackage JQAdm
 */
class Standard
	extends \Aimeos\Admin\JQAdm\Common\Admin\Factory\Base
	implements \Aimeos\Admin\JQAdm\Common\Admin\Factory\Iface
{
	/** admin/jqadm/product/image/standard/subparts
	 * List of JQAdm sub-clients rendered within the product image section
	 *
	 * The output of the frontend is composed of the code generated by the JQAdm
	 * clients. Each JQAdm client can consist of serveral (or none) sub-clients
	 * that are responsible for rendering certain sub-parts of the output. The
	 * sub-clients can contain JQAdm clients themselves and therefore a
	 * hierarchical tree of JQAdm clients is composed. Each JQAdm client creates
	 * the output that is placed inside the container of its parent.
	 *
	 * At first, always the JQAdm code generated by the parent is printed, then
	 * the JQAdm code of its sub-clients. The order of the JQAdm sub-clients
	 * determines the order of the output of these sub-clients inside the parent
	 * container. If the configured list of clients is
	 *
	 *  array( "subclient1", "subclient2" )
	 *
	 * you can easily change the order of the output by reordering the subparts:
	 *
	 *  admin/jqadm/<clients>/subparts = array( "subclient1", "subclient2" )
	 *
	 * You can also remove one or more parts if they shouldn't be rendered:
	 *
	 *  admin/jqadm/<clients>/subparts = array( "subclient1" )
	 *
	 * As the clients only generates structural JQAdm, the layout defined via CSS
	 * should support adding, removing or reordering content by a fluid like
	 * design.
	 *
	 * @param array List of sub-client names
	 * @since 2016.01
	 * @category Developer
	 */
	private $subPartPath = 'admin/jqadm/product/image/standard/subparts';
	private $subPartNames = array();


	/**
	 * Copies a resource
	 *
	 * @return string|null admin output to display or null for redirecting to the list
	 */
	public function copy()
	{
		$view = $this->getView();

		$this->setData( $view );
		$view->imageBody = '';

		foreach( $this->getSubClients() as $client ) {
			$view->imageBody .= $client->copy();
		}

		$tplconf = 'admin/jqadm/product/image/template-item';
		$default = 'product/item-image-default.php';

		return $view->render( $view->config( $tplconf, $default ) );
	}


	/**
	 * Creates a new resource
	 *
	 * @return string|null admin output to display or null for redirecting to the list
	 */
	public function create()
	{
		$view = $this->getView();

		$this->setData( $view );
		$view->imageBody = '';

		foreach( $this->getSubClients() as $client ) {
			$view->imageBody .= $client->create();
		}

		$tplconf = 'admin/jqadm/product/image/template-item';
		$default = 'product/item-image-default.php';

		return $view->render( $view->config( $tplconf, $default ) );
	}


	/**
	 * Returns a single resource
	 *
	 * @return string|null admin output to display or null for redirecting to the list
	 */
	public function get()
	{
		$view = $this->getView();

		$this->setData( $view );
		$view->imageBody = '';

		foreach( $this->getSubClients() as $client ) {
			$view->imageBody .= $client->get();
		}

		$tplconf = 'admin/jqadm/product/image/template-item';
		$default = 'product/item-image-default.php';

		return $view->render( $view->config( $tplconf, $default ) );
	}


	/**
	 * Saves the data
	 *
	 * @return string|null admin output to display or null for redirecting to the list
	 */
	public function save()
	{
		$view = $this->getView();
		$context = $this->getContext();

		$manager = \Aimeos\MShop\Factory::createManager( $context, 'product/lists' );
		$mediaManager = \Aimeos\MShop\Factory::createManager( $context, 'media' );

		$manager->begin();
		$mediaManager->begin();

		try
		{
			$this->updateItems( $view );
			$view->imageBody = '';

			foreach( $this->getSubClients() as $client ) {
				$view->imageBody .= $client->save();
			}

			$mediaManager->commit();
			$manager->commit();
			return;
		}
		catch( \Aimeos\MShop\Exception $e )
		{
			$error = array( 'product-item-image' => $context->getI18n()->dt( 'mshop', $e->getMessage() ) );
			$view->errors = $view->get( 'errors', array() ) + $error;

			$mediaManager->rollback();
			$manager->rollback();
		}
		catch( \Exception $e )
		{
			$context->getLogger()->log( $e->getMessage() . ' - ' . $e->getTraceAsString() );
			$error = array( 'product-item-image' => $e->getMessage() );
			$view->errors = $view->get( 'errors', array() ) + $error;

			$mediaManager->rollback();
			$manager->rollback();
		}

		throw new \Aimeos\Admin\JQAdm\Exception();
	}


	/**
	 * Returns the sub-client given by its name.
	 *
	 * @param string $type Name of the client type
	 * @param string|null $name Name of the sub-client (Default if null)
	 * @return \Aimeos\Admin\JQAdm\Iface Sub-client object
	 */
	public function getSubClient( $type, $name = null )
	{
		/** admin/jqadm/product/image/decorators/excludes
		 * Excludes decorators added by the "common" option from the product JQAdm client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to remove a decorator added via
		 * "admin/jqadm/common/decorators/default" before they are wrapped
		 * around the JQAdm client.
		 *
		 *  admin/jqadm/product/image/decorators/excludes = array( 'decorator1' )
		 *
		 * This would remove the decorator named "decorator1" from the list of
		 * common decorators ("\Aimeos\Admin\JQAdm\Common\Decorator\*") added via
		 * "admin/jqadm/common/decorators/default" to the JQAdm client.
		 *
		 * @param array List of decorator names
		 * @since 2016.01
		 * @category Developer
		 * @see admin/jqadm/common/decorators/default
		 * @see admin/jqadm/product/image/decorators/global
		 * @see admin/jqadm/product/image/decorators/local
		 */

		/** admin/jqadm/product/image/decorators/global
		 * Adds a list of globally available decorators only to the product JQAdm client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to wrap global decorators
		 * ("\Aimeos\Admin\JQAdm\Common\Decorator\*") around the JQAdm client.
		 *
		 *  admin/jqadm/product/image/decorators/global = array( 'decorator1' )
		 *
		 * This would add the decorator named "decorator1" defined by
		 * "\Aimeos\Admin\JQAdm\Common\Decorator\Decorator1" only to the JQAdm client.
		 *
		 * @param array List of decorator names
		 * @since 2016.01
		 * @category Developer
		 * @see admin/jqadm/common/decorators/default
		 * @see admin/jqadm/product/image/decorators/excludes
		 * @see admin/jqadm/product/image/decorators/local
		 */

		/** admin/jqadm/product/image/decorators/local
		 * Adds a list of local decorators only to the product JQAdm client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to wrap local decorators
		 * ("\Aimeos\Admin\JQAdm\Product\Decorator\*") around the JQAdm client.
		 *
		 *  admin/jqadm/product/image/decorators/local = array( 'decorator2' )
		 *
		 * This would add the decorator named "decorator2" defined by
		 * "\Aimeos\Admin\JQAdm\Product\Decorator\Decorator2" only to the JQAdm client.
		 *
		 * @param array List of decorator names
		 * @since 2016.01
		 * @category Developer
		 * @see admin/jqadm/common/decorators/default
		 * @see admin/jqadm/product/image/decorators/excludes
		 * @see admin/jqadm/product/image/decorators/global
		 */
		return $this->createSubClient( 'product/image/' . $type, $name );
	}


	/**
	 * Returns the list of sub-client names configured for the client.
	 *
	 * @return array List of JQAdm client names
	 */
	protected function getSubClientNames()
	{
		return $this->getContext()->getConfig()->get( $this->subPartPath, $this->subPartNames );
	}


	/**
	 * Returns the mapped input parameter or the existing items as expected by the template
	 *
	 * @param \Aimeos\MW\View\Iface $view View object with helpers and assigned parameters
	 * @return array Multi-dimensional associative array
	 */
	protected function setData( \Aimeos\MW\View\Iface $view )
	{
		$view->imageData = (array) $view->param( 'image', array() );

		if( !empty( $view->imageData ) || ( $id = $view->item->getId() ) === null ) {
			return;
		}

		$data = array();

		foreach( $view->item->getListItems( 'media', 'default' ) as $id => $listItem )
		{
			$data['product.lists.id'][] = $id;

			foreach( $listItem->getRefItem()->toArray() as $key => $value ) {
				$data[$key][] = $value;
			}
		}

		if( !isset( $data['product.lists.id'] ) ) { // show at least one block
			$data['product.lists.id'][] = '';
		}

		$view->imageData = $data;
	}


	/**
	 * Updates existing product image references or creates new ones
	 *
	 * @param \Aimeos\MW\View\Iface $view View object with helpers and assigned parameters
	 */
	protected function updateItems( \Aimeos\MW\View\Iface $view )
	{
		$id = $view->item->getId();
		$context = $this->getContext();

		$manager = \Aimeos\MShop\Factory::createManager( $context, 'product' );
		$mediaManager = \Aimeos\MShop\Factory::createManager( $context, 'media' );
		$listManager = \Aimeos\MShop\Factory::createManager( $context, 'product/lists' );
		$mediaTypeManager = \Aimeos\MShop\Factory::createManager( $context, 'media/type' );
		$listTypeManager = \Aimeos\MShop\Factory::createManager( $context, 'product/lists/type' );
		$cntl = \Aimeos\Controller\Common\Media\Factory::createController( $context );

		$listIds = (array) $view->param( 'image/product.lists.id', array() );
		$listItems = $manager->getItem( $id, array( 'media' ) )->getListItems( 'media' );


		$listItem = $listManager->createItem();
		$listItem->setTypeId( $listTypeManager->findItem( 'default', array(), 'media' )->getId() );
		$listItem->setDomain( 'media' );
		$listItem->setParentId( $id );
		$listItem->setStatus( 1 );

		$mediaItem = $mediaManager->createItem();
		$mediaItem->setTypeId( $mediaTypeManager->findItem( 'default', array(), 'product' )->getId() );
		$mediaItem->setDomain( 'product' );
		$mediaItem->setStatus( 1 );

		$files = $view->value( $view->request()->getUploadedFiles(), 'image/files', array() );
		$files = ( is_array( $files ) ? $files : array( $files ) );
		$num = 0;

		foreach( $listIds as $idx => $listid )
		{
			if( !isset( $listItems[$listid] ) )
			{
				$litem = $listItem;
				$litem->setId( null );

				if( ( $file = $view->value( $files, $num ) ) === null ) {
					throw new \Aimeos\Admin\JQAdm\Exception( sprintf( 'No uploaded file for %1$d. new entry ', $num ) );
				}

				$cntl->add( $mediaItem, $file );
				$num++;
			}
			else
			{
				$litem = $listItems[$listid];
				$item = $litem->getRefItem();
			}

			$mediaItem->setLabel( $view->param( 'image/media.label/' . $idx ) );
			$mediaItem->setLanguageId( $view->param( 'image/media.languageid/' . $idx ) );

			$mediaManager->saveItem( $mediaItem );

			$litem->setPosition( $idx );
			$litem->setRefId( $mediaItem->getId() );

			$listManager->saveItem( $litem, false );
		}


		$rmIds = array();
		$rmListIds = array_diff( array_keys( $listItems ), $listIds );

		foreach( $rmListIds as $rmListId )
		{
			$item = $listItems[$rmListId]->getRefItem();
			$cntl->delete( $item );
			$rmIds[] = $item->getId();
		}

		$listManager->deleteItems( $rmListIds  );
		$mediaManager->deleteItems( $rmIds  );
	}
}