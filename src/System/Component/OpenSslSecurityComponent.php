<?php

namespace System\Component;

use System\Entity\PairKeys;
use System\Exception\InitializeKeyErrorException;
use System\Exception\Protocol\InvalidSignatureException;
use System\Util\Logging\LoggerReference;
use System\Util\Logging\LoggerReferenceTrait;

class OpenSslSecurityComponent implements SecurityComponentInterface, LoggerReference
{
    use LoggerReferenceTrait;

    /**
     * @inheritDoc
     */
    public function sign(string $string, string $privateKey) : string
    {
        if ($privateKey === '') {
            return '';
        }
        try {
            $key = $this->initializePrivateKey($privateKey);
            $result = openssl_sign($string, $signature, $key, OPENSSL_ALGO_SHA1);
            if ($result === false) {
                $signature = '';
            } else {
                $signature = strtolower(bin2hex($signature));
            }
        } catch (\Exception $e) {
            $signature = '';
        }
        return $signature;
    }

    /**
     * @inheritDoc
     * @throws InvalidSignatureException
     */
    public function verify(string $signature, string $string, string $publicKey)
    {
        try {
            $key = $this->initializePublicKey($publicKey);
        } catch (\Exception $e) {
            throw new InvalidSignatureException('public key initialize error');
        }
        
        try {
            $binarySignature = pack("H*", strtolower($signature));
        } catch (\Exception $e) {
            throw new InvalidSignatureException('invalid signature: ' . $e->getMessage());
        }
        
        $result = openssl_verify($string, $binarySignature, $key, OPENSSL_ALGO_SHA1);
        if ($result === 0) {
            throw new InvalidSignatureException('wrong signature');
        }
        if ($result === -1) {
            throw new InvalidSignatureException('openssl exception on verify method');
        }
    }

    /**
     * @inheritDoc
     */
    public function generatePairKeys()
    {
        $arg = [
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA
        ];
        $dn = [];
        $resultPrivateKey = openssl_pkey_new($arg);

        openssl_pkey_export($resultPrivateKey, $private);

        $resultCsr = openssl_csr_new($dn, $resultPrivateKey);
        $resultCert = openssl_csr_sign($resultCsr, null, $resultPrivateKey, 365 * 5);
        openssl_x509_export($resultCert, $output);

        $resultPublicKey = openssl_pkey_get_public($output);
        $publicArray = openssl_pkey_get_details($resultPublicKey);
        $public = $publicArray['key'];

        return new PairKeys(
            $private,
            $public
        );
    }

    /**
     * @param string $privateKey
     * @return resource
     * @throws InitializeKeyErrorException
     */
    private function initializePrivateKey(string $privateKey)
    {
        $pk = openssl_get_privatekey($privateKey);
        if (!$pk) {
            throw new InitializeKeyErrorException('private key');
        }
        return $pk;
    }

    /**
     * @param $publicKey
     * @return resource
     * @throws InitializeKeyErrorException
     */
    private function initializePublicKey(string $publicKey)
    {
        $pk = openssl_get_publickey($publicKey);

        if (!$pk) {
            throw new InitializeKeyErrorException('public key');
        }
        return $pk;
    }
}
