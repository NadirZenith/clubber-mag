<?php

/**
 * Super-simple, minimum abstraction MailChimp API v3 wrapper
 *
 * Uses curl if available, falls back to file_get_contents and HTTP stream.
 * This probably has more comments than code.
 *
 * Contributors:
 * Michael Minor <me@pixelbacon.com>
 * Lorna Jane Mitchell, github.com/lornajane
 *
 * @author NadirZenith <nz@nzlabs.es>
 * @version 0.1.0
 */
class MailChimp
{
    private $api_key;
    private $timeout;
    private $api_endpoint = 'https://<dc>.api.mailchimp.com/3.0';
    private $verify_ssl = false;

    /**
     * Create a new instance
     * @param string $api_key Your MailChimp API key
     */
    public function __construct($api_key, $timeout = 10)
    {

        $this->api_key = $api_key;
        $this->timeout = $timeout;
        list(, $datacentre) = explode('-', $this->api_key);
        $this->api_endpoint = str_replace('<dc>', $datacentre, $this->api_endpoint);
    }

    /**
     * Validates MailChimp API Key
     */
    public function validateApiKey()
    {
        $r = $this->call('');
        return (isset($r['status']) && $r['status'] == 200);
    }

    /**
     * Call an API method. Every request needs the API key, so that is added automatically -- you don't need to pass it in.
     * @param  string $path   The API endpoint to call, e.g. '/lists/'
     * @param  string $method The request method POST/GET
     * @param  array  $args   An array of arguments to pass to the method. Will be json-encoded for you.
     * @return array          Associative array of json decoded API response.
     */
    public function call($path, $method = 'GET', $args = array(), $timeout = 10)
    {
        return $this->makeRequest($path, $method, $args, $timeout);
    }

    /**
     * Performs the underlying HTTP request. Not very exciting
     * @param  string $path   The API endpoint to call, e.g. '/lists/'
     * @param  string $method The API method to be called
     * @param  array  $args   Assoc array of parameters to be passed
     * @return array          Assoc array of decoded result
     */
    private function makeRequest($path, $method = 'GET', $args = array(), $timeout = 10)
    {
        $args['apikey'] = $this->api_key;

        $url = $this->api_endpoint . '/' . $path;

        if (function_exists('curl_init') && function_exists('curl_setopt' //
                && false
            )) {
            $ch = curl_init();
            $headers = ['Content-Type: application/json'];
            if ('POST' === $method) {
                curl_setopt($ch, CURLOPT_POST, true);
                $json_data = json_encode($args);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
            } else if ('GET' === $method) {
                $url .= '?' . http_build_query($args);
            } else {
                $headers[] = 'X-HTTP-Method-Override: ' . $method;
            }

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->verify_ssl);
            /* curl_setopt($ch, CURLOPT_HEADER, false); */
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
            $result = curl_exec($ch);
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
        } else {
            $context = [
                'http' => [
                    'protocol_version' => 1.1,
                    'method' => $method,
                    'ignore_errors' => true,
                    'user_agent' => 'PHP-MCAPI/2.0',
                    'header' => "Content-type: application/json\r\n" .
                    "Connection: close\r\n"
                /* "Content-length: " . strlen($json_data) . "\r\n", */
                ]
            ];
            /* $context['http']['header'] = "Content-type: application/json\r\n" . */
            if ('POST' === $method) {
                $json_data = json_encode($args);
                $context['http']['method'] = 'POST';
                $context['http']['content'] = $json_data;
            } else if ('GET' === $method) {
                $context['http']['method'] = 'GET';
                $url .= '?' . http_build_query($args);
            } else {
                $context['http']['method'] = 'POST';
                $context['http']['header'] .= "X-HTTP-Method-Override: " . $method . "\r\n";
            }
            $result = file_get_contents($url, null, stream_context_create($context));

            $headers = $http_response_header;
            if (preg_match("#HTTP/[0-9\.]+\s+([0-9]+)#", $headers[0], $out)) {
                $status = intval($out[1]);
            } else {
                $status = 'NaN';
            }
        }

        if ($result) {
            $result = json_decode($result, true);
            $result['status'] = $status;
        } else {
            $result = false;
        }

        return $result;
    }
}
