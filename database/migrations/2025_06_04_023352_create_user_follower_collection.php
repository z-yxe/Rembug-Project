<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * The name of the database connection to use.
     *
     * @var string
     */
    protected $connection = 'mongodb';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $collectionName = 'user_follower';

        if (!Schema::connection($this->connection)->hasCollection($collectionName)) {
            DB::connection($this->connection)->getMongoDB()->createCollection($collectionName);
        }

        Schema::connection($this->connection)->collection($collectionName, function ($collection) {
            $collection->unique(['user_id', 'following_user_id']);
            $collection->index('user_id');
            $collection->index('following_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('user_follower');
    }
};
