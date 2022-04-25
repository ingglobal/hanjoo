<?php
/**
 * BucketMetadataManifest
 *
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

namespace InfluxDB2\Model;

use \ArrayAccess;
use \InfluxDB2\ObjectSerializer;

/**
 * BucketMetadataManifest Class Doc Comment
 *
 * @category Class
 * @package  InfluxDB2
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class BucketMetadataManifest implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'BucketMetadataManifest';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'organization_id' => 'string',
        'organization_name' => 'string',
        'bucket_id' => 'string',
        'bucket_name' => 'string',
        'description' => 'string',
        'default_retention_policy' => 'string',
        'retention_policies' => '\InfluxDB2\Model\RetentionPolicyManifest[]'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPIFormats = [
        'organization_id' => null,
        'organization_name' => null,
        'bucket_id' => null,
        'bucket_name' => null,
        'description' => null,
        'default_retention_policy' => null,
        'retention_policies' => null
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPITypes()
    {
        return self::$openAPITypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPIFormats()
    {
        return self::$openAPIFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'organization_id' => 'organizationID',
        'organization_name' => 'organizationName',
        'bucket_id' => 'bucketID',
        'bucket_name' => 'bucketName',
        'description' => 'description',
        'default_retention_policy' => 'defaultRetentionPolicy',
        'retention_policies' => 'retentionPolicies'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'organization_id' => 'setOrganizationId',
        'organization_name' => 'setOrganizationName',
        'bucket_id' => 'setBucketId',
        'bucket_name' => 'setBucketName',
        'description' => 'setDescription',
        'default_retention_policy' => 'setDefaultRetentionPolicy',
        'retention_policies' => 'setRetentionPolicies'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'organization_id' => 'getOrganizationId',
        'organization_name' => 'getOrganizationName',
        'bucket_id' => 'getBucketId',
        'bucket_name' => 'getBucketName',
        'description' => 'getDescription',
        'default_retention_policy' => 'getDefaultRetentionPolicy',
        'retention_policies' => 'getRetentionPolicies'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$openAPIModelName;
    }

    

    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['organization_id'] = isset($data['organization_id']) ? $data['organization_id'] : null;
        $this->container['organization_name'] = isset($data['organization_name']) ? $data['organization_name'] : null;
        $this->container['bucket_id'] = isset($data['bucket_id']) ? $data['bucket_id'] : null;
        $this->container['bucket_name'] = isset($data['bucket_name']) ? $data['bucket_name'] : null;
        $this->container['description'] = isset($data['description']) ? $data['description'] : null;
        $this->container['default_retention_policy'] = isset($data['default_retention_policy']) ? $data['default_retention_policy'] : null;
        $this->container['retention_policies'] = isset($data['retention_policies']) ? $data['retention_policies'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['organization_id'] === null) {
            $invalidProperties[] = "'organization_id' can't be null";
        }
        if ($this->container['organization_name'] === null) {
            $invalidProperties[] = "'organization_name' can't be null";
        }
        if ($this->container['bucket_id'] === null) {
            $invalidProperties[] = "'bucket_id' can't be null";
        }
        if ($this->container['bucket_name'] === null) {
            $invalidProperties[] = "'bucket_name' can't be null";
        }
        if ($this->container['default_retention_policy'] === null) {
            $invalidProperties[] = "'default_retention_policy' can't be null";
        }
        if ($this->container['retention_policies'] === null) {
            $invalidProperties[] = "'retention_policies' can't be null";
        }
        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets organization_id
     *
     * @return string
     */
    public function getOrganizationId()
    {
        return $this->container['organization_id'];
    }

    /**
     * Sets organization_id
     *
     * @param string $organization_id organization_id
     *
     * @return $this
     */
    public function setOrganizationId($organization_id)
    {
        $this->container['organization_id'] = $organization_id;

        return $this;
    }

    /**
     * Gets organization_name
     *
     * @return string
     */
    public function getOrganizationName()
    {
        return $this->container['organization_name'];
    }

    /**
     * Sets organization_name
     *
     * @param string $organization_name organization_name
     *
     * @return $this
     */
    public function setOrganizationName($organization_name)
    {
        $this->container['organization_name'] = $organization_name;

        return $this;
    }

    /**
     * Gets bucket_id
     *
     * @return string
     */
    public function getBucketId()
    {
        return $this->container['bucket_id'];
    }

    /**
     * Sets bucket_id
     *
     * @param string $bucket_id bucket_id
     *
     * @return $this
     */
    public function setBucketId($bucket_id)
    {
        $this->container['bucket_id'] = $bucket_id;

        return $this;
    }

    /**
     * Gets bucket_name
     *
     * @return string
     */
    public function getBucketName()
    {
        return $this->container['bucket_name'];
    }

    /**
     * Sets bucket_name
     *
     * @param string $bucket_name bucket_name
     *
     * @return $this
     */
    public function setBucketName($bucket_name)
    {
        $this->container['bucket_name'] = $bucket_name;

        return $this;
    }

    /**
     * Gets description
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->container['description'];
    }

    /**
     * Sets description
     *
     * @param string|null $description description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->container['description'] = $description;

        return $this;
    }

    /**
     * Gets default_retention_policy
     *
     * @return string
     */
    public function getDefaultRetentionPolicy()
    {
        return $this->container['default_retention_policy'];
    }

    /**
     * Sets default_retention_policy
     *
     * @param string $default_retention_policy default_retention_policy
     *
     * @return $this
     */
    public function setDefaultRetentionPolicy($default_retention_policy)
    {
        $this->container['default_retention_policy'] = $default_retention_policy;

        return $this;
    }

    /**
     * Gets retention_policies
     *
     * @return \InfluxDB2\Model\RetentionPolicyManifest[]
     */
    public function getRetentionPolicies()
    {
        return $this->container['retention_policies'];
    }

    /**
     * Sets retention_policies
     *
     * @param \InfluxDB2\Model\RetentionPolicyManifest[] $retention_policies retention_policies
     *
     * @return $this
     */
    public function setRetentionPolicies($retention_policies)
    {
        $this->container['retention_policies'] = $retention_policies;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset): bool
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param integer $offset Offset
     * @param mixed   $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode(
            ObjectSerializer::sanitizeForSerialization($this),
            JSON_PRETTY_PRINT
        );
    }
}


