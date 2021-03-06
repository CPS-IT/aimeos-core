<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2017
 * @package MShop
 * @subpackage Order
 */


namespace Aimeos\MShop\Order\Item\Base\Product;


/**
 * Product item of order base
 * @package MShop
 * @subpackage Order
 */
class Standard extends Base implements Iface
{
	private $price;
	private $products;
	private $values;


	/**
	 * Initializes the order product instance.
	 *
	 * @param \Aimeos\MShop\Price\Item\Iface $price Price item
	 * @param array $values Associative list of order product values
	 * @param array $attributes List of order attributes implementing \Aimeos\MShop\Order\Item\Base\Product\Attribute\Iface
	 * @param array $products List of ordered subproducts implementing \Aimeos\MShop\Order\Item\Base\Product\Iface
	 */
	public function __construct( \Aimeos\MShop\Price\Item\Iface $price, array $values = [], array $attributes = [], array $products = [] )
	{
		parent::__construct( $price, $values, $attributes );

		$this->price = $price;
		$this->values = $values;

		\Aimeos\MW\Common\Base::checkClassList( '\Aimeos\MShop\Order\Item\Base\Product\Iface', $products );
		$this->products = $products;
	}


	/**
	 * Clones internal objects of the order base product item.
	 */
	public function __clone()
	{
		$this->price = clone $this->price;
	}


	/**
	 * Returns the ID of the site the item is stored
	 *
	 * @return string|null Site ID (or null if not available)
	 */
	public function getSiteId()
	{
		if( isset( $this->values['order.base.product.siteid'] ) ) {
			return (string) $this->values['order.base.product.siteid'];
		}
	}


	/**
	 * Sets the site ID of the item.
	 *
	 * @param string $value Unique site ID of the item
	 * @return \Aimeos\MShop\Order\Item\Base\Product\Iface Order base product item for chaining method calls
	 */
	public function setSiteId( $value )
	{
		if( (string) $value !== $this->getSiteId() )
		{
			$this->values['order.base.product.siteid'] = (string) $value;
			$this->setModified();
		}

		return $this;
	}


	/**
	 * Returns the base ID.
	 *
	 * @return string|null Base ID
	 */
	public function getBaseId()
	{
		if( isset( $this->values['order.base.product.baseid'] ) ) {
			return (string) $this->values['order.base.product.baseid'];
		}
	}


	/**
	 * Sets the base order ID the product belongs to.
	 *
	 * @param string $value New order base ID
	 * @return \Aimeos\MShop\Order\Item\Base\Product\Iface Order base product item for chaining method calls
	 */
	public function setBaseId( $value )
	{
		if( (string) $value !== $this->getBaseId() )
		{
			$this->values['order.base.product.baseid'] = (string) $value;
			$this->setModified();
		}

		return $this;
	}


	/**
	 * Returns the parent ID of the ordered product if there is one.
	 * This ID relates to another product of the same order and provides a relation for e.g. sub-products in bundles.
	 *
	 * @return string|null Order product ID
	 */
	public function getOrderProductId()
	{
		if( isset( $this->values['order.base.product.ordprodid'] ) ) {
			return (string) $this->values['order.base.product.ordprodid'];
		}
	}


	/**
	 * Sets the parent ID of the ordered product.
	 * This ID relates to another product of the same order and provides a relation for e.g. sub-products in bundles.
	 *
	 * @param string|null $value Order product ID
	 * @return \Aimeos\MShop\Order\Item\Base\Product\Iface Order base product item for chaining method calls
	 */
	public function setOrderProductId( $value )
	{
		if( $value !== $this->getOrderProductId() )
		{
			$this->values['order.base.product.ordprodid'] = ( $value !== null ? (string) $value : null );
			$this->setModified();
		}

		return $this;
	}


	/**
	 * Returns the type of the ordered product.
	 *
	 * @return string Type of the ordered product
	 */
	public function getType()
	{
		if( isset( $this->values['order.base.product.type'] ) ) {
			return (string) $this->values['order.base.product.type'];
		}

		return '';
	}


	/**
	 * Sets the type of the ordered product.
	 *
	 * @param string Type of the order product
	 * @return \Aimeos\MShop\Order\Item\Base\Product\Iface Order base product item for chaining method calls
	 */
	public function setType( $type )
	{
		if( (string) $type !== $this->getType() )
		{
			$this->values['order.base.product.type'] = (string) $type;
			$this->setModified();
		}

		return $this;
	}


	/**
	 * Returns a array of order base product items
	 *
	 * @return array Associative list of product items that implements \Aimeos\MShop\Order\Item\Base\Product\Iface
	 */
	public function getProducts()
	{
		return $this->products;
	}

	/**
	 * Sets a array of order base product items
	 *
	 * @param array Associative list of product items which must implement the \Aimeos\MShop\Order\Item\Base\Product\Iface
	 * @return \Aimeos\MShop\Order\Item\Base\Product\Iface Order base product item for chaining method calls
	 */
	public function setProducts( array $products )
	{
		\Aimeos\MW\Common\Base::checkClassList( '\Aimeos\MShop\Order\Item\Base\Product\Iface', $products );

		$this->products = $products;
		$this->setModified();

		return $this;
	}


	/**
	 * Returns the supplier code.
	 *
	 * @return string the code of supplier
	 */
	public function getSupplierCode()
	{
		if( isset( $this->values['order.base.product.suppliercode'] ) ) {
			return (string) $this->values['order.base.product.suppliercode'];
		}

		return '';
	}


	/**
	 * Sets the supplier code.
	 *
	 * @param string $suppliercode Code of supplier
	 * @return \Aimeos\MShop\Order\Item\Base\Product\Iface Order base product item for chaining method calls
	 */
	public function setSupplierCode( $suppliercode )
	{
		if( (string) $suppliercode !== $this->getSupplierCode() )
		{
			$this->values['order.base.product.suppliercode'] = (string) $this->checkCode( $suppliercode );
			$this->setModified();
		}

		return $this;
	}


	/**
	 * Returns the product ID the customer has selected.
	 *
	 * @return string Original product ID
	 */
	public function getProductId()
	{
		if( isset( $this->values['order.base.product.productid'] ) ) {
			return (string) $this->values['order.base.product.productid'];
		}

		return '';
	}


	/**
	 * Sets the ID of a product the customer has selected.
	 *
	 * @param string Product Code ID
	 * @return \Aimeos\MShop\Order\Item\Base\Product\Iface Order base product item for chaining method calls
	 */
	public function setProductId( $id )
	{
		if( (string) $id !== $this->getProductId() )
		{
			$this->values['order.base.product.productid'] = (string) $id;
			$this->setModified();
		}

		return $this;
	}


	/**
	 * Returns the product code the customer has selected.
	 *
	 * @return string Product code
	 */
	public function getProductCode()
	{
		if( isset( $this->values['order.base.product.prodcode'] ) ) {
			return (string) $this->values['order.base.product.prodcode'];
		}

		return '';
	}


	/**
	 * Sets the code of a product the customer has selected.
	 *
	 * @param string $code Product code
	 * @return \Aimeos\MShop\Order\Item\Base\Product\Iface Order base product item for chaining method calls
	 */
	public function setProductCode( $code )
	{
		if( (string) $code !== $this->getProductCode() )
		{
			$this->values['order.base.product.prodcode'] = (string) $this->checkCode( $code );
			$this->setModified();
		}

		return $this;
	}


	/**
	 * Returns the code of the stock type the product should be retrieved from.
	 *
	 * @return string Stock type
	 */
	public function getStockType()
	{
		if( isset( $this->values['order.base.product.stocktype'] ) ) {
			return (string) $this->values['order.base.product.stocktype'];
		}

		return '';
	}


	/**
	 * Sets the code of the stock type the product should be retrieved from.
	 *
	 * @param string $code Stock type
	 * @return \Aimeos\MShop\Order\Item\Base\Product\Iface Order base product item for chaining method calls
	 */
	public function setStockType( $code )
	{
		if( (string) $code !== $this->getStockType() )
		{
			$this->values['order.base.product.stocktype'] = (string) $this->checkCode( $code );
			$this->setModified();
		}

		return $this;
	}


	/**
	 * Returns the localized name of the product.
	 *
	 * @return string Returns the localized name of the product
	 */
	public function getName()
	{
		if( isset( $this->values['order.base.product.name'] ) ) {
			return (string) $this->values['order.base.product.name'];
		}

		return '';
	}


	/**
	 * Sets the localized name of the product.
	 *
	 * @param string $value Localized name of the product
	 * @return \Aimeos\MShop\Order\Item\Base\Product\Iface Order base product item for chaining method calls
	 */
	public function setName( $value )
	{
		if( (string) $value !== $this->getName() )
		{
			$this->values['order.base.product.name'] = (string) $value;
			$this->setModified();
		}

		return $this;
	}


	/**
	 * Returns the location of the media.
	 *
	 * @return string Location of the media
	 */
	public function getMediaUrl()
	{
		if( isset( $this->values['order.base.product.mediaurl'] ) ) {
			return (string) $this->values['order.base.product.mediaurl'];
		}

		return '';
	}


	/**
	 * Sets the media url of the product the customer has added.
	 *
	 * @param string $value Location of the media/picture
	 * @return \Aimeos\MShop\Order\Item\Base\Product\Iface Order base product item for chaining method calls
	 */
	public function setMediaUrl( $value )
	{
		if( (string) $value !== $this->getMediaUrl() )
		{
			$this->values['order.base.product.mediaurl'] = (string) $value;
			$this->setModified();
		}

		return $this;
	}


	/**
	 * Returns the URL target specific for that product
	 *
	 * @return string URL target specific for that product
	 */
	public function getTarget()
	{
		if( isset( $this->values['order.base.product.target'] ) ) {
			return (string) $this->values['order.base.product.target'];
		}

		return '';
	}


	/**
	 * Sets the URL target specific for that product
	 *
	 * @param string $value New URL target specific for that product
	 * @return \Aimeos\MShop\Order\Item\Base\Product\Iface Order base product item for chaining method calls
	 */
	public function setTarget( $value )
	{
		if( (string) $value !== $this->getTarget() )
		{
			$this->values['order.base.product.target'] = (string) $value;
			$this->setModified();
		}

		return $this;
	}


	/**
	 * Returns the amount of products the customer has added.
	 *
	 * @return integer Amount of products
	 */
	public function getQuantity()
	{
		if( isset( $this->values['order.base.product.quantity'] ) ) {
			return (int) $this->values['order.base.product.quantity'];
		}

		return 1;
	}


	/**
	 * Sets the amount of products the customer has added.
	 *
	 * @param integer $quantity Amount of products
	 * @return \Aimeos\MShop\Order\Item\Base\Product\Iface Order base product item for chaining method calls
	 */
	public function setQuantity( $quantity )
	{
		if( $quantity < 1 || $quantity > 2147483647 ) {
			throw new \Aimeos\MShop\Order\Exception( sprintf( 'Quantity must be a positive integer and must not exceed %1$d', 2147483647 ) );
		}

		if( (int) $quantity !== $this->getQuantity() )
		{
			$this->values['order.base.product.quantity'] = (int) $quantity;
			$this->setModified();
		}

		return $this;
	}


	/**
	 * Returns the price item for the product.
	 *
	 * @return \Aimeos\MShop\Price\Item\Iface Price item with price, costs and rebate
	 */
	public function getPrice()
	{
		return $this->price;
	}


	/**
	 * Sets the price item for the product.
	 *
	 * @param \Aimeos\MShop\Price\Item\Iface $price Price item containing price and additional costs
	 * @return \Aimeos\MShop\Order\Item\Base\Product\Iface Order base product item for chaining method calls
	 */
	public function setPrice( \Aimeos\MShop\Price\Item\Iface $price )
	{
		if( $price !== $this->price )
		{
			$this->price = $price;
			$this->setModified();
		}

		return $this;
	}


	/**
	 * 	Returns the flags for the product item.
	 *
	 * @return integer Flags, e.g. for immutable products
	 */
	public function getFlags()
	{
		if( isset( $this->values['order.base.product.flags'] ) ) {
			return (int) $this->values['order.base.product.flags'];
		}

		return \Aimeos\MShop\Order\Item\Base\Product\Base::FLAG_NONE;
	}


	/**
	 * Sets the new value for the product item flags.
	 *
	 * @param integer $value Flags, e.g. for immutable products
	 * @return \Aimeos\MShop\Order\Item\Base\Product\Iface Order base product item for chaining method calls
	 */
	public function setFlags( $value )
	{
		if( (int) $value !== $this->getFlags() )
		{
			$this->values['order.base.product.flags'] = (int) $this->checkFlags( $value );
			$this->setModified();
		}

		return $this;
	}


	/**
	 * Returns the position of the product in the order.
	 *
	 * @return integer|null Product position in the order from 1-n
	 */
	public function getPosition()
	{
		if( isset( $this->values['order.base.product.position'] ) ) {
			return (int) $this->values['order.base.product.position'];
		}
	}


	/**
	 * Sets the position of the product within the list of ordered products.
	 *
	 * @param integer|null $value Product position in the order from 1-n or null for resetting the position
	 * @return \Aimeos\MShop\Order\Item\Base\Product\Iface Order base product item for chaining method calls
	 * @throws \Aimeos\MShop\Order\Exception If there's already a position set
	 */
	public function setPosition( $value )
	{
		if( $value !== null && $value < 1 ) {
			throw new \Aimeos\MShop\Order\Exception( sprintf( 'Order product position "%1$s" must be greater than 0', $value ) );
		}

		if( $value !== $this->getPosition() )
		{
			$this->values['order.base.product.position'] = ( $value !== null ? (int) $value : null );
			$this->setModified();
		}

		return $this;
	}


	/**
	 * Returns the current delivery status of the order product item.
	 *
	 * The returned status values are the STAT_* constants from the
	 * \Aimeos\MShop\Order\Item\Base class
	 *
	 * @return integer Delivery status of the product
	 */
	public function getStatus()
	{
		if( isset( $this->values['order.base.product.status'] ) ) {
			return (int) $this->values['order.base.product.status'];
		}

		return \Aimeos\MShop\Order\Item\Base::STAT_UNFINISHED;
	}


	/**
	 * Sets the new delivery status of the order product item.
	 *
	 * Possible status values are the STAT_* constants from the
	 * \Aimeos\MShop\Order\Item\Base class
	 *
	 * @param integer $value New delivery status of the product
	 * @return \Aimeos\MShop\Order\Item\Base\Product\Iface Order base product item for chaining method calls
	 */
	public function setStatus( $value )
	{
		if( (int) $value !== $this->getStatus() )
		{
			$this->values['order.base.product.status'] = (int) $value;
			$this->setModified();
		}

		return $this;
	}


	/**
	 * Sets the item values from the given array.
	 *
	 * @param array $list Associative list of item keys and their values
	 * @return array Associative list of keys and their values that are unknown
	 */
	public function fromArray( array $list )
	{
		$unknown = [];

		if( isset( $list['order.base.product.siteid'] ) ) { // set siteid in this class too
			$this->setSiteId( $list['order.base.product.siteid'] );
		}

		$list = parent::fromArray( $list );

		foreach( $list as $key => $value )
		{
			switch( $key )
			{
				case 'order.base.product.baseid': $this->setBaseId( $value ); break;
				case 'order.base.product.ordprodid': $this->setOrderProductId( $value ); break;
				case 'order.base.product.type': $this->setType( $value ); break;
				case 'order.base.product.stocktype': $this->setStockType( $value ); break;
				case 'order.base.product.suppliercode': $this->setSupplierCode( $value ); break;
				case 'order.base.product.productid': $this->setProductId( $value ); break;
				case 'order.base.product.prodcode': $this->setProductCode( $value ); break;
				case 'order.base.product.name': $this->setName( $value ); break;
				case 'order.base.product.mediaurl': $this->setMediaUrl( $value ); break;
				case 'order.base.product.target': $this->setTarget( $value ); break;
				case 'order.base.product.position': $this->setPosition( $value ); break;
				case 'order.base.product.quantity': $this->setQuantity( $value ); break;
				case 'order.base.product.status': $this->setStatus( $value ); break;
				case 'order.base.product.flags': $this->setFlags( $value ); break;
				case 'order.base.product.price': $this->price->setValue( $value ); break;
				case 'order.base.product.costs': $this->price->setCosts( $value ); break;
				case 'order.base.product.rebate': $this->price->setRebate( $value ); break;
				case 'order.base.product.taxrate': $this->price->setTaxRate( $value ); break;
				default: $unknown[$key] = $value;
			}
		}

		return $unknown;
	}


	/**
	 * Returns the item values as associative list.
	 *
	 * @param boolean True to return private properties, false for public only
	 * @return array Associative list of item properties and their values
	 */
	public function toArray( $private = false )
	{
		$list = parent::toArray( $private );

		$list['order.base.product.type'] = $this->getType();
		$list['order.base.product.stocktype'] = $this->getStockType();
		$list['order.base.product.suppliercode'] = $this->getSupplierCode();
		$list['order.base.product.prodcode'] = $this->getProductCode();
		$list['order.base.product.productid'] = $this->getProductId();
		$list['order.base.product.quantity'] = $this->getQuantity();
		$list['order.base.product.name'] = $this->getName();
		$list['order.base.product.mediaurl'] = $this->getMediaUrl();
		$list['order.base.product.price'] = $this->price->getValue();
		$list['order.base.product.costs'] = $this->price->getCosts();
		$list['order.base.product.rebate'] = $this->price->getRebate();
		$list['order.base.product.taxrate'] = $this->price->getTaxRate();
		$list['order.base.product.status'] = $this->getStatus();
		$list['order.base.product.position'] = $this->getPosition();

		if( $private === true )
		{
			$list['order.base.product.baseid'] = $this->getBaseId();
			$list['order.base.product.ordprodid'] = $this->getOrderProductId();
			$list['order.base.product.target'] = $this->getTarget();
			$list['order.base.product.flags'] = $this->getFlags();
		}

		return $list;
	}

	/**
	 * Compares the properties of the given order product item with its own ones.
	 *
	 * @param \Aimeos\MShop\Order\Item\Base\Product\Iface $item Order product item
	 * @return boolean True if the item properties are equal, false if not
	 * @since 2014.09
	 */
	public function compare( \Aimeos\MShop\Order\Item\Base\Product\Iface $item )
	{
		if( $this->getFlags() === $item->getFlags()
			&& $this->getName() === $item->getName()
			&& $this->getSiteId() === $item->getSiteId()
			&& $this->getStockType() === $item->getStockType()
			&& $this->getProductCode() === $item->getProductCode()
			&& $this->getSupplierCode() === $item->getSupplierCode()
			&& $this->getPrice()->compare( $item->getPrice() ) === true
		) {
			return true;
		}

		return false;
	}


	/**
	 * Copys all data from a given product item.
	 *
	 * @param \Aimeos\MShop\Product\Item\Iface $product Product item to copy from
	 */
	public function copyFrom( \Aimeos\MShop\Product\Item\Iface $product )
	{
		$this->setSiteId( $product->getSiteId() );
		$this->setProductCode( $product->getCode() );
		$this->setProductId( $product->getId() );
		$this->setType( $product->getType() );
		$this->setName( $product->getName() );
		$this->setTarget( $product->getTarget() );

		$items = $product->getRefItems( 'text', 'basket', 'default' );
		if( ( $item = reset( $items ) ) !== false ) {
			$this->setName( $item->getContent() );
		}

		$items = $product->getRefItems( 'supplier', 'default', 'default' );
		if( ( $item = reset( $items ) ) !== false ) {
			$this->setSupplierCode( $item->getCode() );
		}

		$items = $product->getRefItems( 'media', 'default', 'default' );
		if( ( $item = reset( $items ) ) !== false ) {
			$this->setMediaUrl( $item->getPreview() );
		}

		$this->setModified();

		return $this;
	}
}
