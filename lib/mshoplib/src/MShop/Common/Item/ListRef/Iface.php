<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2017
 * @package MShop
 * @subpackage Common
 */


namespace Aimeos\MShop\Common\Item\ListRef;


/**
 * Common interface for items containing referenced list items.
 *
 * @package MShop
 * @subpackage Common
 */
interface Iface
{
	/**
	 * Adds a new item to the given domain and references it by a list item
	 *
	 * @param string $domain Name of the domain (e.g. media, text, etc.)
	 * @param \Aimeos\MShop\Common\Item\Lists\Iface $listItem List item referencing the new domain item
	 * @param \Aimeos\MShop\Common\Item\Iface|null $refItem New item added to the given domain or null if no item should be referenced
	 * @return \Aimeos\MShop\Common\Item\ListRef\Iface Self object for method chaining
	 */
	public function addRefItem( $domain, \Aimeos\MShop\Common\Item\Lists\Iface $listItem, \Aimeos\MShop\Common\Item\Iface $refItem = null );

	/**
	 * Removes an item from the given domain and its list item referencing it
	 *
	 * @param string $domain Name of the domain (e.g. media, text, etc.)
	 * @param \Aimeos\MShop\Common\Item\Lists\Iface $listItem List item referencing the domain item
	 * @param \Aimeos\MShop\Common\Item\Iface|null $refItem Existing item removed from the given domain or null if item shouldn't be removed
	 * @return \Aimeos\MShop\Common\Item\ListRef\Iface Self object for method chaining
	 */
	public function deleteRefItem( $domain, \Aimeos\MShop\Common\Item\Lists\Iface $listItem, \Aimeos\MShop\Common\Item\Iface $refItem = null );

	/**
	 * Returns the deleted items per domain
	 *
	 * @return array Associative list of domains as keys and lists of list items containing the referenced items as values
	 */
	public function getDeletedItems();

	/**
	 * Returns the list item for the given reference ID, domain and list type
	 *
	 * @param string $domain Name of the domain (e.g. product, text, etc.)
	 * @param string $listtype Name of the list item type
	 * @param string $refId Unique ID of the referenced item
	 * @param boolean $active True to return only active items, false to return all
	 * @return \Aimeos\MShop\Common\Item\Lists\Iface|null Matching list item or null if none
	 */
	public function getListItem( $domain, $listtype, $refId, $active = true );

	/**
	 * Returns the list items attached, optionally filtered by domain and list type.
	 * The reference parameter in searchItems() must have been set accordingly
	 * to the requested domain to get the items. Otherwise, no items will be
	 * returned by this method.
	 *
	 * @param array|string|null $domain Name/Names of the domain (e.g. product, text, etc.) or null for all
	 * @param array|string|null $listtype Name/Names of the list item type or null for all
	 * @param array|string|null $type Name/Names of the item type or null for all
	 * @param boolean $active True to return only active items, false to return all
	 * @return array List of items implementing \Aimeos\MShop\Common\Item\Lists\Iface
	 */
	public function getListItems( $domain = null, $listtype = null, $type = null, $active = true );

	/**
	 * Returns the product, text, etc. items, optionally filtered by type.
	 * The reference parameter in searchItems() must have been set accordingly
	 * to the requested domain to get the items. Otherwise, no items will be
	 * returned by this method.
	 *
	 * @param array|string|null $domain Name/Names of the domain (e.g. product, text, etc.) or null for all
	 * @param array|string|null $type Name/Names of the item type or null for all
	 * @param array|string|null $listtype Name/Names of the list item type or null for all
	 * @param boolean $active True to return only active items, false to return all
	 * @return array List of items implementing \Aimeos\MShop\Common\Item\Iface
	 */
	public function getRefItems( $domain = null, $type = null, $listtype = null, $active = true );

	/**
	 * Returns the localized text type of the item or the internal label if no name is available.
	 *
	 * @param string $type Text type to be returned
	 * @return string Specified text type or label of the item
	 */
	public function getName( $type = 'name' );
}
