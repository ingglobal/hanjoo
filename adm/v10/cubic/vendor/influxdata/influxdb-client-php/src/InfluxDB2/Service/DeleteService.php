<?php
/**
 * DeleteService
 * PHP version 5
 *
 * @category Class
 * @package  InfluxDB2
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * Influx OSS API Service
 *
 * No description provided (generated by Openapi Generator https://github.com/openapitools/openapi-generator)
 *
 * OpenAPI spec version: 2.0.0
 * 
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 3.3.4
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace InfluxDB2\Service;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use InfluxDB2\ApiException;
use InfluxDB2\Configuration;
use InfluxDB2\HeaderSelector;
use InfluxDB2\ObjectSerializer;

/**
 * DeleteService Class Doc Comment
 *
 * @category Class
 * @package  InfluxDB2
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class DeleteService
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @var HeaderSelector
     */
    protected $headerSelector;

    /**
     * @param ClientInterface $client
     * @param Configuration   $config
     * @param HeaderSelector  $selector
     */
    public function __construct(
        ClientInterface $client = null,
        Configuration $config = null,
        HeaderSelector $selector = null
    ) {
        $this->client = $client ?: new Client();
        $this->config = $config ?: new Configuration();
        $this->headerSelector = $selector ?: new HeaderSelector();
    }

    /**
     * @return Configuration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Operation postDelete
     *
     * Delete time series data from InfluxDB
     *
     * @param  \InfluxDB2\Model\DeletePredicateRequest $delete_predicate_request Predicate delete request (required)
     * @param  string $zap_trace_span OpenTracing span context (optional)
     * @param  string $org Specifies the organization to delete data from. (optional)
     * @param  string $bucket Specifies the bucket to delete data from. (optional)
     * @param  string $org_id Specifies the organization ID of the resource. (optional)
     * @param  string $bucket_id Specifies the bucket ID to delete data from. (optional)
     *
     * @throws \InfluxDB2\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return void
     */
    public function postDelete($delete_predicate_request, $zap_trace_span = null, $org = null, $bucket = null, $org_id = null, $bucket_id = null)
    {
        $this->postDeleteWithHttpInfo($delete_predicate_request, $zap_trace_span, $org, $bucket, $org_id, $bucket_id);
    }

    /**
     * Operation postDeleteWithHttpInfo
     *
     * Delete time series data from InfluxDB
     *
     * @param  \InfluxDB2\Model\DeletePredicateRequest $delete_predicate_request Predicate delete request (required)
     * @param  string $zap_trace_span OpenTracing span context (optional)
     * @param  string $org Specifies the organization to delete data from. (optional)
     * @param  string $bucket Specifies the bucket to delete data from. (optional)
     * @param  string $org_id Specifies the organization ID of the resource. (optional)
     * @param  string $bucket_id Specifies the bucket ID to delete data from. (optional)
     *
     * @throws \InfluxDB2\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function postDeleteWithHttpInfo($delete_predicate_request, $zap_trace_span = null, $org = null, $bucket = null, $org_id = null, $bucket_id = null)
    {
        $request = $this->postDeleteRequest($delete_predicate_request, $zap_trace_span, $org, $bucket, $org_id, $bucket_id);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? $e->getResponse()->getBody()->getContents() : null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    $response->getBody()
                );
            }

            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 400:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\InfluxDB2\Model\Error',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 403:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\InfluxDB2\Model\Error',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\InfluxDB2\Model\Error',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\InfluxDB2\Model\Error',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation postDeleteAsync
     *
     * Delete time series data from InfluxDB
     *
     * @param  \InfluxDB2\Model\DeletePredicateRequest $delete_predicate_request Predicate delete request (required)
     * @param  string $zap_trace_span OpenTracing span context (optional)
     * @param  string $org Specifies the organization to delete data from. (optional)
     * @param  string $bucket Specifies the bucket to delete data from. (optional)
     * @param  string $org_id Specifies the organization ID of the resource. (optional)
     * @param  string $bucket_id Specifies the bucket ID to delete data from. (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function postDeleteAsync($delete_predicate_request, $zap_trace_span = null, $org = null, $bucket = null, $org_id = null, $bucket_id = null)
    {
        return $this->postDeleteAsyncWithHttpInfo($delete_predicate_request, $zap_trace_span, $org, $bucket, $org_id, $bucket_id)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation postDeleteAsyncWithHttpInfo
     *
     * Delete time series data from InfluxDB
     *
     * @param  \InfluxDB2\Model\DeletePredicateRequest $delete_predicate_request Predicate delete request (required)
     * @param  string $zap_trace_span OpenTracing span context (optional)
     * @param  string $org Specifies the organization to delete data from. (optional)
     * @param  string $bucket Specifies the bucket to delete data from. (optional)
     * @param  string $org_id Specifies the organization ID of the resource. (optional)
     * @param  string $bucket_id Specifies the bucket ID to delete data from. (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function postDeleteAsyncWithHttpInfo($delete_predicate_request, $zap_trace_span = null, $org = null, $bucket = null, $org_id = null, $bucket_id = null)
    {
        $returnType = '';
        $request = $this->postDeleteRequest($delete_predicate_request, $zap_trace_span, $org, $bucket, $org_id, $bucket_id);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'postDelete'
     *
     * @param  \InfluxDB2\Model\DeletePredicateRequest $delete_predicate_request Predicate delete request (required)
     * @param  string $zap_trace_span OpenTracing span context (optional)
     * @param  string $org Specifies the organization to delete data from. (optional)
     * @param  string $bucket Specifies the bucket to delete data from. (optional)
     * @param  string $org_id Specifies the organization ID of the resource. (optional)
     * @param  string $bucket_id Specifies the bucket ID to delete data from. (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function postDeleteRequest($delete_predicate_request, $zap_trace_span = null, $org = null, $bucket = null, $org_id = null, $bucket_id = null)
    {
        // verify the required parameter 'delete_predicate_request' is set
        if ($delete_predicate_request === null || (is_array($delete_predicate_request) && count($delete_predicate_request) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $delete_predicate_request when calling postDelete'
            );
        }

        $resourcePath = '/api/v2/delete';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // query params
        if ($org !== null) {
            $queryParams['org'] = ObjectSerializer::toQueryValue($org);
        }
        // query params
        if ($bucket !== null) {
            $queryParams['bucket'] = ObjectSerializer::toQueryValue($bucket);
        }
        // query params
        if ($org_id !== null) {
            $queryParams['orgID'] = ObjectSerializer::toQueryValue($org_id);
        }
        // query params
        if ($bucket_id !== null) {
            $queryParams['bucketID'] = ObjectSerializer::toQueryValue($bucket_id);
        }
        // header params
        if ($zap_trace_span !== null) {
            $headerParams['Zap-Trace-Span'] = ObjectSerializer::toHeaderValue($zap_trace_span);
        }


        // body params
        $_tempBody = null;
        if (isset($delete_predicate_request)) {
            $_tempBody = $delete_predicate_request;
        }

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/json']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json'],
                ['application/json']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            if ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode(ObjectSerializer::sanitizeForSerialization($_tempBody));
            } else {
                $httpBody = $_tempBody;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = \GuzzleHttp\Psr7\Query::build($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\Query::build($queryParams);
        return new Request(
            'POST',
            $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Create http client option
     *
     * @throws \RuntimeException on file opening failure
     * @return array of http client options
     */
    protected function createHttpClientOption()
    {
        $options = [];
        if ($this->config->getDebug()) {
            $options[RequestOptions::DEBUG] = fopen($this->config->getDebugFile(), 'a');
            if (!$options[RequestOptions::DEBUG]) {
                throw new \RuntimeException('Failed to open the debug file: ' . $this->config->getDebugFile());
            }
        }

        return $options;
    }
}
