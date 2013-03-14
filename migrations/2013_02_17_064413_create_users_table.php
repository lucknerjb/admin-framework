<?php

/**
 * Migration for creating users table
 */
class Admin_Create_Users_Table {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username', 32)->unique();
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->integer('role_id')->unsigned();
            $table->timestamps();
            // Foreign Keys
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
        Schema::table('users', function ($table) {
            $table->drop_foreign('users_role_id_foreign');
            $table->drop_unique('users_username_unique');
            $table->drop_unique('users_email_unique');
        });
        Schema::drop('users');
    }

}