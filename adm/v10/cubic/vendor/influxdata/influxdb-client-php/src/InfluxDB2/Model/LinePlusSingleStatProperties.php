<?php
/**
 * LinePlusSingleStatProperties
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
 * LinePlusSingleStatProperties Class Doc Comment
 *
 * @category Class
 * @package  InfluxDB2
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class LinePlusSingleStatProperties extends ViewProperties 
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'LinePlusSingleStatProperties';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'time_format' => 'string',
        'type' => 'string',
        'queries' => '\InfluxDB2\Model\DashboardQuery[]',
        'colors' => '\InfluxDB2\Model\DashboardColor[]',
        'shape' => 'string',
        'note' => 'string',
        'show_note_when_empty' => 'bool',
        'axes' => '\InfluxDB2\Model\Axes',
        'static_legend' => '\InfluxDB2\Model\StaticLegend',
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
        'shade_below' => 'bool',
        'hover_dimension' => 'string',
        'position' => 'string',
        'prefix' => 'string',
        'suffix' => 'string',
        'decimal_places' => '\InfluxDB2\Model\DecimalPlaces',
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
        'axes' => null,
        'static_legend' => null,
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
        'shade_below' => null,
        'hover_dimension' => null,
        'position' => null,
        'prefix' => null,
        'suffix' => null,
        'decimal_places' => null,
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
        'axes' => 'axes',
        'static_legend' => 'staticLegend',
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
        'shade_below' => 'shadeBelow',
        'hover_dimension' => 'hoverDimension',
        'position' => 'position',
        'prefix' => 'prefix',
        'suffix' => 'suffix',
        'decimal_places' => 'decimalPlaces',
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
        'axes' => 'setAxes',
        'static_legend' => 'setStaticLegend',
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
        'shade_below' => 'setShadeBelow',
        'hover_dimension' => 'setHoverDimension',
        'position' => 'setPosition',
        'prefix' => 'setPrefix',
        'suffix' => 'setSuffix',
        'decimal_places' => 'setDecimalPlaces',
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
        'axes' => 'getAxes',
        'static_legend' => 'getStaticLegend',
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
        'shade_below' => 'getShadeBelow',
        'hover_dimension' => 'getHoverDimension',
        'position' => 'getPosition',
        'prefix' => 'getPrefix',
        'suffix' => 'getSuffix',
        'decimal_places' => 'getDecimalPlaces',
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

    const TYPE_LINE_PLUS_SINGLE_STAT = 'line-plus-single-stat';
    const SHAPE_CHRONOGRAF_V2 = 'chronograf-v2';
    const HOVER_DIMENSION_AUTO = 'auto';
    const HOVER_DIMENSION_X = 'x';
    const HOVER_DIMENSION_Y = 'y';
    const HOVER_DIMENSION_XY = 'xy';
    const POSITION_OVERLAID = 'overlaid';
    const POSITION_STACKED = 'stacked';
    

    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getTypeAllowableValues()
    {
        return [
            self::TYPE_LINE_PLUS_SINGLE_STAT,
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
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getHoverDimensionAllowableValues()
    {
        return [
            self::HOVER_DIMENSION_AUTO,
            self::HOVER_DIMENSION_X,
            self::HOVER_DIMENSION_Y,
            self::HOVER_DIMENSION_XY,
        ];
    }
    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getPositionAllowableValues()
    {
        return [
            self::POSITION_OVERLAID,
            self::POSITION_STACKED,
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
        $this->container['type'] = isset($data['type']) ? $data['type'] : TYPE_LINE_PLUS_SINGLE_STAT;
        $this->container['queries'] = isset($data['queries']) ? $data['queries'] : null;
        $this->container['colors'] = isset($data['colors']) ? $data['colors'] : null;
        $this->container['shape'] = isset($data['shape']) ? $data['shape'] : SHAPE_CHRONOGRAF_V2;
        $this->container['note'] = isset($data['note']) ? $data['note'] : null;
        $this->container['show_note_when_empty'] = isset($data['show_note_when_empty']) ? $data['show_note_when_empty'] : null;
        $this->container['axes'] = isset($data['axes']) ? $data['axes'] : null;
        $this->container['static_legend'] = isset($data['static_legend']) ? $data['static_legend'] : null;
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
        $this->container['shade_below'] = isset($data['shade_below']) ? $data['shade_below'] : null;
        $this->container['hover_dimension'] = isset($data['hover_dimension']) ? $data['hover_dimension'] : null;
        $this->container['position'] = isset($data['position']) ? $data['position'] : null;
        $this->container['prefix'] = isset($data['prefix']) ? $data['prefix'] : null;
        $this->container['suffix'] = isset($data['suffix']) ? $data['suffix'] : null;
        $this->container['decimal_places'] = isset($data['decimal_places']) ? $data['decimal_places'] : null;
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
        if ($this->container['axes'] === null) {
            $invalidProperties[] = "'axes' can't be null";
        }
        $allowedValues = $this->getHoverDimensionAllowableValues();
        if (!is_null($this->container['hover_dimension']) && !in_array($this->container['hover_dimension'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value for 'hover_dimension', must be one of '%s'",
                implode("', '", $allowedValues)
            );
        }

        if ($this->container['position'] === null) {
            $invalidProperties[] = "'position' can't be null";
        }
        $allowedValues = $this->getPositionAllowableValues();
        if (!is_null($this->container['position']) && !in_array($this->container['position'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value for 'position', must be one of '%s'",
                implode("', '", $allowedValues)
            );
        }

        if ($this->container['prefix'] === null) {
            $invalidProperties[] = "'prefix' can't be null";
        }
        if ($this->container['suffix'] === null) {
            $invalidProperties[] = "'suffix' can't be null";
        }
        if ($this->container['decimal_places'] === null) {
            $invalidProperties[] = "'decimal_places' can't be null";
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
     * @return \InfluxDB2\Model\DashboardColor[]
     */
    public function getColors()
    {
        return $this->container['colors'];
    }

    /**
     * Sets colors
     *
     * @param \InfluxDB2\Model\DashboardColor[] $colors Colors define color encoding of data into a visualization
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
     * Gets axes
     *
     * @return \InfluxDB2\Model\Axes
     */
    public function getAxes()
    {
        return $this->container['axes'];
    }

    /**
     * Sets axes
     *
     * @param \InfluxDB2\Model\Axes $axes axes
     *
     * @return $this
     */
    public function setAxes($axes)
    {
        $this->container['axes'] = $axes;

        return $this;
    }

    /**
     * Gets static_legend
     *
     * @return \InfluxDB2\Model\StaticLegend|null
     */
    public function getStaticLegend()
    {
        return $this->container['static_legend'];
    }

    /**
     * Sets static_legend
     *
     * @param \InfluxDB2\Model\StaticLegend|null $static_legend static_legend
     *
     * @return $this
     */
    public function setStaticLegend($static_legend)
    {
        $this->container['static_legend'] = $static_legend;

        return $this;
    }

    /**
     * Gets x_column
     *
     * @return string|null
     */
    public function getXColumn()
    {
        return $this->container['x_column'];
    }

    /**
     * Sets x_column
     *
     * @param string|null $x_column x_column
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
     * @return string|null
     */
    public function getYColumn()
    {
        return $this->container['y_column'];
    }

    /**
     * Sets y_column
     *
     * @param string|null $y_column y_column
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
     * Gets shade_below
     *
     * @return bool|null
     */
    public function getShadeBelow()
    {
        return $this->container['shade_below'];
    }

    /**
     * Sets shade_below
     *
     * @param bool|null $shade_below shade_below
     *
     * @return $this
     */
    public function setShadeBelow($shade_below)
    {
        $this->container['shade_below'] = $shade_below;

        return $this;
    }

    /**
     * Gets hover_dimension
     *
     * @return string|null
     */
    public function getHoverDimension()
    {
        return $this->container['hover_dimension'];
    }

    /**
     * Sets hover_dimension
     *
     * @param string|null $hover_dimension hover_dimension
     *
     * @return $this
     */
    public function setHoverDimension($hover_dimension)
    {
        $allowedValues = $this->getHoverDimensionAllowableValues();
        if (!is_null($hover_dimension) && !in_array($hover_dimension, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'hover_dimension', must be one of '%s'",
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['hover_dimension'] = $hover_dimension;

        return $this;
    }

    /**
     * Gets position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->container['position'];
    }

    /**
     * Sets position
     *
     * @param string $position position
     *
     * @return $this
     */
    public function setPosition($position)
    {
        $allowedValues = $this->getPositionAllowableValues();
        if (!in_array($position, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'position', must be one of '%s'",
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['position'] = $position;

        return $this;
    }

    /**
     * Gets prefix
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->container['prefix'];
    }

    /**
     * Sets prefix
     *
     * @param string $prefix prefix
     *
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->container['prefix'] = $prefix;

        return $this;
    }

    /**
     * Gets suffix
     *
     * @return string
     */
    public function getSuffix()
    {
        return $this->container['suffix'];
    }

    /**
     * Sets suffix
     *
     * @param string $suffix suffix
     *
     * @return $this
     */
    public function setSuffix($suffix)
    {
        $this->container['suffix'] = $suffix;

        return $this;
    }

    /**
     * Gets decimal_places
     *
     * @return \InfluxDB2\Model\DecimalPlaces
     */
    public function getDecimalPlaces()
    {
        return $this->container['decimal_places'];
    }

    /**
     * Sets decimal_places
     *
     * @param \InfluxDB2\Model\DecimalPlaces $decimal_places decimal_places
     *
     * @return $this
     */
    public function setDecimalPlaces($decimal_places)
    {
        $this->container['decimal_places'] = $decimal_places;

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


