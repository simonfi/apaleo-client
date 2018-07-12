<?php
/**
 * PHP Implementation of Apaleo API.
 *
 * Copyright 2017 Loopon AB. See LICENSE for details (MIT License; free to use as you wish).
 *
 * This code is provided as-is without warranty of any kind. If you do have questions/need assistance with this example,
 * feel free to contact Simon Finne <simon.finne@loopon.com> where I will try to respond if possible, but cannot
 * guarantee any support.
 *
 * Note, that if you for any reason want to connect to Apaleo's staging environment, you need to update the
 * ApaleoProvider::cIdentityUrl and ApaleoClient::cApiUrl configurations.
 *
 * Contact api@apaleo.com or see dev.apaleo.com for help regarding their api.
 */

namespace Loopon\Apaleo\Client;

/**
 * @brief Implementation of Apaleo Inventory API
 */
class InventoryApi extends ApiBase
{
	/**
	 * @brief Get and return the available inventory; default to 100 first hotels
	 */
	public function getProperties(int $pPageNumber = 1, int $pPageSize = 100)
	{
		$lProperties = $this->get(	'inventory/v1/properties',
					[
						'pageNumber' => ''.$pPageNumber,
						'pageSize' => ''.$pPageSize
					]);

		if (!isset($lProperties->properties))
		{
			return [];
		}

		return $lProperties->properties;
	}

	/**
	 * @brief Get and return information (in all languages) of the given property
	 */
	public function getProperty(string $pPropertyId)
	{
		$lProperty = $this->get('inventory/v1/properties/' . $pPropertyId,
					[
						'languages' => 'ALL'
					]);

		return $lProperty;
	}

	/**
	 * @brief Get and return the available unit groups for the given property id
	 */
	public function getUnitGroups(	string $pPropertyId,
					int $pPageNumber = 1,
					int $pPageSize = 100)
	{
		$lUnitGroups = $this->get(	'inventory/v1/unit-groups',
						[
							'propertyId' => $pPropertyId,
							'pageNumber' => ''.$pPageNumber,
							'pageSize' => ''.$pPageSize
						]);

		if (!isset($lUnitGroups->unitGroups))
		{
			return [];
		}

		return $lUnitGroups->unitGroups;
	}

	/**
	 * @brief Get and return the available units for the given property id
	 */
	public function getUnits(	string $pPropertyId,
					int $pPageNumber = 1,
					int $pPageSize = 100)
	{
		$lUnits = $this->get(	'inventory/v1/units',
					[
						'propertyId' => $pPropertyId,
						'pageNumber' => ''.$pPageNumber,
						'pageSize' => ''.$pPageSize
					]);

		if (!isset($lUnits->units))
		{
			return [];
		}

		return $lUnits->units;
	}

	/**
	 * @brief Get and return information about the given unit (in all languages)
	 */
	public function getUnit(string $pUnitId)
	{
		$lUnit = $this->get(	'inventory/v1/units/' . $pUnitId,
					[
						'languages' => 'ALL'
					]);

		return $lUnit;
	}
}
