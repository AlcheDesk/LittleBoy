<?php

namespace App\Services\Utils\RedisUtils;

use Illuminate\Support\Facades\Redis;

class BaseRedisUtilService
{

    protected $REDIS_ENABLE;
    protected $expired_at;
    protected $RECORD_NAME;
    protected $LIST_PREFIX;
    protected $PREFIX;
    protected $COUNT_PREFIX;

    public function __construct()
    {
        $this->REDIS_ENABLE = config('database.redis.REDIS_ENABLE');
        $this->expired_at = 60;
        $this->RECORD_NAME = 'Record';
        $this->LIST_PREFIX = 'RecordList_';
        $this->PREFIX = 'Record_';
        $this->COUNT_PREFIX = 'RecordCount_';
    }

    public function cacheRecordList($key, String $jsonStringBody) {
        if($this->REDIS_ENABLE){
            Redis::setex($this->LIST_PREFIX.$key, $this->expired_at, $jsonStringBody);
        }
    }

    public function cacheRecord($id, String $jsonStringBody) {
        if($this->REDIS_ENABLE){
            Redis::setex($this->PREFIX.$id, $this->expired_at, $jsonStringBody);
        }
    }

    public function cacheRecordCount(String $key, int $count) {
        if($this->REDIS_ENABLE){
            $key =$this->COUNT_PREFIX.$key;
            Redis::setex($this->COUNT_PREFIX.$key, $this->expired_at, $count);
        }
    }

    public function getRecordListFromCache(String $key) {
        if($this->REDIS_ENABLE){
            $jsonStringResponse = Redis::get($this->LIST_PREFIX.$key);
            return $jsonStringResponse;
        }else{
            return null;
        }
    }

    public function getRecordFromCache($id) {
        if($this->REDIS_ENABLE){
            $jsonStringResponse = Redis::get($this->PREFIX.$id);
            return $jsonStringResponse;
        }else{
            return null;
        }
    }

    public function getRecordCountFromCache(String $key) {
        if($this->REDIS_ENABLE){
            $key = $this->COUNT_PREFIX.$key;
            $count = Redis::get($this->PREFIX.$key);
            return $count;
        }else{
            return null;
        }
    }

    public function hasRecordList($key) {
        if($this->REDIS_ENABLE){
            $key = $this->LIST_PREFIX.$key;
            return Redis::exists($key);
        }else{
            return false;
        }
    }

    public function hasRecord($id) {
        if($this->REDIS_ENABLE){
            $key = $this->PREFIX.$id;
            return Redis::exists($key);
        }else{
            return false;
        }
    }

    public function hasRecordCount(String $key) {
        if($this->REDIS_ENABLE){
            $key = $this->COUNT_PREFIX.$key;
            return Redis::exists($key);
        }else{
            return false;
        }
    }

    public function removeAllCache() {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*$this->RECORD_NAME*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    }

    public function removeAllRelatedCache()
    {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*$this->RECORD_NAME*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    }
}