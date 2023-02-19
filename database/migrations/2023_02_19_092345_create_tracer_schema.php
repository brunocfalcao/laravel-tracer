<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /**
         * Schema table creation of the visits table.
         */
        Schema::create('visits', function (Blueprint $table) {
            $table->id();

            $table->string('session_id')
                  ->nullable()
                  ->comment('Session id (php session id) from the visit source');

            $table->foreignId('user_id')
                  ->nullable()
                  ->comment('Relatable user id, if existing');

            $table->foreignId('course_id')
                  ->nullable()
                  ->default(null)
                  ->comment('Related course id in case it exists');

            $table->foreignId('goal_id')
                  ->nullable()
                  ->comment('If a goal (E.g.: "course bought") is achieved, is it written here');

            $table->foreignId('affiliate_id')
                  ->nullable()
                  ->comment('Affilate related id, if exists and is connected to via referrer data. Session persisted');

            $table->string('url')
                  ->comment('The full qualified url path, with querystrings');

            $table->string('path')
                  ->comment('The url path, not including the full url');

            $table->string('route_name')
                  ->nullable()
                  ->comment('Route name in case it exists');

            $table->string('referrer_utm_source')
                  ->nullable()
                  ->comment('Referrer utm_source querystring, e.g.: ?utm_source=xxx, if it exists');

            $table->string('referrer_domain')
                  ->nullable()
                  ->comment('Referrer url http header if it is present');

            $table->string('referrer_campaign')
                  ->nullable()
                  ->comment('Querystring ?cmpg=xxx if it is present');

            $table->boolean('is_bot')
                  ->default(false);

            $table->ipAddress('ip')
                  ->nullable();

            $table->string('hash') // GDPR reasons. Identifies a visit source.
                  ->nullable()
                  ->comment('The visit hashable identity. GDPR, is encrypted. Created as md5(request()->ip().Agent::platform().Agent::device())');

            $table->string('continent')
                  ->nullable();

            $table->string('continentCode')
                  ->nullable();

            $table->string('country')
                  ->nullable();

            $table->string('countryCode')
                  ->nullable();

            $table->string('region')
                  ->nullable();

            $table->string('regionName')
                  ->nullable();

            $table->string('city')
                  ->nullable();

            $table->string('district')
                  ->nullable();

            $table->string('zip')
                  ->nullable();

            $table->decimal('latitude', 11, 7)
                  ->nullable();

            $table->decimal('longitude', 11, 7)
                  ->nullable();

            $table->string('timezone')
                  ->nullable();

            $table->string('currency')
                  ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracer_schema');
    }
};
