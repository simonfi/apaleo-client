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
 * @brief Implementation of Apaleo Finance API
 */
class FinanceApi extends ApiBase
{
	/**
	 * @brief Get and return the available rate plans for the given property
	 */
	public function getInvoices(string $pReservationId)
	{
		$lParametersArray = [];

		$lInvoices = $this->get('finance/v1/invoices',
					[
						'reservationId' => $pReservationId
					]);

		if (!isset($lInvoices->invoices))
		{
			return [];
		}

		return $lInvoices->invoices;
	}
	
	public function getInvoicePdf(string $pInvoiceId)
	{
		return $this->getRaw(	'finance/v1/invoices/' . $pInvoiceId . '/pdf',
					[
					]);
	}
}
