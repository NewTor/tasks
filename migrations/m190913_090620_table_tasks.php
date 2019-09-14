<?php
use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m190913_090620_table_tasks
 */
class m190913_090620_table_tasks extends Migration
{
    /**
     * @var string $table_order
     */
    private $table_task = 'tasks';
    /**
     * @var string $table_order
     */
    private $table_tag = 'tags';
    /**
     * @var string $table_order
     */
    private $table_tag_task = 'tags_tasks';
    /**
     * @var string $table_order
     */
    private $table_status = 'status';
    /**
     * Apply migration
     * @return void
     */
    public function up()
    {
        // Create function uuid_v4
        $sql = "DROP FUNCTION IF EXISTS `uuid_v4` ;
                DELIMITER $$
                CREATE DEFINER=`root`@`%` FUNCTION `uuid_v4` () RETURNS CHAR(36) CHARSET utf8 BEGIN
                SET @h1 = LPAD(HEX(FLOOR(RAND() * 0xffff)), 4, '0');
                SET @h2 = LPAD(HEX(FLOOR(RAND() * 0xffff)), 4, '0');
                SET @h3 = LPAD(HEX(FLOOR(RAND() * 0xffff)), 4, '0');
                SET @h6 = LPAD(HEX(FLOOR(RAND() * 0xffff)), 4, '0');
                SET @h7 = LPAD(HEX(FLOOR(RAND() * 0xffff)), 4, '0');
                SET @h8 = LPAD(HEX(FLOOR(RAND() * 0xffff)), 4, '0');
                SET @h4 = CONCAT('4', LPAD(HEX(FLOOR(RAND() * 0x0fff)), 3, '0'));
                SET @h5 = CONCAT(HEX(FLOOR(RAND() * 4 + 8)),
                LPAD(HEX(FLOOR(RAND() * 0x0fff)), 3, '0'));
                RETURN LOWER(CONCAT(@h1, @h2, '-', @h3, '-', @h4, '-', @h5, '-', @h6, @h7, @h8));
                END$$
                DELIMITER ;";
        $this->execute($sql);
        // Create statuses table
        $this->createTable($this->table_status, [
            'id' => Schema::TYPE_PK,
            'status_name' => Schema::TYPE_STRING . '(255) NOT NULL',
        ]);
        //Insert statuses
        $this->batchInsert(
            $this->table_status, ['status_name'], [
            ['Новая'],
            ['В работе'],
            ['Завершена'],
        ]);
        // Create tasks table
        $this->createTable($this->table_task, [
            'id' => Schema::TYPE_PK,
            'status_id' => Schema::TYPE_INTEGER . '(11) NOT NULL DEFAULT 0',
            'name' => Schema::TYPE_TEXT . ' NOT NULL',
            'priority' => 'ENUM("0", "1", "2") NOT NULL DEFAULT "0"',
            'uuid' => Schema::TYPE_STRING . '(255) NOT NULL',
        ]);
        // Create tags table
        $this->createTable($this->table_tag, [
            'id' => Schema::TYPE_PK,
            'tag_name' => Schema::TYPE_STRING . '(255) NOT NULL',
        ]);
        // Create tags_tasks table
        $this->createTable($this->table_tag_task, [
            'id' => Schema::TYPE_PK,
            'task_id' => Schema::TYPE_INTEGER . '(11) NOT NULL DEFAULT 0',
            'tag_id' => Schema::TYPE_INTEGER . '(11) NOT NULL DEFAULT 0',
        ]);
        // Create foreign key for tags table
        $this->addForeignKey(
            'fbx_task_tag_id',
            $this->table_tag_task,
            'task_id',
            $this->table_task,
            'id',
            'CASCADE'
        );
        // Create foreign key for tags table
        $this->addForeignKey(
            'fbx_tag_task_id',
            $this->table_tag_task,
            'tag_id',
            $this->table_tag,
            'id',
            'CASCADE'
        );
        // Create foreign key for tasks table
        $this->addForeignKey(
            'fbx_status_id',
            $this->table_task,
            'status_id',
            $this->table_status,
            'id',
            'CASCADE'
        );
    }
    /**
     * Revert migration
     * @return void
     */
    public function down()
    {
        $sql = "DROP FUNCTION IF EXISTS `uuid_v4`;";
        $this->execute($sql);
        $this->dropTable($this->table_tag_task);
        $this->dropTable($this->table_tag);
        $this->dropTable($this->table_task);
        $this->dropTable($this->table_status);
    }

}
