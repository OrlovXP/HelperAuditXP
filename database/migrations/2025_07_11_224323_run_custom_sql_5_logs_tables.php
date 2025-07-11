<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("CREATE TABLE `log_tab` (
 `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID лога',
 `tab` varchar(50) NOT NULL COMMENT 'Имя таблицы',
 `id_tab` bigint unsigned NOT NULL COMMENT 'ID таблицы',
 `f_col` varchar(50) NOT NULL COMMENT 'Имя колонки',
 `f_old` mediumtext COMMENT 'Старое значение',
 `f_new` mediumtext COMMENT 'Новое значение',
 `user_name` varchar(50) NOT NULL COMMENT 'Имя пользователя',
 `date_in` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Добавлено',
 PRIMARY KEY (`id`),
 KEY `ix_tab` (`tab`) USING BTREE,
 KEY `ix_idtab` (`id_tab`) USING BTREE,
 KEY `ix_fcol` (`f_col`) USING BTREE
) ENGINE=InnoDB COMMENT='Основная таблица логов';");

    DB::statement("CREATE TABLE `log_tbh` (
 `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID лога',
 `tab` varchar(50) NOT NULL COMMENT 'Имя таблицы',
 `id_tab` bigint unsigned DEFAULT NULL COMMENT 'ID таблицы',
 `f_col` varchar(50) NOT NULL COMMENT 'Имя колонки',
 `f_old` mediumtext COMMENT 'Старое значение',
 `f_new` mediumtext COMMENT 'Новое значение',
 `user_name` varchar(50) NOT NULL COMMENT 'ID пользователя',
 `date_in` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Добавлено',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB COMMENT='Ненужные логи';");

    DB::statement("CREATE TABLE `log_tjs` (
 `id` bigint NOT NULL AUTO_INCREMENT COMMENT 'ID лога',
 `tab` varchar(50) NOT NULL COMMENT 'Имя таблицы',
 `id_tab` bigint unsigned DEFAULT NULL COMMENT 'ID таблицы',
 `f_col` varchar(50) NOT NULL COMMENT 'Имя колонки',
 `js_data` json NOT NULL COMMENT 'Значение в JSON',
 `user_name` varchar(50) NOT NULL COMMENT 'Имя пользователя',
 `date_in` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Добавлено',
 PRIMARY KEY (`id`),
 KEY `ix_datein` (`date_in`) USING BTREE,
 KEY `ix_tab` (`tab`) USING BTREE,
 KEY `ix_fcol` (`f_col`) USING BTREE,
 KEY `ix_idtab` (`id_tab`) USING BTREE
) ENGINE=InnoDB COMMENT='Лог в формате JSON только  для INSERT, DELETE';");

    DB::statement("CREATE TABLE `log_htm` (
 `loghtm_id` bigint unsigned NOT NULL AUTO_INCREMENT,
 `reports_id` bigint unsigned DEFAULT NULL,
 `data_htm` longtext NOT NULL,
 PRIMARY KEY (`loghtm_id`),
 KEY `reports_id` (`reports_id`)
) ENGINE=InnoDB COMMENT='Сохраненные HTML файлы';");

    DB::statement("CREATE TABLE `log_report` (
 `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID отчета',
 `user_name` varchar(50) NOT NULL COMMENT 'Имя пользователя',
 `f_report` text NOT NULL COMMENT 'Что сделано',
 `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Добавлено',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB COMMENT='Программерский отчет';");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP TABLE IF EXISTS `log_tab`;");
        DB::statement("DROP TABLE IF EXISTS `log_tbh`;");
        DB::statement("DROP TABLE IF EXISTS `log_tjs`;");
        DB::statement("DROP TABLE IF EXISTS `log_htm`;");
        DB::statement("DROP TABLE IF EXISTS `log_report`;");

    }
};
