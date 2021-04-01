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

class Cache
{
	private $cache_path = 'cacche/';
    private $catch_name = 'default';
    private $extension = '.cache';

    public function __construction($config=null) {
        if(isset($config)) {
            if(is_string($config)) {
                $this->setCache($config);
            } else if (is_array($config)) {
                $this->setCache($config['name']);
                $this->setCachePath($config['path']);
                $this->setExtension($config['extension']);
            }
        }
    }

    // Check data with a array

    public function isCached($key) {
        if($this->loadCache()) {
            $cachedData = $this->loadCache();
            return isset($cachedData[$key]['data']);
        }
    }

    //Add data in the Cache

    public function store ($key, $data, $expiration = 600) {
        $storeData = array(
            'time'  => time(),
            'expire'=> $expiration,
            'data'  => serialize($data)
        );
        $dataArray = $this->loadCache();
        if (is_array($dataArray)) {
            $dataArray[$key] = $storeData;
        } else {
            $dataArray = array($key => $storeData);
        }
        $cachedData = json_encode($dataArray);
        file_put_contents($this->getCacheDir(), $cachedData);
        return $this;
    }

    //Get cached data with its key
    public function retrieve($key, $timestamp = false) {
        $cachedData = $this->loadCache();
        ($timestamp === false) ? $type = 'data' : $type = 'time';

        if (!isset($cachedData[$key][$type])) return null;

        return unserialize($cachedData[$key][$type]);
    }

    //Load cache

    private function loadCache() {
        if(file_exists($this->getCacheDir())) {
            $file = file_get_contents($this->getCacheDir());
            return json_decode($file, true);
        } else {
            return false;
        }
    }

    //Remove cached data by its key
    public function remove($key) {
        $cachedData = $this->loadCache();
        if(is_array($cachedData)) {
            if (isset($cachedData[$key])) {
                unset($cachedData[$key]);
                $cachedData = json_encode($cachedData);
                file_put_contents($this->getCacheDir(), $cachedData);
            } else {
                throw new Exception("Error: erase() - Key '{$key}' not found.");
            }
        }
    }

    // Get the cache directory path
    public function getCacheDir() {
      $filename = $this->getCache();
      $filename = preg_replace('/[^0-9a-z\.\_\-]/i', '', strtolower($filename));

      return $this->getCachePath() . $filename . $this->getExtension();
    
    }

    //Cache Path Setter
    public function setCachePath($path) {
    $this->cache_path = $path;
    return $this;
   }

   // catch path getter
   public function getCachePath() {
       return $this->cache_path;
   }

   //Catch name setter
   public function setCache($name) {
       $this->cache_name;
       return $this;
   }

   //Cache name getter
   public function getCache() {
       return $this->cache_name;
   }

   //Cache extension setter
   public function setExtension($ext) {
       $this->extension = $ext;
       return $this;
   }

   //Catch extension getter() {
       return $this->extension;
   } 
}