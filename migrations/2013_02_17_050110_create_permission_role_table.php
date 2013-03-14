<?php

/**
 * Migration for creating permission_role table
 */
class Admin_Create_Permission_Role_Table {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_role', function ($table) {
            $table->increments('id');
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->timestamps();
            // Foreign Keys
            $table->foreign('permission_id')->references('id')->on('permissions');
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Revert the changes to the database.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permission_role', function ($table) {
            $table->drop_foreign('permission_role_permission_id_foreign');
            $table->drop_foreign('permission_role_role_id_foreign');
        });
        Schema::drop('permission_role');
    }

}