<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('content');
            $table->smallInteger('type');
            $table->boolean('active')->default(1);
            $table->unsignedBigInteger('classroom_id')->nullable();
            $table->json('options')->nullable();
            $table->timestamps();
        });

        DB::table('events')->insert(
            [
                ['type' => 0, 'title' => 'events.curse_silence_title', 'content' => 'events.curse_silence_content', 'options' => NULL],
                ['type' => 0, 'title' => 'events.mirror', 'content' => 'events.mirror_content', 'options' => NULL],
                ['type' => 0, 'title' => 'events.leader', 'content' => 'events.leader_content', 'options' => NULL],
                ['type' => 0, 'title' => 'events.cordiality', 'content' => 'events.cordiality_content', 'options' => NULL],
                ['type' => 0, 'title' => 'events.monty', 'content' => 'events.monty_content', 'options' => NULL],
                ['type' => 1, 'title' => 'events.plague', 'content' => 'events.plague_content', 'options' => '{"hpMin" : 5, "hpMax" : 15}'],
                ['type' => 2, 'title' => 'events.panic', 'content' => 'events.panic_content', 'options' => '{ "hpMin" : 2, "hpMax" : 8 }'],
                ['type' => 2, 'title' => 'events.indigestion', 'content' => 'events.indigestion_content', 'options' => '{ "hpMin" : 2, "hpMax" : 8 }'],
                ['type' => 3, 'title' => 'events.assistant', 'content' => 'events.assistant_content', 'options' => NULL],
                ['type' => 4, 'title' => 'events.breath', 'content' => 'events.breath_content', 'options' => '{ "hpMin" : 5, "hpMax" : 15 }'],
                ['type' => 5, 'title' => 'events.responsibility', 'content' => 'events.responsibility_content', 'options' => '{ "hpMin" : 5, "hpMax" : 15 }'],
                ['type' => 6, 'title' => 'events.walking', 'content' => 'events.walking_content', 'options' => NULL],
                ['type' => 7, 'title' => 'events.silence', 'content' => 'events.silence_content', 'options' => NULL],
                ['type' => 7, 'title' => 'events.helpful', 'content' => 'events.helpful_content', 'options' => NULL],
                ['type' => 8, 'title' => 'events.laugh', 'content' => 'events.laugh_content', 'options' => '{ "hpMin" : 5, "hpMax" : 15, "goldMin": 50, "goldMax": 200 }'],
                ['type' => 9, 'title' => 'events.wisdom', 'content' => 'events.wisdom_content', 'options' => '{ "xpMin" : 10, "xpMax" : 20 }'],
                ['type' => 10, 'title' => 'events.lucky', 'content' => 'events.lucky_content', 'options' => '{"mult": 1, "goldMin": 50, "goldMax": 200}'],
                ['type' => 10, 'title' => 'events.tithes', 'content' => 'events.tithes_content', 'options' => '{"mult": -1, "goldMin": 50, "goldMax": 200}'],
                ['type' => 11, 'title' => 'events.reward', 'content' => 'events.reward_content', 'options' => NULL],
                ['type' => 12, 'title' => 'events.dragon', 'content' => 'events.dragon_content', 'options' => '{"textOK": "events.dragon_content_ok", "textKO": "events.dragon_content_ko", "goldMin": 50, "goldMax": 300, "hpMin": 5, "hpMax": 20}'],
                ['type' => 12, 'title' => 'events.kiwi', 'content' => 'events.kiwi_content', 'options' => '{"textOK": "events.kiwi_content_ok", "textKO": "events.kiwi_content_ko", "goldMin": 50, "goldMax": 200, "hpMin": 1, "hpMax": 15}'],
                ['type' => 13, 'title' => 'events.merchant', 'content' => 'events.merchant_content', 'options' => '{"goldMin": 1, "goldMax": 400}'],
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
