<?php

use App\Models\Employer;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employers', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            // here relationship is that every user can own a company and can add some job offers in the name of this employer of this company
            // we add nullabe(should be before constrained) because not all users will be offering jobs, most users will be searching for jobs
            $table->foreignIdFor(User::class)->nullable()->constrained();
            $table->timestamps();
        });
        // modifying jobPosts table
        // every jobs comes for certain employer so we need to have employer id on jobs
        Schema::table('job_posts', function (Blueprint $table) {
            $table->foreignIdFor(Employer::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // here we drop the employers table but we need to be careful not to do that before we remove the foreign key and after we drop this foreign key, only then we can remove the employers table,otherwise this will cause error

        Schema::table('job_posts', function (Blueprint $table) {
            $table->dropForeignIdFor(Employer::class);
        });
        Schema::dropIfExists('employers');
    }
};
