<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/monitoring/v3/uptime_service.proto

namespace GPBMetadata\Google\Monitoring\V3;

class UptimeService
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\Annotations::initOnce();
        \GPBMetadata\Google\Monitoring\V3\Uptime::initOnce();
        \GPBMetadata\Google\Protobuf\GPBEmpty::initOnce();
        \GPBMetadata\Google\Protobuf\FieldMask::initOnce();
        $pool->internalAddGeneratedFile(hex2bin(
            "0aba110a29676f6f676c652f6d6f6e69746f72696e672f76332f75707469" .
            "6d655f736572766963652e70726f746f1214676f6f676c652e6d6f6e6974" .
            "6f72696e672e76331a21676f6f676c652f6d6f6e69746f72696e672f7633" .
            "2f757074696d652e70726f746f1a1b676f6f676c652f70726f746f627566" .
            "2f656d7074792e70726f746f1a20676f6f676c652f70726f746f6275662f" .
            "6669656c645f6d61736b2e70726f746f22560a1d4c697374557074696d65" .
            "436865636b436f6e6669677352657175657374120e0a06706172656e7418" .
            "012001280912110a09706167655f73697a6518032001280512120a0a7061" .
            "67655f746f6b656e1804200128092294010a1e4c697374557074696d6543" .
            "6865636b436f6e66696773526573706f6e736512450a14757074696d655f" .
            "636865636b5f636f6e6669677318012003280b32272e676f6f676c652e6d" .
            "6f6e69746f72696e672e76332e557074696d65436865636b436f6e666967" .
            "12170a0f6e6578745f706167655f746f6b656e18022001280912120a0a74" .
            "6f74616c5f73697a65180320012805222b0a1b476574557074696d654368" .
            "65636b436f6e66696752657175657374120c0a046e616d65180120012809" .
            "22760a1e437265617465557074696d65436865636b436f6e666967526571" .
            "75657374120e0a06706172656e7418012001280912440a13757074696d65" .
            "5f636865636b5f636f6e66696718022001280b32272e676f6f676c652e6d" .
            "6f6e69746f72696e672e76332e557074696d65436865636b436f6e666967" .
            "2297010a1e557064617465557074696d65436865636b436f6e6669675265" .
            "7175657374122f0a0b7570646174655f6d61736b18022001280b321a2e67" .
            "6f6f676c652e70726f746f6275662e4669656c644d61736b12440a137570" .
            "74696d655f636865636b5f636f6e66696718032001280b32272e676f6f67" .
            "6c652e6d6f6e69746f72696e672e76332e557074696d65436865636b436f" .
            "6e666967222e0a1e44656c657465557074696d65436865636b436f6e6669" .
            "6752657175657374120c0a046e616d6518012001280922420a194c697374" .
            "557074696d65436865636b4970735265717565737412110a09706167655f" .
            "73697a6518022001280512120a0a706167655f746f6b656e180320012809" .
            "22740a1a4c697374557074696d65436865636b497073526573706f6e7365" .
            "123d0a10757074696d655f636865636b5f69707318012003280b32232e67" .
            "6f6f676c652e6d6f6e69746f72696e672e76332e557074696d6543686563" .
            "6b497012170a0f6e6578745f706167655f746f6b656e18022001280932c7" .
            "080a12557074696d65436865636b5365727669636512b7010a164c697374" .
            "557074696d65436865636b436f6e6669677312332e676f6f676c652e6d6f" .
            "6e69746f72696e672e76332e4c697374557074696d65436865636b436f6e" .
            "66696773526571756573741a342e676f6f676c652e6d6f6e69746f72696e" .
            "672e76332e4c697374557074696d65436865636b436f6e66696773526573" .
            "706f6e7365223282d3e493022c122a2f76332f7b706172656e743d70726f" .
            "6a656374732f2a7d2f757074696d65436865636b436f6e6669677312a601" .
            "0a14476574557074696d65436865636b436f6e66696712312e676f6f676c" .
            "652e6d6f6e69746f72696e672e76332e476574557074696d65436865636b" .
            "436f6e666967526571756573741a272e676f6f676c652e6d6f6e69746f72" .
            "696e672e76332e557074696d65436865636b436f6e666967223282d3e493" .
            "022c122a2f76332f7b6e616d653d70726f6a656374732f2a2f757074696d" .
            "65436865636b436f6e666967732f2a7d12c1010a17437265617465557074" .
            "696d65436865636b436f6e66696712342e676f6f676c652e6d6f6e69746f" .
            "72696e672e76332e437265617465557074696d65436865636b436f6e6669" .
            "67526571756573741a272e676f6f676c652e6d6f6e69746f72696e672e76" .
            "332e557074696d65436865636b436f6e666967224782d3e4930241222a2f" .
            "76332f7b706172656e743d70726f6a656374732f2a7d2f757074696d6543" .
            "6865636b436f6e666967733a13757074696d655f636865636b5f636f6e66" .
            "696712d5010a17557064617465557074696d65436865636b436f6e666967" .
            "12342e676f6f676c652e6d6f6e69746f72696e672e76332e557064617465" .
            "557074696d65436865636b436f6e666967526571756573741a272e676f6f" .
            "676c652e6d6f6e69746f72696e672e76332e557074696d65436865636b43" .
            "6f6e666967225b82d3e4930255323e2f76332f7b757074696d655f636865" .
            "636b5f636f6e6669672e6e616d653d70726f6a656374732f2a2f75707469" .
            "6d65436865636b436f6e666967732f2a7d3a13757074696d655f63686563" .
            "6b5f636f6e666967129b010a1744656c657465557074696d65436865636b" .
            "436f6e66696712342e676f6f676c652e6d6f6e69746f72696e672e76332e" .
            "44656c657465557074696d65436865636b436f6e66696752657175657374" .
            "1a162e676f6f676c652e70726f746f6275662e456d707479223282d3e493" .
            "022c2a2a2f76332f7b6e616d653d70726f6a656374732f2a2f757074696d" .
            "65436865636b436f6e666967732f2a7d1293010a124c697374557074696d" .
            "65436865636b497073122f2e676f6f676c652e6d6f6e69746f72696e672e" .
            "76332e4c697374557074696d65436865636b497073526571756573741a30" .
            "2e676f6f676c652e6d6f6e69746f72696e672e76332e4c69737455707469" .
            "6d65436865636b497073526573706f6e7365221a82d3e493021412122f76" .
            "332f757074696d65436865636b49707342aa010a18636f6d2e676f6f676c" .
            "652e6d6f6e69746f72696e672e76334212557074696d6553657276696365" .
            "50726f746f50015a3e676f6f676c652e676f6c616e672e6f72672f67656e" .
            "70726f746f2f676f6f676c65617069732f6d6f6e69746f72696e672f7633" .
            "3b6d6f6e69746f72696e67aa021a476f6f676c652e436c6f75642e4d6f6e" .
            "69746f72696e672e5633ca021a476f6f676c655c436c6f75645c4d6f6e69" .
            "746f72696e675c5633620670726f746f33"
        ), true);

        static::$is_initialized = true;
    }
}

