<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            CREATE VIEW clientsandsubscriptionsandpackages AS
            SELECT
                clients.id AS client_id,
                clients.name AS client_name,
                clients.mobile AS client_mobile,
                clients.second_mobile AS client_second_mobile,
                clients.gender AS client_gender,
                clients.birth_date AS client_birth_date,
                clients.diet_restrictions AS client_diet_restrictions,
                clients.email AS client_email,
                clients.job_title AS client_job_title,
                clients.group_id AS client_group,
                clients.client_type AS client_client_type,
                clients.referred_by AS client_referred_by,
                clients.notes AS client_notes,
                clients.profile_image AS client_profile_image,
                clients.status AS client_status,
                clients.code AS client_code,
                subscriptions.id AS subscription_id,
                subscriptions.package_id AS subscription_package_id,
                subscriptions.start_at AS subscription_start_at,
                subscriptions.initial_send_check_in AS subscription_initial_send_check_in,
                subscriptions.payment_method AS subscription_payment_method,
                subscriptions.transaction_number AS subscription_transaction_number,
                subscriptions.transaction_date AS subscription_transaction_date,
                subscriptions.from_phone AS subscription_from_phone,
                subscriptions.to_phone AS subscription_to_phone,
                subscriptions.transaction_type AS subscription_transaction_type,
                subscriptions.notes AS subscription_notes,
                subscriptions.created_by AS subscription_created_by,
                packages.id AS package_id,
                packages.name AS package_name,
                packages.description AS package_description,
                packages.duration AS package_duration,
                packages.price AS package_price,
                packages.hold_limit_days AS package_hold_limit_days,
                groups.id AS group_id,
                groups.name AS group_name
            FROM
                clients
            LEFT JOIN
                subscriptions ON clients.id = subscriptions.client_id
            LEFT JOIN
                packages ON subscriptions.package_id = packages.id
            LEFT JOIN
                groups ON clients.group_id = groups.id
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS clientsandsubscriptionsandpackages');
    }
};
