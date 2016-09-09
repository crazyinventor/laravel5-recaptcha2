<?php

namespace CrazyInventor\Lacaptcha;

class Lacaptcha {

	/**
	 * URL to the Recaptcha API script
     *
     * @const string
	*/
    const CLIENT_API = 'https://www.google.com/recaptcha/api.js';

    /**
     * URL to verify the captcha
     *
     * @const string
     */
    const VERIFY_URL = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * The Recaptcha secret key
     *
     * @var string
     */
    protected $site_secret;

    /**
     * The Recaptcha sitekey key.
     *
     * @var string
     */
    protected $site_key;
	
	/**
     * Lacaptcha.
     *
     * @param string $site_secret
     * @param string $site_key
     */
    public function __construct($site_key, $site_secret)
    {
        $this->site_key = $site_key;
        $this->site_secret = $site_secret;
    }

    /**
     * Render HTML captcha.
     *
     * @return string
     */
    public function render($attributes = [], $lang = false)
    {
        $attributes['data-sitekey'] = $this->site_key;
        $html = '<script src="'.$this->getScriptSrc($lang).'" async defer></script>'."\n";
        $html .= '<div class="g-recaptcha"'.$this->buildAttributes($attributes).'></div>';
        return $html;
    }
    
    /**
     * Get recaptcha js link.
     *
     * @return string
     */
    public function getScriptSrc($lang = false)
    {
        return ($lang) ? static::CLIENT_API.'?hl='.$lang : static::CLIENT_API;
    }

    /**
     * Build attributes for recaptcha tag.
     *
     * @param array $attributes
     * @return string
     */
    protected function buildAttributes($attributes)
    {
        $html = [];
        foreach ($attributes as $key => $value) {
            $html[] = $key.'="'.$value.'"';
        }
        return count($html) ? ' '.implode(' ', $html) : '';
    }

    /**
     * Verify entered captcha code
     *
     * @param $recaptcha
     * @param $ip
     * @return mixed
     */
    public function verify($recaptcha, $ip)
    {
        $response = json_decode($this->requestVerification($recaptcha, $ip), true);
        return ($response['success']);
    }

    /**
     * Request verification of captcha code
     *
     * @param $recaptcha
     * @param $ip
     * @return mixed
     */
    protected function requestVerification($recaptcha, $ip)
    {
        $url=static::VERIFY_URL."?secret=".$this->site_secret."&response=".$recaptcha."&remoteip=".$ip;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        $curlData = curl_exec($curl);
        curl_close($curl);
        return $curlData;
    }
}