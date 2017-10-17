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
 * @brief Simple base of reusable things for all API implementations
 */
abstract class ApiBase
{
	/**
	 * @var Client
	 */
	private $mClient;

	/**
	 * @brief Construct a new API Controller, using the given Client to talk to Apaleo
	 * @param Client $pClient
	 */
	public function __construct(Client $pClient)
	{
		$this->mClient = $pClient;
	}

	protected function get(string $pApiEndpoint, array $pParameters)
	{
		return $this->mClient->get($pApiEndpoint, $pParameters);
	}
}
