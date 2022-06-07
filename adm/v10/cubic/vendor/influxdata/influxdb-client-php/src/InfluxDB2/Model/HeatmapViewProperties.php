<?php
/**
 * HeatmapViewProperties
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
use \InfluxDB2\ObjectSerializer;

/**
 * HeatmapViewProperties Class Doc Comment
 *
 * @category Class
 * @package  InfluxDB2
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class HeatmapViewProperties extends ViewProperties 
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'HeatmapViewProperties';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'time_format' => 'string',
        'type' => 'string',
        'queries' => '\InfluxDB2\Model\DashboardQuery[]',
        'colors' => 'string[]',
        'shape' => 'string',
        'note' => 'string',
        'show_note_when_empty' => 'bool',
        'x_column' => 'string',
        'generate_x_axis_ticks' => 'string[]',
        'x_total_ticks' => 'int',
        'x_tick_start' => 'float',
        'x_tick_step' => 'float',
        'y_column' => 'string',
        'generate_y_axis_ticks' => 'string[]',
        'y_total_ticks' => 'int',
        'y_tick_start' => 'float',
        'y_tick_step' => 'float',
        'x_domain' => 'float[]',
        'y_domain' => 'float[]',
        'x_axis_label' => 'string',
        'y_axis_label' => 'string',
        'x_prefix' => 'string',
        'x_suffix' => 'string',
        'y_prefix' => 'string',
        'y_suffix' => 'string',
        'bin_size' => 'float',
        'legend_colorize_rows' => 'bool',
        'legend_hide' => 'bool',
        'legend_opacity' => 'float',
        'legend_orientation_threshold' => 'int'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPIFormats = [
        'time_format' => null,
        'type' => null,
        'queries' => null,
        'colors' => null,
        'shape' => null,
        'note' => null,
        'show_note_when_empty' => null,
        'x_column' => null,
        'generate_x_axis_ticks' => null,
        'x_total_ticks' => 'int32',
        'x_tick_start' => 'float',
        'x_tick_step' => 'float',
        'y_column' => null,
        'generate_y_axis_ticks' => null,
        'y_total_ticks' => 'int32',
        'y_tick_start' => 'float',
        'y_tick_step' => 'float',
        'x_domain' => null,
        'y_domain' => null,
        'x_axis_label' => null,
        'y_axis_label' => null,
        'x_prefix' => null,
        'x_suffix' => null,
        'y_prefix' => null,
        'y_suffix' => null,
        'bin_size' => null,
        'legend_colorize_rows' => null,
        'legend_hide' => null,
        'legend_opacity' => 'float',
        'legend_orientation_threshold' => 'int32'
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPITypes()
    {
        return self::$openAPITypes + parent::openAPITypes();
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPIFormats()
    {
        return self::$openAPIFormats + parent::openAPIFormats();
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'time_format' => 'timeFormat',
        'type' => 'type',
        'queries' => 'queries',
        'colors' => 'colors',
        'shape' => 'shape',
        'note' => 'note',
        'show_note_when_empty' => 'showNoteWhenEmpty',
        'x_column' => 'xColumn',
        'generate_x_axis_ticks' => 'generateXAxisTicks',
        'x_total_ticks' => 'xTotalTicks',
        'x_tick_start' => 'xTickStart',
        'x_tick_step' => 'xTickStep',
        'y_column' => 'yColumn',
        'generate_y_axis_ticks' => 'generateYAxisTicks',
        'y_total_ticks' => 'yTotalTicks',
        'y_tick_start' => 'yTickStart',
        'y_tick_step' => 'yTickStep',
        'x_domain' => 'xDomain',
        'y_domain' => 'yDomain',
        'x_axis_label' => 'xAxisLabel',
        'y_axis_label' => 'yAxisLabel',
        'x_prefix' => 'xPrefix',
        'x_suffix' => 'xSuffix',
        'y_prefix' => 'yPrefix',
        'y_suffix' => 'ySuffix',
        'bin_size' => 'binSize',
        'legend_colorize_rows' => 'legendColorizeRows',
        'legend_hide' => 'legendHide',
        'legend_opacity' => 'legendOpacity',
        'legend_orientation_threshold' => 'legendOrientationThreshold'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'time_format' => 'setTimeFormat',
        'type' => 'setType',
        'queries' => 'setQueries',
        'colors' => 'setColors',
        'shape' => 'setShape',
        'note' => 'setNote',
        'show_note_when_empty' => 'setShowNoteWhenEmpty',
        'x_column' => 'setXColumn',
        'generate_x_axis_ticks' => 'setGenerateXAxisTicks',
        'x_total_ticks' => 'setXTotalTicks',
        'x_tick_start' => 'setXTickStart',
        'x_tick_step' => 'setXTickStep',
        'y_column' => 'setYColumn',
        'generate_y_axis_ticks' => 'setGenerateYAxisTicks',
        'y_total_ticks' => 'setYTotalTicks',
        'y_tick_start' => 'setYTickStart',
        'y_tick_step' => 'setYTickStep',
        'x_domain' => 'setXDomain',
        'y_domain' => 'setYDomain',
        'x_axis_label' => 'setXAxisLabel',
        'y_axis_label' => 'setYAxisLabel',
        'x_prefix' => 'setXPrefix',
        'x_suffix' => 'setXSuffix',
        'y_prefix' => 'setYPrefix',
        'y_suffix' => 'setYSuffix',
        'bin_size' => 'setBinSize',
        'legend_colorize_rows' => 'setLegendColorizeRows',
        'legend_hide' => 'setLegendHide',
        'legend_opacity' => 'setLegendOpacity',
        'legend_orientation_threshold' => 'setLegendOrientationThreshold'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'time_format' => 'getTimeFormat',
        'type' => 'getType',
        'queries' => 'getQueries',
        'colors' => 'getColors',
        'shape' => 'getShape',
        'note' => 'getNote',
        'show_note_when_empty' => 'getShowNoteWhenEmpty',
        'x_column' => 'getXColumn',
        'generate_x_axis_ticks' => 'getGenerateXAxisTicks',
        'x_total_ticks' => 'getXTotalTicks',
        'x_tick_start' => 'getXTickStart',
        'x_tick_step' => 'getXTickStep',
        'y_column' => 'getYColumn',
        'generate_y_axis_ticks' => 'getGenerateYAxisTicks',
        'y_total_ticks' => 'getYTotalTicks',
        'y_tick_start' => 'getYTickStart',
        'y_tick_step' => 'getYTickStep',
        'x_domain' => 'getXDomain',
        'y_domain' => 'getYDomain',
        'x_axis_label' => 'getXAxisLabel',
        'y_axis_label' => 'getYAxisLabel',
        'x_prefix' => 'getXPrefix',
        'x_suffix' => 'getXSuffix',
        'y_prefix' => 'getYPrefix',
        'y_suffix' => 'getYSuffix',
        'bin_size' => 'getBinSize',
        'legend_colorize_rows' => 'getLegendColorizeRows',
        'legend_hide' => 'getLegendHide',
        'legend_opacity' => 'getLegendOpacity',
        'legend_orientation_threshold' => 'getLegendOrientationThreshold'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return parent::attributeMap() + self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return parent::setters() + self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return parent::getters() + self::$getters;
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

    const TYPE_HEATMAP = 'heatmap';
    const SHAPE_CHRONOGRAF_V2 = 'chronograf-v2';
    

    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getTypeAllowableValues()
    {
        return [
            self::TYPE_HEATMAP,
        ];
    }
    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getShapeAllowableValues()
    {
        return [
            self::SHAPE_CHRONOGRAF_V2,
        ];
    }
    


    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        parent::__construct($data);

        $this->container['time_format'] = isset($data['time_format']) ? $data['time_format'] : null;
        $this->container['type'] = isset($data['type']) ? $data['type'] : TYPE_HEATMAP;
        $this->container['queries'] = isset($data['queries']) ? $data['queries'] : null;
        $this->container['colors'] = isset($data['colors']) ? $data['colors'] : null;
        $this->container['shape'] = isset($data['shape']) ? $data['shape'] : SHAPE_CHRONOGRAF_V2;
        $this->container['note'] = isset($data['note']) ? $data['note'] : null;
        $this->container['show_note_when_empty'] = isset($data['show_note_when_empty']) ? $data['show_note_when_empty'] : null;
        $this->container['x_column'] = isset($data['x_column']) ? $data['x_column'] : null;
        $this->container['generate_x_axis_ticks'] = isset($data['generate_x_axis_ticks']) ? $data['generate_x_axis_ticks'] : null;
        $this->container['x_total_ticks'] = isset($data['x_total_ticks']) ? $data['x_total_ticks'] : null;
        $this->container['x_tick_start'] = isset($data['x_tick_start']) ? $data['x_tick_start'] : null;
        $this->container['x_tick_step'] = isset($data['x_tick_step']) ? $data['x_tick_step'] : null;
        $this->container['y_column'] = isset($data['y_column']) ? $data['y_column'] : null;
        $this->container['generate_y_axis_ticks'] = isset($data['generate_y_axis_ticks']) ? $data['generate_y_axis_ticks'] : null;
        $this->container['y_total_ticks'] = isset($data['y_total_ticks']) ? $data['y_total_ticks'] : null;
        $this->container['y_tick_start'] = isset($data['y_tick_start']) ? $data['y_tick_start'] : null;
        $this->container['y_tick_step'] = isset($data['y_tick_step']) ? $data['y_tick_step'] : null;
        $this->container['x_domain'] = isset($data['x_domain']) ? $data['x_domain'] : null;
        $this->container['y_domain'] = isset($data['y_domain']) ? $data['y_domain'] : null;
        $this->container['x_axis_label'] = isset($data['x_axis_label']) ? $data['x_axis_label'] : null;
        $this->container['y_axis_label'] = isset($data['y_axis_label']) ? $data['y_axis_label'] : null;
        $this->container['x_prefix'] = isset($data['x_prefix']) ? $data['x_prefix'] : null;
        $this->container['x_suffix'] = isset($data['x_suffix']) ? $data['x_suffix'] : null;
        $this->container['y_prefix'] = isset($data['y_prefix']) ? $data['y_prefix'] : null;
        $this->container['y_suffix'] = isset($data['y_suffix']) ? $data['y_suffix'] : null;
        $this->container['bin_size'] = isset($data['bin_size']) ? $data['bin_size'] : null;
        $this->container['legend_colorize_rows'] = isset($data['legend_colorize_rows']) ? $data['legend_colorize_rows'] : null;
        $this->container['legend_hide'] = isset($data['legend_hide']) ? $data['legend_hide'] : null;
        $this->container['legend_opacity'] = isset($data['legend_opacity']) ? $data['legend_opacity'] : null;
        $this->container['legend_orientation_threshold'] = isset($data['legend_orientation_threshold']) ? $data['legend_orientation_threshold'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = parent::listInvalidProperties();

        if ($this->container['type'] === null) {
            $invalidProperties[] = "'type' can't be null";
        }
        $allowedValues = $this->getTypeAllowableValues();
        if (!is_null($this->container['type']) && !in_array($this->container['type'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value for 'type', must be one of '%s'",
                implode("', '", $allowedValues)
            );
        }

        if ($this->container['queries'] === null) {
            $invalidProperties[] = "'queries' can't be null";
        }
        if ($this->container['colors'] === null) {
            $invalidProperties[] = "'colors' can't be null";
        }
        if ($this->container['shape'] === null) {
            $invalidProperties[] = "'shape' can't be null";
        }
        $allowedValues = $this->getShapeAllowableValues();
        if (!is_null($this->container['shape']) && !in_array($this->container['shape'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value for 'shape', must be one of '%s'",
                implode("', '", $allowedValues)
            );
        }

        if ($this->container['note'] === null) {
            $invalidProperties[] = "'note' can't be null";
        }
        if ($this->container['show_note_when_empty'] === null) {
            $invalidProperties[] = "'show_note_when_empty' can't be null";
        }
        if ($this->container['x_column'] === null) {
            $invalidProperties[] = "'x_column' can't be null";
        }
        if ($this->container['y_column'] === null) {
            $invalidProperties[] = "'y_column' can't be null";
        }
        if ($this->container['x_domain'] === null) {
            $invalidProperties[] = "'x_domain' can't be null";
        }
        if ($this->container['y_domain'] === null) {
            $invalidProperties[] = "'y_domain' can't be null";
        }
        if ($this->container['x_axis_label'] === null) {
            $invalidProperties[] = "'x_axis_label' can't be null";
        }
        if ($this->container['y_axis_label'] === null) {
            $invalidProperties[] = "'y_axis_label' can't be null";
        }
        if ($this->container['x_prefix'] === null) {
            $invalidProperties[] = "'x_prefix' can't be null";
        }
        if ($this->container['x_suffix'] === null) {
            $invalidProperties[] = "'x_suffix' can't be null";
        }
        if ($this->container['y_prefix'] === null) {
            $invalidProperties[] = "'y_prefix' can't be null";
        }
        if ($this->container['y_suffix'] === null) {
            $invalidProperties[] = "'y_suffix' can't be null";
        }
        if ($this->container['bin_size'] === null) {
            $invalidProperties[] = "'bin_size' can't be null";
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
     * Gets time_format
     *
     * @return string|null
     */
    public function getTimeFormat()
    {
        return $this->container['time_format'];
    }

    /**
     * Sets time_format
     *
     * @param string|null $time_format time_format
     *
     * @return $this
     */
    public function setTimeFormat($time_format)
    {
        $this->container['time_format'] = $time_format;

        return $this;
    }

    /**
     * Gets type
     *
     * @return string
     */
    public function getType()
    {
        return $this->container['type'];
    }

    /**
     * Sets type
     *
     * @param string $type type
     *
     * @return $this
     */
    public function setType($type)
    {
        $allowedValues = $this->getTypeAllowableValues();
        if (!in_array($type, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'type', must be one of '%s'",
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['type'] = $type;

        return $this;
    }

    /**
     * Gets queries
     *
     * @return \InfluxDB2\Model\DashboardQuery[]
     */
    public function getQueries()
    {
        return $this->container['queries'];
    }

    /**
     * Sets queries
     *
     * @param \InfluxDB2\Model\DashboardQuery[] $queries queries
     *
     * @return $this
     */
    public function setQueries($queries)
    {
        $this->container['queries'] = $queries;

        return $this;
    }

    /**
     * Gets colors
     *
     * @return string[]
     */
    public function getColors()
    {
        return $this->container['colors'];
    }

    /**
     * Sets colors
     *
     * @param string[] $colors Colors define color encoding of data into a visualization
     *
     * @return $this
     */
    public function setColors($colors)
    {
        $this->container['colors'] = $colors;

        return $this;
    }

    /**
     * Gets shape
     *
     * @return string
     */
    public function getShape()
    {
        return $this->container['shape'];
    }

    /**
     * Sets shape
     *
     * @param string $shape shape
     *
     * @return $this
     */
    public function setShape($shape)
    {
        $allowedValues = $this->getShapeAllowableValues();
        if (!in_array($shape, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'shape', must be one of '%s'",
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['shape'] = $shape;

        return $this;
    }

    /**
     * Gets note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->container['note'];
    }

    /**
     * Sets note
     *
     * @param string $note note
     *
     * @return $this
     */
    public function setNote($note)
    {
        $this->container['note'] = $note;

        return $this;
    }

    /**
     * Gets show_note_when_empty
     *
     * @return bool
     */
    public function getShowNoteWhenEmpty()
    {
        return $this->container['show_note_when_empty'];
    }

    /**
     * Sets show_note_when_empty
     *
     * @param bool $show_note_when_empty If true, will display note when empty
     *
     * @return $this
     */
    public function setShowNoteWhenEmpty($show_note_when_empty)
    {
        $this->container['show_note_when_empty'] = $show_note_when_empty;

        return $this;
    }

    /**
     * Gets x_column
     *
     * @return string
     */
    public function getXColumn()
    {
        return $this->container['x_column'];
    }

    /**
     * Sets x_column
     *
     * @param string $x_column x_column
     *
     * @return $this
     */
    public function setXColumn($x_column)
    {
        $this->container['x_column'] = $x_column;

        return $this;
    }

    /**
     * Gets generate_x_axis_ticks
     *
     * @return string[]|null
     */
    public function getGenerateXAxisTicks()
    {
        return $this->container['generate_x_axis_ticks'];
    }

    /**
     * Sets generate_x_axis_ticks
     *
     * @param string[]|null $generate_x_axis_ticks generate_x_axis_ticks
     *
     * @return $this
     */
    public function setGenerateXAxisTicks($generate_x_axis_ticks)
    {
        $this->container['generate_x_axis_ticks'] = $generate_x_axis_ticks;

        return $this;
    }

    /**
     * Gets x_total_ticks
     *
     * @return int|null
     */
    public function getXTotalTicks()
    {
        return $this->container['x_total_ticks'];
    }

    /**
     * Sets x_total_ticks
     *
     * @param int|null $x_total_ticks x_total_ticks
     *
     * @return $this
     */
    public function setXTotalTicks($x_total_ticks)
    {
        $this->container['x_total_ticks'] = $x_total_ticks;

        return $this;
    }

    /**
     * Gets x_tick_start
     *
     * @return float|null
     */
    public function getXTickStart()
    {
        return $this->container['x_tick_start'];
    }

    /**
     * Sets x_tick_start
     *
     * @param float|null $x_tick_start x_tick_start
     *
     * @return $this
     */
    public function setXTickStart($x_tick_start)
    {
        $this->container['x_tick_start'] = $x_tick_start;

        return $this;
    }

    /**
     * Gets x_tick_step
     *
     * @return float|null
     */
    public function getXTickStep()
    {
        return $this->container['x_tick_step'];
    }

    /**
     * Sets x_tick_step
     *
     * @param float|null $x_tick_step x_tick_step
     *
     * @return $this
     */
    public function setXTickStep($x_tick_step)
    {
        $this->container['x_tick_step'] = $x_tick_step;

        return $this;
    }

    /**
     * Gets y_column
     *
     * @return string
     */
    public function getYColumn()
    {
        return $this->container['y_column'];
    }

    /**
     * Sets y_column
     *
     * @param string $y_column y_column
     *
     * @return $this
     */
    public function setYColumn($y_column)
    {
        $this->container['y_column'] = $y_column;

        return $this;
    }

    /**
     * Gets generate_y_axis_ticks
     *
     * @return string[]|null
     */
    public function getGenerateYAxisTicks()
    {
        return $this->container['generate_y_axis_ticks'];
    }

    /**
     * Sets generate_y_axis_ticks
     *
     * @param string[]|null $generate_y_axis_ticks generate_y_axis_ticks
     *
     * @return $this
     */
    public function setGenerateYAxisTicks($generate_y_axis_ticks)
    {
        $this->container['generate_y_axis_ticks'] = $generate_y_axis_ticks;

        return $this;
    }

    /**
     * Gets y_total_ticks
     *
     * @return int|null
     */
    public function getYTotalTicks()
    {
        return $this->container['y_total_ticks'];
    }

    /**
     * Sets y_total_ticks
     *
     * @param int|null $y_total_ticks y_total_ticks
     *
     * @return $this
     */
    public function setYTotalTicks($y_total_ticks)
    {
        $this->container['y_total_ticks'] = $y_total_ticks;

        return $this;
    }

    /**
     * Gets y_tick_start
     *
     * @return float|null
     */
    public function getYTickStart()
    {
        return $this->container['y_tick_start'];
    }

    /**
     * Sets y_tick_start
     *
     * @param float|null $y_tick_start y_tick_start
     *
     * @return $this
     */
    public function setYTickStart($y_tick_start)
    {
        $this->container['y_tick_start'] = $y_tick_start;

        return $this;
    }

    /**
     * Gets y_tick_step
     *
     * @return float|null
     */
    public function getYTickStep()
    {
        return $this->container['y_tick_step'];
    }

    /**
     * Sets y_tick_step
     *
     * @param float|null $y_tick_step y_tick_step
     *
     * @return $this
     */
    public function setYTickStep($y_tick_step)
    {
        $this->container['y_tick_step'] = $y_tick_step;

        return $this;
    }

    /**
     * Gets x_domain
     *
     * @return float[]
     */
    public function getXDomain()
    {
        return $this->container['x_domain'];
    }

    /**
     * Sets x_domain
     *
     * @param float[] $x_domain x_domain
     *
     * @return $this
     */
    public function setXDomain($x_domain)
    {
        $this->container['x_domain'] = $x_domain;

        return $this;
    }

    /**
     * Gets y_domain
     *
     * @return float[]
     */
    public function getYDomain()
    {
        return $this->container['y_domain'];
    }

    /**
     * Sets y_domain
     *
     * @param float[] $y_domain y_domain
     *
     * @return $this
     */
    public function setYDomain($y_domain)
    {
        $this->container['y_domain'] = $y_domain;

        return $this;
    }

    /**
     * Gets x_axis_label
     *
     * @return string
     */
    public function getXAxisLabel()
    {
        return $this->container['x_axis_label'];
    }

    /**
     * Sets x_axis_label
     *
     * @param string $x_axis_label x_axis_label
     *
     * @return $this
     */
    public function setXAxisLabel($x_axis_label)
    {
        $this->container['x_axis_label'] = $x_axis_label;

        return $this;
    }

    /**
     * Gets y_axis_label
     *
     * @return string
     */
    public function getYAxisLabel()
    {
        return $this->container['y_axis_label'];
    }

    /**
     * Sets y_axis_label
     *
     * @param string $y_axis_label y_axis_label
     *
     * @return $this
     */
    public function setYAxisLabel($y_axis_label)
    {
        $this->container['y_axis_label'] = $y_axis_label;

        return $this;
    }

    /**
     * Gets x_prefix
     *
     * @return string
     */
    public function getXPrefix()
    {
        return $this->container['x_prefix'];
    }

    /**
     * Sets x_prefix
     *
     * @param string $x_prefix x_prefix
     *
     * @return $this
     */
    public function setXPrefix($x_prefix)
    {
        $this->container['x_prefix'] = $x_prefix;

        return $this;
    }

    /**
     * Gets x_suffix
     *
     * @return string
     */
    public function getXSuffix()
    {
        return $this->container['x_suffix'];
    }

    /**
     * Sets x_suffix
     *
     * @param string $x_suffix x_suffix
     *
     * @return $this
     */
    public function setXSuffix($x_suffix)
    {
        $this->container['x_suffix'] = $x_suffix;

        return $this;
    }

    /**
     * Gets y_prefix
     *
     * @return string
     */
    public function getYPrefix()
    {
        return $this->container['y_prefix'];
    }

    /**
     * Sets y_prefix
     *
     * @param string $y_prefix y_prefix
     *
     * @return $this
     */
    public function setYPrefix($y_prefix)
    {
        $this->container['y_prefix'] = $y_prefix;

        return $this;
    }

    /**
     * Gets y_suffix
     *
     * @return string
     */
    public function getYSuffix()
    {
        return $this->container['y_suffix'];
    }

    /**
     * Sets y_suffix
     *
     * @param string $y_suffix y_suffix
     *
     * @return $this
     */
    public function setYSuffix($y_suffix)
    {
        $this->container['y_suffix'] = $y_suffix;

        return $this;
    }

    /**
     * Gets bin_size
     *
     * @return float
     */
    public function getBinSize()
    {
        return $this->container['bin_size'];
    }

    /**
     * Sets bin_size
     *
     * @param float $bin_size bin_size
     *
     * @return $this
     */
    public function setBinSize($bin_size)
    {
        $this->container['bin_size'] = $bin_size;

        return $this;
    }

    /**
     * Gets legend_colorize_rows
     *
     * @return bool|null
     */
    public function getLegendColorizeRows()
    {
        return $this->container['legend_colorize_rows'];
    }

    /**
     * Sets legend_colorize_rows
     *
     * @param bool|null $legend_colorize_rows legend_colorize_rows
     *
     * @return $this
     */
    public function setLegendColorizeRows($legend_colorize_rows)
    {
        $this->container['legend_colorize_rows'] = $legend_colorize_rows;

        return $this;
    }

    /**
     * Gets legend_hide
     *
     * @return bool|null
     */
    public function getLegendHide()
    {
        return $this->container['legend_hide'];
    }

    /**
     * Sets legend_hide
     *
     * @param bool|null $legend_hide legend_hide
     *
     * @return $this
     */
    public function setLegendHide($legend_hide)
    {
        $this->container['legend_hide'] = $legend_hide;

        return $this;
    }

    /**
     * Gets legend_opacity
     *
     * @return float|null
     */
    public function getLegendOpacity()
    {
        return $this->container['legend_opacity'];
    }

    /**
     * Sets legend_opacity
     *
     * @param float|null $legend_opacity legend_opacity
     *
     * @return $this
     */
    public function setLegendOpacity($legend_opacity)
    {
        $this->container['legend_opacity'] = $legend_opacity;

        return $this;
    }

    /**
     * Gets legend_orientation_threshold
     *
     * @return int|null
     */
    public function getLegendOrientationThreshold()
    {
        return $this->container['legend_orientation_threshold'];
    }

    /**
     * Sets legend_orientation_threshold
     *
     * @param int|null $legend_orientation_threshold legend_orientation_threshold
     *
     * @return $this
     */
    public function setLegendOrientationThreshold($legend_orientation_threshold)
    {
        $this->container['legend_orientation_threshold'] = $legend_orientation_threshold;

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


