<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('name');
            $table->string('id_proof');
            $table->string('image', 500);
            $table->date('dob');
            $table->string('gender');
            $table->string('p_reports', 500);
            $table->string('id_proof', 500);
            $table->string('is_consent', 100);
            $table->string('c_relationship');
            $table->string('c_relationship_proof', 500);
            $table->string('consent_with_proof', 500);
            $table->string('current_complaints_w_t_duration', 500);
            $table->string('marital_status', 50);
            $table->string('religion', 50);
            $table->string('occupation', 100);
            $table->string('dietary_habits');
            $table->string('last_menstrual_period', 100);
            $table->string('previous_pregnancy_abortion', 300);
            $table->string('vaccination_in_children', 500);
            $table->string('residence', 400);
            $table->string('height', 50);
            $table->string('weight', 50);
            $table->string('pulse', 50);
            $table->string('b_p', 50);
            $table->string('temprature', 50);
            $table->string('blood_suger_fasting', 50);
            $table->string('blood_suger_random', 50);
            $table->string('history_of_previous_diseases', 2000);
            $table->string('history_of_allergies', 1000);
            $table->string('history_of_previous_surgeries_or_procedures', 2000);
            $table->string('significant_family_history', 2000);
            $table->string('history_of_substance_abuse', 2000);

            $table->enum('is_deleted', [0, 1])->comment('0 not deleted 1 deleted')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_lists');
    }
}
