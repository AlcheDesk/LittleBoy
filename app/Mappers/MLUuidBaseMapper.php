<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/30
 * Time: 11:04
 */
namespace App\Mappers;

interface MLUuidBaseMapper
{

    public function countByOptions(array $options = []);

    public function deleteByOptions(array $options = []);

    public function deleteByUuid($uuid);

    public function insert(string $jsonRequestBodyString);

    public function selectByOptions(array $options = []);

    public function selectByUuid(array $options = [], $uuid);

    public function update(string $jsonRequestBodyString);

    public function replace(string $jsonRequestBodyString);
}