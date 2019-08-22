<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/talent/v4beta1/common.proto

namespace Google\Cloud\Talent\V4beta1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Device information collected from the job seeker, candidate, or
 * other entity conducting the job search. Providing this information improves
 * the quality of the search results across devices.
 *
 * Generated from protobuf message <code>google.cloud.talent.v4beta1.DeviceInfo</code>
 */
class DeviceInfo extends \Google\Protobuf\Internal\Message
{
    /**
     * Optional.
     * Type of the device.
     *
     * Generated from protobuf field <code>.google.cloud.talent.v4beta1.DeviceInfo.DeviceType device_type = 1;</code>
     */
    private $device_type = 0;
    /**
     * Optional.
     * A device-specific ID. The ID must be a unique identifier that
     * distinguishes the device from other devices.
     *
     * Generated from protobuf field <code>string id = 2;</code>
     */
    private $id = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $device_type
     *           Optional.
     *           Type of the device.
     *     @type string $id
     *           Optional.
     *           A device-specific ID. The ID must be a unique identifier that
     *           distinguishes the device from other devices.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Talent\V4Beta1\Common::initOnce();
        parent::__construct($data);
    }

    /**
     * Optional.
     * Type of the device.
     *
     * Generated from protobuf field <code>.google.cloud.talent.v4beta1.DeviceInfo.DeviceType device_type = 1;</code>
     * @return int
     */
    public function getDeviceType()
    {
        return $this->device_type;
    }

    /**
     * Optional.
     * Type of the device.
     *
     * Generated from protobuf field <code>.google.cloud.talent.v4beta1.DeviceInfo.DeviceType device_type = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setDeviceType($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\Talent\V4beta1\DeviceInfo_DeviceType::class);
        $this->device_type = $var;

        return $this;
    }

    /**
     * Optional.
     * A device-specific ID. The ID must be a unique identifier that
     * distinguishes the device from other devices.
     *
     * Generated from protobuf field <code>string id = 2;</code>
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Optional.
     * A device-specific ID. The ID must be a unique identifier that
     * distinguishes the device from other devices.
     *
     * Generated from protobuf field <code>string id = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setId($var)
    {
        GPBUtil::checkString($var, True);
        $this->id = $var;

        return $this;
    }

}

