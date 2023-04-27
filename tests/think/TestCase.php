<?php
/**
 * Created by PhpStorm
 * Date 2023/4/26 11:18
 */

namespace Chance\Log\Test\think;

use Chance\Log\orm\think\MySqlConnection;
use Chance\Log\orm\think\Query;
use PHPUnit\Framework\TestCase as BaseTestCase;
use think\db\builder\Mysql;
use think\facade\Db;

class TestCase extends BaseTestCase
{
    public static function setUpBeforeClass(): void
    {
        include_once __DIR__ . '/../function.php';
        self::connections();
        self::createTable();
        self::truncateTable();
    }

    private static function connections()
    {
        Db::setConfig([
            "connections" => [
                "mysql" => [
                    "type" => MySqlConnection::class,
                    "hostname" => "mysql",
                    "database" => "test",
                    "username" => "root",
                    "password" => "root",
                    "charset" => "utf8",
                    "collation" => "utf8_unicode_ci",
                    "prefix" => "tb_",
                    "builder" => Mysql::class,
                    "query" => Query::class,
                ],
                "default1" => [
                    "type" => MySqlConnection::class,
                    "hostname" => "mysql1",
                    "database" => "test1",
                    "username" => "root",
                    "password" => "root",
                    "charset" => "utf8",
                    "collation" => "utf8_unicode_ci",
                    "prefix" => "tb_",
                    "builder" => Mysql::class,
                    "query" => Query::class,
                ],
            ]
        ]);
    }

    private static function createTable()
    {
        Db::query("
                create table if not exists tb_user
                (
                    id          int auto_increment
                        primary key,
                    name        varchar(255)       null comment '姓名',
                    phone       varchar(255)       null comment '手机号',
                    email       varchar(255)       null comment '邮箱',
                    sex         tinyint default 0 null comment '性别',
                    age         int               null comment '年龄',
                    json        json              null comment 'json',
                    create_time datetime,
                    update_time datetime
                )
                    comment '用户';
            ");
        Db::connect("default1")->query("
                create table if not exists tb_user
                (
                    id          int auto_increment
                        primary key,
                    name        varchar(255)       null comment '姓名1',
                    phone       varchar(255)       null comment '手机号1',
                    email       varchar(255)       null comment '邮箱1',
                    sex         tinyint default 0 null comment '性别1',
                    age         int               null comment '年龄1',
                    json        json              null comment 'json1',
                    create_time datetime,
                    update_time datetime
                )
                    comment '用户1';
            ");
    }

    private static function truncateTable()
    {
        Db::query("truncate table tb_user;");
        Db::connect("default1")->query("truncate table tb_user;");
    }
}