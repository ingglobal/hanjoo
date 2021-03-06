<?php
/**
 * ViewsService
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
 * ViewsService Class Doc Comment
 *
 * @category Class
 * @package  InfluxDB2
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class ViewsService
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
     * Operation getDashboardsIDCellsIDView
     *
     * Retrieve the view for a cell
     *
     * @param  string $dashboard_id The dashboard ID. (required)
     * @param  string $cell_id The cell ID. (required)
     * @param  string $zap_trace_span OpenTracing span context (optional)
     *
     * @throws \InfluxDB2\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \InfluxDB2\Model\View|\InfluxDB2\Model\Error|\InfluxDB2\Model\Error
     */
    public function getDashboardsIDCellsIDView($dashboard_id, $cell_id, $zap_trace_span = null)
    {
        list($response) = $this->getDashboardsIDCellsIDViewWithHttpInfo($dashboard_id, $cell_id, $zap_trace_span);
        return $response;
    }

    /**
     * Operation getDashboardsIDCellsIDViewWithHttpInfo
     *
     * Retrieve the view for a cell
     *
     * @param  string $dashboard_id The dashboard ID. (required)
     * @param  string $cell_id The cell ID. (required)
     * @param  string $zap_trace_span OpenTracing span context (optional)
     *
     * @throws \InfluxDB2\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \InfluxDB2\Model\View|\InfluxDB2\Model\Error|\InfluxDB2\Model\Error, HTTP status code, HTTP response headers (array of strings)
     */
    public function getDashboardsIDCellsIDViewWithHttpInfo($dashboard_id, $cell_id, $zap_trace_span = null)
    {
        $request = $this->getDashboardsIDCellsIDViewRequest($dashboard_id, $cell_id, $zap_trace_span);

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

            $responseBody = $response->getBody();
            switch($statusCode) {
                case 200:
                    if ('\InfluxDB2\Model\View' === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\InfluxDB2\Model\View', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                case 404:
                    if ('\InfluxDB2\Model\Error' === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\InfluxDB2\Model\Error', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                default:
                    if ('\InfluxDB2\Model\Error' === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\InfluxDB2\Model\Error', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\InfluxDB2\Model\View';
            $responseBody = $response->getBody();
            if ($returnType === '\SplFileObject') {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\InfluxDB2\Model\View',
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
     * Operation getDashboardsIDCellsIDViewAsync
     *
     * Retrieve the view for a cell
     *
     * @param  string $dashboard_id The dashboard ID. (required)
     * @param  string $cell_id The cell ID. (required)
     * @param  string $zap_trace_span OpenTracing span context (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getDashboardsIDCellsIDViewAsync($dashboard_id, $cell_id, $zap_trace_span = null)
    {
        return $this->getDashboardsIDCellsIDViewAsyncWithHttpInfo($dashboard_id, $cell_id, $zap_trace_span)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation getDashboardsIDCellsIDViewAsyncWithHttpInfo
     *
     * Retrieve the view for a cell
     *
     * @param  string $dashboard_id The dashboard ID. (required)
     * @param  string $cell_id The cell ID. (required)
     * @param  string $zap_trace_span OpenTracing span context (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getDashboardsIDCellsIDViewAsyncWithHttpInfo($dashboard_id, $cell_id, $zap_trace_span = null)
    {
        $returnType = '\InfluxDB2\Model\View';
        $request = $this->getDashboardsIDCellsIDViewRequest($dashboard_id, $cell_id, $zap_trace_span);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
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
     * Create request for operation 'getDashboardsIDCellsIDView'
     *
     * @param  string $dashboard_id The dashboard ID. (required)
     * @param  string $cell_id The cell ID. (required)
     * @param  string $zap_trace_span OpenTracing span context (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function getDashboardsIDCellsIDViewRequest($dashboard_id, $cell_id, $zap_trace_span = null)
    {
        // verify the required parameter 'dashboard_id' is set
        if ($dashboard_id === null || (is_array($dashboard_id) && count($dashboard_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $dashboard_id when calling getDashboardsIDCellsIDView'
            );
        }
        // verify the required parameter 'cell_id' is set
        if ($cell_id === null || (is_array($cell_id) && count($cell_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $cell_id when calling getDashboardsIDCellsIDView'
            );
        }

        $resourcePath = '/api/v2/dashboards/{dashboardID}/cells/{cellID}/view';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // header params
        if ($zap_trace_span !== null) {
            $headerParams['Zap-Trace-Span'] = ObjectSerializer::toHeaderValue($zap_trace_span);
        }

        // path params
        if ($dashboard_id !== null) {
            $resourcePath = str_replace(
                '{' . 'dashboardID' . '}',
                ObjectSerializer::toPathValue($dashboard_id),
                $resourcePath
            );
        }
        // path params
        if ($cell_id !== null) {
            $resourcePath = str_replace(
                '{' . 'cellID' . '}',
                ObjectSerializer::toPathValue($cell_id),
                $resourcePath
            );
        }

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/json']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json'],
                []
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
            'GET',
            $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation patchDashboardsIDCellsIDView
     *
     * Update the view for a cell
     *
     * @param  string $dashboard_id The ID of the dashboard to update. (required)
     * @param  string $cell_id The ID of the cell to update. (required)
     * @param  \InfluxDB2\Model\View $view view (required)
     * @param  string $zap_trace_span OpenTracing span context (optional)
     *
     * @throws \InfluxDB2\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \InfluxDB2\Model\View|\InfluxDB2\Model\Error|\InfluxDB2\Model\Error
     */
    public function patchDashboardsIDCellsIDView($dashboard_id, $cell_id, $view, $zap_trace_span = null)
    {
        list($response) = $this->patchDashboardsIDCellsIDViewWithHttpInfo($dashboard_id, $cell_id, $view, $zap_trace_span);
        return $response;
    }

    /**
     * Operation patchDashboardsIDCellsIDViewWithHttpInfo
     *
     * Update the view for a cell
     *
     * @param  string $dashboard_id The ID of the dashboard to update. (required)
     * @param  string $cell_id The ID of the cell to update. (required)
     * @param  \InfluxDB2\Model\View $view (required)
     * @param  string $zap_trace_span OpenTracing span context (optional)
     *
     * @throws \InfluxDB2\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \InfluxDB2\Model\View|\InfluxDB2\Model\Error|\InfluxDB2\Model\Error, HTTP status code, HTTP response headers (array of strings)
     */
    public function patchDashboardsIDCellsIDViewWithHttpInfo($dashboard_id, $cell_id, $view, $zap_trace_span = null)
    {
        $request = $this->patchDashboardsIDCellsIDViewRequest($dashboard_id, $cell_id, $view, $zap_trace_span);

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

            $responseBody = $response->getBody();
            switch($statusCode) {
                case 200:
                    if ('\InfluxDB2\Model\View' === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\InfluxDB2\Model\View', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                case 404:
                    if ('\InfluxDB2\Model\Error' === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\InfluxDB2\Model\Error', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                default:
                    if ('\InfluxDB2\Model\Error' === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\InfluxDB2\Model\Error', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\InfluxDB2\Model\View';
            $responseBody = $response->getBody();
            if ($returnType === '\SplFileObject') {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\InfluxDB2\Model\View',
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
     * Operation patchDashboardsIDCellsIDViewAsync
     *
     * Update the view for a cell
     *
     * @param  string $dashboard_id The ID of the dashboard to update. (required)
     * @param  string $cell_id The ID of the cell to update. (required)
     * @param  \InfluxDB2\Model\View $view (required)
     * @param  string $zap_trace_span OpenTracing span context (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function patchDashboardsIDCellsIDViewAsync($dashboard_id, $cell_id, $view, $zap_trace_span = null)
    {
        return $this->patchDashboardsIDCellsIDViewAsyncWithHttpInfo($dashboard_id, $cell_id, $view, $zap_trace_span)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation patchDashboardsIDCellsIDViewAsyncWithHttpInfo
     *
     * Update the view for a cell
     *
     * @param  string $dashboard_id The ID of the dashboard to update. (required)
     * @param  string $cell_id The ID of the cell to update. (required)
     * @param  \InfluxDB2\Model\View $view (required)
     * @param  string $zap_trace_span OpenTracing span context (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function patchDashboardsIDCellsIDViewAsyncWithHttpInfo($dashboard_id, $cell_id, $view, $zap_trace_span = null)
    {
        $returnType = '\InfluxDB2\Model\View';
        $request = $this->patchDashboardsIDCellsIDViewRequest($dashboard_id, $cell_id, $view, $zap_trace_span);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
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
     * Create request for operation 'patchDashboardsIDCellsIDView'
     *
     * @param  string $dashboard_id The ID of the dashboard to update. (required)
     * @param  string $cell_id The ID of the cell to update. (required)
     * @param  \InfluxDB2\Model\View $view (required)
     * @param  string $zap_trace_span OpenTracing span context (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function patchDashboardsIDCellsIDViewRequest($dashboard_id, $cell_id, $view, $zap_trace_span = null)
    {
        // verify the required parameter 'dashboard_id' is set
        if ($dashboard_id === null || (is_array($dashboard_id) && count($dashboard_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $dashboard_id when calling patchDashboardsIDCellsIDView'
            );
        }
        // verify the required parameter 'cell_id' is set
        if ($cell_id === null || (is_array($cell_id) && count($cell_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $cell_id when calling patchDashboardsIDCellsIDView'
            );
        }
        // verify the required parameter 'view' is set
        if ($view === null || (is_array($view) && count($view) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $view when calling patchDashboardsIDCellsIDView'
            );
        }

        $resourcePath = '/api/v2/dashboards/{dashboardID}/cells/{cellID}/view';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // header params
        if ($zap_trace_span !== null) {
            $headerParams['Zap-Trace-Span'] = ObjectSerializer::toHeaderValue($zap_trace_span);
        }

        // path params
        if ($dashboard_id !== null) {
            $resourcePath = str_replace(
                '{' . 'dashboardID' . '}',
                ObjectSerializer::toPathValue($dashboard_id),
                $resourcePath
            );
        }
        // path params
        if ($cell_id !== null) {
            $resourcePath = str_replace(
                '{' . 'cellID' . '}',
                ObjectSerializer::toPathValue($cell_id),
                $resourcePath
            );
        }

        // body params
        $_tempBody = null;
        if (isset($view)) {
            $_tempBody = $view;
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
            'PATCH',
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
