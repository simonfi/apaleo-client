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
 * @brief Implementation of Apaleo RatePlan API
 */
class RatePlanApi extends ApiBase
{
	/**
	 * @brief Get and return the available rate plans for the given property
	 */
	public function getRatePlans(	string $pPropertyId,
					int $pPageNumber = 1,
					int $pPageSize = 100)
	{
		$lParametersArray = [];

		$lRatePlans = $this->get(	'rateplan/v1/rate-plans',
					[
						'propertyId' => $pPropertyId,
						'pageNumber' => ''.$pPageNumber,
						'pageSize' => ''.$pPageSize
					]);

		if (!isset($lRatePlans->ratePlans))
		{
			return [];
		}

		return $lRatePlans->ratePlans;
	}

	/**
	 * @brief Get and return information (in all languages) of the given rate plane
	 */
	public function getRatePlan(string $pRatePlanId)
	{
		$lProperty = $this->get('rateplan/v1/rate-plans/' . $pRatePlanId,
					[
						'languages' => 'ALL',
						'expand' => 'cancellationPolicy'
					]);

		return $lProperty;
	}
}
