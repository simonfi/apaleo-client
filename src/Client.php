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
 * @brief Authentication provider for the Apaleo basic authentication scheme
 */
class Provider extends \League\OAuth2\Client\Provider\GenericProvider
{
	/**
	 * @var string
	 */
	private $mClientId;

	/**
	 * @var string
	 */
	private $mClientSecret;

	const cIdentityUrl = 'https://identity.apaleo.com/';

	public function __construct(string $pClientId, string $pClientSecret)
	{
		parent::__construct([	'urlAccessToken' => self::cIdentityUrl . 'connect/token',
					'redirectUri' => '',
					'urlAuthorize' => '',
					'urlResourceOwnerDetails' => '']);

		$this->mClientId = $pClientId;
		$this->mClientSecret = $pClientSecret;
	}

	protected function getDefaultHeaders()
	{
		return ['Authorization' => 'Basic ' . base64_encode($this->mClientId . ':' . $this->mClientSecret)];
	}
}

/**
 * @brief Apaleo API client, which can authenticate and use the token to GET information from the API
 */
class Client
{
	/**
	 * @brief The referrer url provided when calling the Apaleo api
	 * @var string
	 */
	private $mClientUrl;

	/**
	 * @brief Grant provider for Apaleo API
	 */
	private $mApaleoProvider;

	/**
	 * @brief Cached authentication token after it has been retrieved once, null up until that point
	 * @var League\OAuth2\Client\Token\AccessToken
	 */
	private $mToken = null;

	/**
	 * @var BookingApi
	 */
	private $mBookingApi = null;

	/**
	 * @var InventoryApi
	 */
	private $mInventoryApi = null;

	/**
	 * @var RatePlanApi
	 */
	private $mRatePlanApi = null;
	
	const cApiUrl = 'https://api.apaleo.com/';

	/**
	 * @brief Setup the apaleo example for a given client url and apaleo environment
	 */
	public function __construct(	string $pClientUrl,
					string $pClientId,
					string $pClientSecret)
	{
		$this->mClientUrl = $pClientUrl;
		$this->mApaleoProvider = new Provider($pClientId, $pClientSecret);
	}

	/**
	 * @brief Return BookingApi, constructing it if needed
	 * @return BookingApi
	 */
	public function getBookingApi(): BookingApi
	{
		if ($this->mBookingApi === null)
		{
			$this->mBookingApi = new BookingApi($this);
		}

		return $this->mBookingApi;
	}

	/**
	 * @brief Return InventoryApi, constructing it if needed
	 * @return InventoryApi
	 */
	public function getInventoryApi(): InventoryApi
	{
		if ($this->mInventoryApi === null)
		{
			$this->mInventoryApi = new InventoryApi($this);
		}

		return $this->mInventoryApi;
	}

	/**
	 * @brief Return RatePlanApi, constructing it if needed
	 * @return RatePlanApi
	 */
	public function getRatePlanApi(): RatePlanApi
	{
		if ($this->mRatePlanApi === null)
		{
			$this->mRatePlanApi = new RatePlanApi($this);
		}

		return $this->mRatePlanApi;
	}

	/**
	 * @brief Return the received authentication token, or request and return it if it's the first call
	 */
	private function getToken()
	{
		// If we don't already have the access token, request it
		if ($this->mToken === null)
		{
			$this->mToken = $this->mApaleoProvider->getAccessToken('client_credentials', []);
		}

		return $this->mToken->getToken();
	}

	/**
	 * @brief Perform a GET request to the Apaleo API and return the decoded json data or null on error
	 */
	public function get(string $pApiEndpoint, array $pParameters)
	{
		$lHeaders = ['Accept: application/json', 'Authorization: Bearer ' . $this->getToken()];

		// Ensure correct encoding of parameters provided
		$lParameterFields =
			implode(
				'&',
				array_map(
					function (string $pKey, $pValue)
					{
						if (is_array($pValue))
						{
							$lValue = implode(
									',',
									array_map(
										function (string $pElementValue)
										{
											return urlencode($pElementValue);
										},
										$pValue));
						} else {
							$lValue = urlencode($pValue);							
						}

						return $pKey . '=' . $lValue;
					},
					array_keys($pParameters),
					array_values($pParameters)));

		$lUrl = self::cApiUrl . $pApiEndpoint;
		if (count($pParameters) > 0)
		{
			$lUrl .= '?' . $lParameterFields;
		}

		$lChannel = curl_init($lUrl);
		curl_setopt($lChannel, CURLOPT_HEADER, 0);
		curl_setopt($lChannel, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt($lChannel, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($lChannel, CURLOPT_REFERER, $this->mClientUrl);
		curl_setopt($lChannel, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($lChannel, CURLOPT_HTTPHEADER, $lHeaders);

		$lResponseData = curl_exec($lChannel);
		if ($lResponseData === false || curl_getinfo($lChannel, CURLINFO_HTTP_CODE) != 200)
		{
			$lInfo = curl_getinfo($lChannel);
			error_log('curl_exec failed during transfer: (http code: ' . $lInfo['http_code'] . ', url: ' . $lInfo['url'] . ', error: ' . curl_error($lChannel) . ').');
			curl_close($lChannel);
			return null;
		}

		curl_close($lChannel);

		return json_decode($lResponseData);
	}
}

