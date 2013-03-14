<?php

/**
 * Migration for creating permissions table
 */
class Admin_Create_Permissions_Table {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function ($table) {
            $table->increments('id');
            $table->string('name', 32);
            $table->string('description', 200)->nullable();
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
        Schema::drop('permissions');
    }

}