<?php

/**
 * Migration for creating roles table
 */
class Admin_Create_Roles_Table {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function ($table) {
            $table->increments('id');
            $table->string('name', 200);
            $table->string('description', 200)->nullable();
            $table->integer('weight')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Revert the changes to the database.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('roles');
    }

}