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
	 * @brief Get and return information of the given rate plan.
	 * The rate plan includes the description in all available languages.
	 * The cancellation policy is included in the rate plan. The cancellation policy description has one
	 * 'description' member, in only one language. If $pLanguageCode is specified, then apaleo will return the
	 * cancellation policy description in the specified language, in case the description is available in that
	 * language. If the cancellation policy description is not available in the specified language, or
	 * if $pLanguageCode is null, apaleo will return the description in the default language.
	 * @param string $pRatePlanId
	 * @param string|null $pLanguageCode
	 * @return \stdClass|null
	 */
	public function getRatePlan(string $pRatePlanId, ?string $pLanguageCode) : ?\stdClass
	{
		$lLanguageHeader = $pLanguageCode !== null ? ['Accept-language: ' . $pLanguageCode] : [];

		$lProperty = $this->get(
		'rateplan/v1/rate-plans/' . $pRatePlanId,
			[
				'languages' => 'ALL',
				'expand' => 'cancellationPolicy'
			],
			$lLanguageHeader
		);

		return $lProperty;
	}
}
