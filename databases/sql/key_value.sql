CREATE TABLE `key_value` (
    `kv_id` INT NOT NULL AUTO_INCREMENT COMMENT '主键',
    `kv_key` VARCHAR(100) NOT NULL COMMENT '键',
    `kv_value` TEXT COLLATE UTF8MB4_UNICODE_CI COMMENT '值',
    `kv_memo` TEXT COLLATE UTF8MB4_UNICODE_CI COMMENT '备注',
    `kv_status` ENUM('active', 'inactive') NOT NULL DEFAULT 'inactive' COMMENT '状态：active-激活，inactive-未激活',
    `kv_deleted` TINYINT NOT NULL DEFAULT 0 COMMENT '删除标记：0-未删除，1-已删除',
    `kv_created_user_id` INT NOT NULL COMMENT '创建人员ID',
    `kv_created_user` VARCHAR(255) COLLATE UTF8MB4_UNICODE_CI NOT NULL COMMENT '创建人员',
    `kv_updated_user_id` INT NOT NULL COMMENT '更新人员ID',
    `kv_updated_user` VARCHAR(255) COLLATE UTF8MB4_UNICODE_CI NOT NULL COMMENT '更新人员',
    `kv_deleted_user_id` INT NOT NULL DEFAULT 0 COMMENT '删除人员ID',
    `kv_deleted_user` VARCHAR(255) COLLATE UTF8MB4_UNICODE_CI NOT NULL DEFAULT '' COMMENT '删除人员',
    `kv_created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
    `kv_deleted_at` DATETIME NOT NULL DEFAULT '1000-01-01 00:00:00' COMMENT '删除时间',
    `kv_updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
    PRIMARY KEY (`kv_id`),
    UNIQUE KEY `unique_kv_key` (`kv_key`)
)  ENGINE=INNODB DEFAULT CHARSET=UTF8MB4 COLLATE = UTF8MB4_UNICODE_CI COMMENT='键值对数据表';