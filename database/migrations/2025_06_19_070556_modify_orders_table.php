<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Examples of modification:

            // Add a new column (if needed)
            // $table->string('tracking_number')->nullable()->after('status');

            // Change existing column type (use change() method)
            // $table->string('status', 50)->default('pending')->change();

            // Drop a column
            // $table->dropColumn('old_column_name');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Reverse the changes from up()

            // For example, to drop tracking_number:
            // $table->dropColumn('tracking_number');

            // To revert status change:
            // $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending')->change();
        });
    }
}