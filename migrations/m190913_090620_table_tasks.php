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
        // Create statuses table
        $this->createTable($this->table_status, [
            'id' => Schema::TYPE_PK,
            'status_name' => Schema::TYPE_STRING . '(255) NOT NULL',
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
        $this->dropTable($this->table_tag_task);
        $this->dropTable($this->table_tag);
        $this->dropTable($this->table_task);
        $this->dropTable($this->table_status);
    }

}
