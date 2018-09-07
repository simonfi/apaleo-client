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
 * @brief Implementation of Apaleo Booking API
 */
class BookingApi extends ApiBase
{
	/**
	 * @brief Get and return the reservations that have been modified since the given unix time stamp
	 *
	 * @param array $pPropertyIds Array of Property Ids for which to search for reservations
	 * @param int $pModifiedSince Unix timestamp; return all reservations that have changed after this point in  time
	 */
	public function getReservations(array $pPropertyIds,
					int $pModifiedSince,					
					int $pPageNumber = 1,
					int $pPageSize = 100)
	{
		$lReservations = $this->get(
					'booking/v1/reservations',
					[
						'expand' => 'booker,property,unit',
						'propertyIds' => $pPropertyIds,
						'from' => gmdate('Y-m-d\TH:i:s\Z', $pModifiedSince),
						'dateFilter' => 'Modification',
						'pageNumber' => ''.$pPageNumber,
						'pageSize' => ''.$pPageSize
					]);

		if (!isset($lReservations->reservations))
		{
			return [];
		}

		return $lReservations->reservations;
	}

	/**
	 * @brief Get and return detailed info on a specific reservation
	 *
	 * @param string $pReservationId 
	 */
	public function getReservation(string $pReservationId)
	{
		$lReservation = $this->get(
					'booking/v1/reservations/' . $pReservationId,
					[
						'expand' => 'booker,property,unit,ratePlan'
					]);

		return $lReservation;
	}


	/**
	 * @brief Get and return detailed info on a specific booking
	 *
	 * @param string $pBookingId
	 */
	public function getBooking(string $pBookingId)
	{
		$lBooking = $this->get(
			'booking/v1/bookings/' . $pBookingId,
			[]);

		return $lBooking;
	}


	/**
	 * @brief Assign a random available unit to the given reservation
	 * @param string $pReservationId
	 */
	public function assignUnitForReservation(string $pReservationId)
	{
		$lRoomInfo = $this->put('booking/v1/reservation-actions/' . $pReservationId . '/assign-unit', []);
		return $lRoomInfo;
	}
}
