<?php
class JWT {
    private $secret_key = "your_secret_key_here"; // Change this to a secure secret key in production

    public function generateToken($user_id, $username) {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode([
            'user_id' => $user_id,
            'username' => $username,
            'exp' => time() + (60 * 60 * 24) // 24 hours expiration
        ]);

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $this->secret_key, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    public function validateToken($token) {
        $parts = explode('.', $token);
        if (count($parts) != 3) {
            return false;
        }

        list($header, $payload, $signature) = $parts;

        $valid_signature = hash_hmac('sha256', $header . "." . $payload, $this->secret_key, true);
        $valid_signature_encoded = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($valid_signature));

        if ($signature !== $valid_signature_encoded) {
            return false;
        }

        $payload_data = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $payload)), true);
        
        if ($payload_data['exp'] < time()) {
            return false;
        }

        return $payload_data;
    }
}
?> 