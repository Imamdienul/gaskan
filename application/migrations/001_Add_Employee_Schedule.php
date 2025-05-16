<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Employee_Schedule extends CI_Migration {
    public function up() {
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ],
            'day_of_week' => [
                'type' => 'VARCHAR',
                'constraint' => 10
            ],
            'is_working_day' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1
            ],
            'custom_holiday_reason' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ]
        ]);

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('employee_schedules', TRUE);
    }

    public function down() {
        $this->dbforge->drop_table('employee_schedules', TRUE);
    }
}
