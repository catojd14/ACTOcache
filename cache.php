/**
 * Instructions
 *
Typically, with API responses-- ones that don't change too often, engineers use caching 
to speed up their apps. This way, they don't have to make constant API calls and can just 
pull data from their cache. 
Your task is to write a simple class that implements a disk or database based cache. 
You need to be able to add to and remove from the cache. 
Users should also be able to set the cache expiry, but your default expiry should be 10 minutes.
 */

class Cache {
    private $_salt = "change_it";
    private $_name;
    private $_dir;
    private $_extension;
    private $_path;

    private $_autoSave = false;
    private $_cache;

    public function __construct(string $name = "default", string $dir = "tmp/", string $extension = ".cache") {

        $this->_name = $name;
        $this->_dir = $dir;
        $this->_extension = $extension;
        $this->_path = $this->getCachePath();

        $this->loadCache();
    }

    public function setAutoSave(bool $state) : void {

        $this->_autoSave = $state;
    }

    public function get(string $key, &$out) : bool {

        if ($this->_cache === null) return false;
        if (!array_key_exists($key, $this->_cache)) return false;

        $data = $this->_cache[$key];

        if ($this->isExpired($data)) {
            
            unset($this->_cache[$key]);

            if ($this->_autoSave) {
                $this->saveCache();
            }

            return false;
        }

        $out = unserialize($data["v"]);
        return true;
    }

    public function set(string $key, $value, int $ttl = 600) : void {

        $data = [
            "t" => time(),
            "e" => $ttl,
            "v" => serialize($value),
        ];

        if ($this->_cache === null) {
            $this->_cache = [
                $key => $data,
            ];
        }
        else {
            $this->_cache[$key] = $data;
        }

        if ($this->_autoSave) {
            $this->saveCache();
        }
    }

    public function delete(string $key) : bool {

        if ($this->_cache === null) return false;
        if (!array_key_exists($key, $this->_cache)) return false;

        unset($this->_cache[$key]);

        if ($this->_autoSave) {
            $this->saveCache();
        }

        return true;
    }

    public function deleteExpired() : bool {

        if ($this->_cache === null) return false;

        foreach ($this->_cache as $key => $value) {
            if($this->isExpired($value)) {
                unset($this->_cache[$key]);
            }
        }

        if ($this->_autoSave) {
            $this->saveCache();
        }

        return true;
    }

    private function isExpired($data) : bool {

        if ($data["e"] == -1) return false;

        $expiresOn = $data["t"] + $data["e"];
        return $expiresOn < time();
    }

    public function saveCache() : bool {

        if ($this->_cache === null) return false;

        $content = json_encode($this->_cache);
        file_put_contents($this->_path, $content);

        return true;
    }

    public function loadCache() : bool {

        if (!file_exists($this->_path)) return false;

        $content = file_get_contents($this->_path);
        $this->_cache = json_decode($content, true);
        
        return true;
    }

    private function getCachePath() : string {

        return $this->_dir . md5($this->_name . $this->_salt) . $this->_extension;
    }

}