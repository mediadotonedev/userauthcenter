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
        Schema::table('users', function (Blueprint $table) {
            // افزودن ستون‌های جدید
            $table->string('avatar')->nullable()->comment('عکس پروفایل')->after('name');
            $table->string('nickname')->nullable()->comment('اسم مستعار')->after('avatar');
            $table->string('phone')->index()->unique()->nullable()->comment('شماره موبایل')->after('name');
            $table->timestamp('phone_verified_at')->nullable()->comment('تاریخ تایید شماره موبایل')->after('phone');
            $table->timestamp('birth_date')->nullable()->comment('تاریخ تولد')->after('email_verified_at');
            $table->enum('gender', ['male', 'female'])->nullable()->comment('جنسیت')->after('birth_date');
            $table->bigInteger('fk_client_id')->unique()->nullable()->comment('آیدی کاربر در سیستم مرکزی');
            $table->softDeletes()->comment('softdelete');

            // اصلاح ستون‌های موجود
            $table->string('name')->comment('نام کاربر')->change();
            $table->string('email')->nullable()->index()->comment('ایمیل')->change();
            $table->string('password')->nullable()->comment('رمز عبور')->change();
            $table->timestamp('email_verified_at')->nullable()->comment('تاریخ تایید ایمیل')->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // حذف ایندکس‌های موجود روی ستون email
            if (Schema::hasIndex('users', 'users_email_index')) {
                $table->dropIndex(['email']);
            }
            if (Schema::hasIndex('users', 'users_email_unique')) {
                $table->dropUnique(['email']);
            }

            // حذف ایندکس‌های موجود روی ستون email
            if (Schema::hasIndex('users', 'users_phone_index')) {
                $table->dropIndex(['phone']);
            }
            // حذف ایندکس یکتا روی ستون phone
            if (Schema::hasIndex('users', 'users_phone_unique')) {
                $table->dropUnique(['phone']);
            }

            // حذف ایندکس‌های موجود روی ستون email
            if (Schema::hasIndex('users', 'users_fk_client_id_index')) {
                $table->dropIndex(['fk_client_id']);
            }
            // حذف ایندکس یکتا روی ستون fk_client_id
            if (Schema::hasIndex('users', 'users_fk_client_id_unique')) {
                $table->dropUnique(['fk_client_id']);
            }

            // حذف ستون‌های جدید
            $table->dropColumn(['avatar', 'nickname', 'phone', 'phone_verified_at', 'birth_date', 'gender', 'fk_client_id']);
            $table->dropSoftDeletes();

            // بازگرداندن ستون‌های اصلاح‌شده به حالت اولیه
            $table->string('name')->comment(null)->change();
            $table->string('email')->index()->unique()->comment(null)->nullable(false)->change();
            $table->string('password')->comment(null)->change();
            $table->timestamp('email_verified_at')->nullable()->comment(null)->change();
        });
    }
};
