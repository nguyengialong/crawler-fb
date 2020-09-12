<?php


namespace App\FacebookSDK\Helper;


class UrlDetection
{
    /**
     * Remove params from a URL.
     *
     * @param string $url
     * @param array $params_filter
     * @return string
     */
    public static function removeParamsFromUrl($url, array $params_filter = []) {
    
        $parts = parse_url($url);
    
        $query = '';
        if (isset($parts['query']) && !empty($params_filter)) {
            $params = [];
            parse_str($parts['query'], $params);
        
            // Remove query params
            foreach ($params_filter as $param_name) {
                unset($params[$param_name]);
            }
        
            if (count($params) > 0) {
                $query = '?' . http_build_query($params, null, '&');
            }
        }
    
        $scheme = isset($parts['scheme']) ? $parts['scheme'] . '://' : '';
        $host = isset($parts['host']) ? $parts['host'] : '';
        $port = isset($parts['port']) ? ':' . $parts['port'] : '';
        $path = isset($parts['path']) ? $parts['path'] : '';
        $fragment = isset($parts['fragment']) ? '#' . $parts['fragment'] : '';
    
        return $scheme . $host . $port . $path . $query . $fragment;
    }
    
    /**
     * Gracefully appends params to the URL.
     *
     * @param string $url
     * @param array $new_params
     *
     * @return string
     */
    public static function appendParamsToUrl($url, array $new_params = [])
    {
        if (empty($new_params)) {
            return $url;
        }
        
        if (strpos($url, '?') === false) {
            return $url . '?' . http_build_query($new_params, null, '&');
        }
        
        list($path, $query) = explode('?', $url, 2);
        parse_str($query, $old_params);
        
        // Favor params from the original URL over $newParams
        $final_params = array_merge($new_params, $old_params);
        
        // Sort for a predicable order
        // ksort($final_params);
        
        return $path . '?' . http_build_query($final_params, null, '&');
    }
    
    /**
     * Returns the params from a URL in the form of an array.
     *
     * @param string $url
     *
     * @return array
     */
    public static function getParams($url)
    {
        $query = parse_url($url, PHP_URL_QUERY);
        if (!$query) {
            return [];
        }
        parse_str($query, $params);
        
        return $params;
    }
    
    
    /**
     * Trims off the hostname and Graph version from a URL.
     *
     * @param $url
     * @return string
     */
    public static function baseGraphUrlEndpoint($url)
    {
        return '/' . preg_replace('/^https:\/\/.+\.facebook\.com(\/v.+?)?\//', '', trim($url));
    }
    
}