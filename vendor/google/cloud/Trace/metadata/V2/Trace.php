<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/devtools/cloudtrace/v2/trace.proto

namespace GPBMetadata\Google\Devtools\Cloudtrace\V2;

class Trace
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\Annotations::initOnce();
        \GPBMetadata\Google\Protobuf\Timestamp::initOnce();
        \GPBMetadata\Google\Protobuf\Wrappers::initOnce();
        \GPBMetadata\Google\Rpc\Status::initOnce();
        $pool->internalAddGeneratedFile(hex2bin(
            "0a911a0a29676f6f676c652f646576746f6f6c732f636c6f756474726163" .
            "652f76322f74726163652e70726f746f121d676f6f676c652e646576746f" .
            "6f6c732e636c6f756474726163652e76321a1f676f6f676c652f70726f74" .
            "6f6275662f74696d657374616d702e70726f746f1a1e676f6f676c652f70" .
            "726f746f6275662f77726170706572732e70726f746f1a17676f6f676c65" .
            "2f7270632f7374617475732e70726f746f22c50f0a045370616e120c0a04" .
            "6e616d65180120012809120f0a077370616e5f696418022001280912160a" .
            "0e706172656e745f7370616e5f696418032001280912460a0c646973706c" .
            "61795f6e616d6518042001280b32302e676f6f676c652e646576746f6f6c" .
            "732e636c6f756474726163652e76322e5472756e63617461626c65537472" .
            "696e67122e0a0a73746172745f74696d6518052001280b321a2e676f6f67" .
            "6c652e70726f746f6275662e54696d657374616d70122c0a08656e645f74" .
            "696d6518062001280b321a2e676f6f676c652e70726f746f6275662e5469" .
            "6d657374616d7012420a0a6174747269627574657318072001280b322e2e" .
            "676f6f676c652e646576746f6f6c732e636c6f756474726163652e76322e" .
            "5370616e2e41747472696275746573123e0a0b737461636b5f7472616365" .
            "18082001280b32292e676f6f676c652e646576746f6f6c732e636c6f7564" .
            "74726163652e76322e537461636b547261636512430a0b74696d655f6576" .
            "656e747318092001280b322e2e676f6f676c652e646576746f6f6c732e63" .
            "6c6f756474726163652e76322e5370616e2e54696d654576656e74731238" .
            "0a056c696e6b73180a2001280b32292e676f6f676c652e646576746f6f6c" .
            "732e636c6f756474726163652e76322e5370616e2e4c696e6b7312220a06" .
            "737461747573180b2001280b32122e676f6f676c652e7270632e53746174" .
            "7573123f0a1b73616d655f70726f636573735f61735f706172656e745f73" .
            "70616e180c2001280b321a2e676f6f676c652e70726f746f6275662e426f" .
            "6f6c56616c756512350a106368696c645f7370616e5f636f756e74180d20" .
            "01280b321b2e676f6f676c652e70726f746f6275662e496e74333256616c" .
            "75651aeb010a0a4174747269627574657312570a0d617474726962757465" .
            "5f6d617018012003280b32402e676f6f676c652e646576746f6f6c732e63" .
            "6c6f756474726163652e76322e5370616e2e417474726962757465732e41" .
            "74747269627574654d6170456e74727912200a1864726f707065645f6174" .
            "74726962757465735f636f756e741802200128051a620a11417474726962" .
            "7574654d6170456e747279120b0a036b6579180120012809123c0a057661" .
            "6c756518022001280b322d2e676f6f676c652e646576746f6f6c732e636c" .
            "6f756474726163652e76322e41747472696275746556616c75653a023801" .
            "1adf040a0954696d654576656e7412280a0474696d6518012001280b321a" .
            "2e676f6f676c652e70726f746f6275662e54696d657374616d70124e0a0a" .
            "616e6e6f746174696f6e18022001280b32382e676f6f676c652e64657674" .
            "6f6f6c732e636c6f756474726163652e76322e5370616e2e54696d654576" .
            "656e742e416e6e6f746174696f6e480012530a0d6d6573736167655f6576" .
            "656e7418032001280b323a2e676f6f676c652e646576746f6f6c732e636c" .
            "6f756474726163652e76322e5370616e2e54696d654576656e742e4d6573" .
            "736167654576656e7448001a97010a0a416e6e6f746174696f6e12450a0b" .
            "6465736372697074696f6e18012001280b32302e676f6f676c652e646576" .
            "746f6f6c732e636c6f756474726163652e76322e5472756e63617461626c" .
            "65537472696e6712420a0a6174747269627574657318022001280b322e2e" .
            "676f6f676c652e646576746f6f6c732e636c6f756474726163652e76322e" .
            "5370616e2e417474726962757465731adf010a0c4d657373616765457665" .
            "6e74124d0a047479706518012001280e323f2e676f6f676c652e64657674" .
            "6f6f6c732e636c6f756474726163652e76322e5370616e2e54696d654576" .
            "656e742e4d6573736167654576656e742e54797065120a0a026964180220" .
            "012803121f0a17756e636f6d707265737365645f73697a655f6279746573" .
            "180320012803121d0a15636f6d707265737365645f73697a655f62797465" .
            "7318042001280322340a045479706512140a10545950455f554e53504543" .
            "4946494544100012080a0453454e541001120c0a08524543454956454410" .
            "0242070a0576616c75651a98010a0a54696d654576656e747312410a0a74" .
            "696d655f6576656e7418012003280b322d2e676f6f676c652e646576746f" .
            "6f6c732e636c6f756474726163652e76322e5370616e2e54696d65457665" .
            "6e7412210a1964726f707065645f616e6e6f746174696f6e735f636f756e" .
            "7418022001280512240a1c64726f707065645f6d6573736167655f657665" .
            "6e74735f636f756e741803200128051af7010a044c696e6b12100a087472" .
            "6163655f6964180120012809120f0a077370616e5f696418022001280912" .
            "3b0a047479706518032001280e322d2e676f6f676c652e646576746f6f6c" .
            "732e636c6f756474726163652e76322e5370616e2e4c696e6b2e54797065" .
            "12420a0a6174747269627574657318042001280b322e2e676f6f676c652e" .
            "646576746f6f6c732e636c6f756474726163652e76322e5370616e2e4174" .
            "7472696275746573224b0a045479706512140a10545950455f554e535045" .
            "434946494544100012150a114348494c445f4c494e4b45445f5350414e10" .
            "0112160a12504152454e545f4c494e4b45445f5350414e10021a5c0a054c" .
            "696e6b7312360a046c696e6b18012003280b32282e676f6f676c652e6465" .
            "76746f6f6c732e636c6f756474726163652e76322e5370616e2e4c696e6b" .
            "121b0a1364726f707065645f6c696e6b735f636f756e7418022001280522" .
            "8e010a0e41747472696275746556616c756512480a0c737472696e675f76" .
            "616c756518012001280b32302e676f6f676c652e646576746f6f6c732e63" .
            "6c6f756474726163652e76322e5472756e63617461626c65537472696e67" .
            "480012130a09696e745f76616c7565180220012803480012140a0a626f6f" .
            "6c5f76616c7565180320012808480042070a0576616c75652289050a0a53" .
            "7461636b5472616365124b0a0c737461636b5f6672616d65731801200128" .
            "0b32352e676f6f676c652e646576746f6f6c732e636c6f75647472616365" .
            "2e76322e537461636b54726163652e537461636b4672616d6573121b0a13" .
            "737461636b5f74726163655f686173685f69641802200128031a9e030a0a" .
            "537461636b4672616d6512470a0d66756e6374696f6e5f6e616d65180120" .
            "01280b32302e676f6f676c652e646576746f6f6c732e636c6f7564747261" .
            "63652e76322e5472756e63617461626c65537472696e6712500a166f7269" .
            "67696e616c5f66756e6374696f6e5f6e616d6518022001280b32302e676f" .
            "6f676c652e646576746f6f6c732e636c6f756474726163652e76322e5472" .
            "756e63617461626c65537472696e6712430a0966696c655f6e616d651803" .
            "2001280b32302e676f6f676c652e646576746f6f6c732e636c6f75647472" .
            "6163652e76322e5472756e63617461626c65537472696e6712130a0b6c69" .
            "6e655f6e756d62657218042001280312150a0d636f6c756d6e5f6e756d62" .
            "6572180520012803123a0a0b6c6f61645f6d6f64756c6518062001280b32" .
            "252e676f6f676c652e646576746f6f6c732e636c6f756474726163652e76" .
            "322e4d6f64756c6512480a0e736f757263655f76657273696f6e18072001" .
            "280b32302e676f6f676c652e646576746f6f6c732e636c6f756474726163" .
            "652e76322e5472756e63617461626c65537472696e671a700a0b53746163" .
            "6b4672616d657312430a056672616d6518012003280b32342e676f6f676c" .
            "652e646576746f6f6c732e636c6f756474726163652e76322e537461636b" .
            "54726163652e537461636b4672616d65121c0a1464726f707065645f6672" .
            "616d65735f636f756e74180220012805228e010a064d6f64756c6512400a" .
            "066d6f64756c6518012001280b32302e676f6f676c652e646576746f6f6c" .
            "732e636c6f756474726163652e76322e5472756e63617461626c65537472" .
            "696e6712420a086275696c645f696418022001280b32302e676f6f676c65" .
            "2e646576746f6f6c732e636c6f756474726163652e76322e5472756e6361" .
            "7461626c65537472696e6722400a115472756e63617461626c6553747269" .
            "6e67120d0a0576616c7565180120012809121c0a147472756e6361746564" .
            "5f627974655f636f756e7418022001280542aa010a21636f6d2e676f6f67" .
            "6c652e646576746f6f6c732e636c6f756474726163652e7632420a547261" .
            "636550726f746f50015a47676f6f676c652e676f6c616e672e6f72672f67" .
            "656e70726f746f2f676f6f676c65617069732f646576746f6f6c732f636c" .
            "6f756474726163652f76323b636c6f75647472616365aa0215476f6f676c" .
            "652e436c6f75642e54726163652e5632ca0215476f6f676c655c436c6f75" .
            "645c54726163655c5632620670726f746f33"
        ), true);

        static::$is_initialized = true;
    }
}

