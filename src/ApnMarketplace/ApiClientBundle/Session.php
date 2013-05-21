<?php

namespace ApnMarketplace\ApiClientBundle;

use ApnMarketplace\ApiClient\Client\Guzzle\Session as BaseSession;

class Session extends BaseSession
{
    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        return isset($_SESSION['_sf2_attributes'][$key]) ? $_SESSION['_sf2_attributes'][$key] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $val)
    {
        $_SESSION['_sf2_attributes'][$key] = $val;
    }
}
