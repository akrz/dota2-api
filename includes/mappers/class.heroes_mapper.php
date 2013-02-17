<?php
/**
 * Load basic info about DotA 2 heroes
 */
class heroes_mapper {
    /**
     * Request url
     */
    const heroes_steam_url = 'https://api.steampowered.com/IEconDOTA2_570/GetHeroes/v0001/';
    /**
     * @var string
     */
    protected $_language = 'en_us';

    /**
     * @param string $lang
     * @return heroes_mapper
     */
    public function set_language($lang) {
        $this->_language = $lang;
        return $this;
    }

    /**
     * @return string
     */
    public function get_language() {
        return $this->_language;
    }

    /**
     * @param string $lang
     */
    public function __construct($lang = null) {
        if (!is_null($lang)) {
            $this->set_language($lang);
        }
    }

    /**
     * @return array
     */
    public function load() {
        $request = new request(
            self::heroes_steam_url,
            array(
                'language' => 'en_us'
            )
        );
        $response = $request->send();
        $response = new SimpleXMLElement($response);
        $heroes_info = (array)($response->heroes);
        $heroes_info = $heroes_info['hero'];
        $heroes = array();
        foreach($heroes_info as $hero_info) {
            $info = (array)$hero_info;
            $heroes[$info['id']] = $info;
        }
        return $heroes;
    }
}
