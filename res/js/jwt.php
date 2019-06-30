<?php
    class JWT {
        private $key;
        private $signAlgo;

        private $payloadSecret;
        private $payloadCipherAlgo;

        public function __construct($signKey, $signAlgorithm, $payloadSec, $payloadCipher) {
            $this->key = $signKey;
            $this->signAlgo = $signAlgorithm;

            $this->payloadSecret = $payloadSec;
            $this->payloadCipherAlgo = $payloadCipher;
        }

        // Encode a string based on base 64 URL
        public function base64url_encode($data) { 
            return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
        } 

        // Decode a string based on base 64 URL
        public function base64url_decode($data) { 
            return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
        } 

        // Generate a web token based on a payload
        public function generateToken($payload) {

            // Encode the header
            $headerENC = json_encode(array("typ" => "JWT", "alg" => "HS256"));
            $headers = $this->base64url_encode($headerENC);

            // Encode and encrypt the payload
            $payloadENC = json_encode($payload);
            $payload64 = $this->base64url_encode($payloadENC);
            $payload = openssl_encrypt($payload64, $this->payloadCipherAlgo, $this->payloadSecret);
            
            // Hash the sign based upon a secret key
            $hashedSign = hash_hmac($this->signAlgo, $headers . "." . $payload, $this->key);
            $signature = $this->base64url_encode($hashedSign);

            // Return the web token
            return $headers . "." . $payload . "." . $signature;
        }

        public function verifyToken($token) {
            list($header, $payload, $signature) = explode(".", $token);

            // Generate the signature of the received token
            $data = $header . "." . $payload;
            $signature = $this->base64url_decode($signature);
            $rawSign = hash_hmac($this->signAlgo, $data, $this->key);

            // Compare the signature of the received token to the generated token
            return hash_equals($rawSign, $signature);
        }

        public function decodePayload($token) {
            list($header, $payload, $signature) = explode(".", $token);

            // Decrypt the payload based on a secret key and cipher
            $decrypted = openssl_decrypt($payload, $this->payloadCipherAlgo, $this->payloadSecret);

            // Return a base 64 decoded JSON string of the payload
            return $this->base64url_decode($decrypted);
        }

    }
?>