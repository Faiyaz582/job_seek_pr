<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            // Check if 'status' column does not exist before adding
            if (!Schema::hasColumn('jobs', 'status')) {
                $table->integer('status')->default(1)->after('company_website');
            }

            // Check if 'isFeature' column does not exist before adding
            if (!Schema::hasColumn('jobs', 'isFeature')) {
                $table->integer('isFeature')->default(0)->after('status');
            }

            // Check if 'user_id' column does not exist before adding
            if (!Schema::hasColumn('jobs', 'user_id')) {
                $table->foreignId('user_id')->after('job_type_id')->constrained()->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            // Drop foreign key and 'user_id' column
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            // Drop 'status' and 'isFeature' columns
            $table->dropColumn('status');
            $table->dropColumn('isFeature');
        });
    }
};
