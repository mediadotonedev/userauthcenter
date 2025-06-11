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
            $table->string('phone')->unique()->index()->nullable()->comment('شماره موبایل')->after('nickname');
            $table->timestamp('phone_verified_at')->nullable()->comment('تاریخ تایید شماره موبایل')->after('phone');
            $table->timestamp('birth_date')->nullable()->comment('تاریخ تولد')->after('email_verified_at');
            $table->enum('gender', ['male', 'female'])->nullable()->comment('جنسیت')->after('birth_date');
            $table->bigInteger('fk_client_id')->nullable()->comment('آیدی کاربر در سیستم مرکزی');
            $table->softDeletes()->comment('حذف نرم');

            // اصلاح ستون‌های موجود
            $table->string('name')->comment('نام کاربر')->nullable()->change();
            $table->string('email')->nullable()->index()->comment('ایمیل')->change();
            $table->string('password')->comment('رمز عبور')->change();
            $table->timestamp('email_verified_at')->nullable()->comment('تاریخ تایید ایمیل')->change();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
            Schema::table('users', function (Blueprint $table) {
                // حذف ستون‌های جدید
                $table->dropColumn(['avatar', 'nickname', 'phone', 'phone_verified_at', 'birth_date', 'gender', 'fk_client_id']);
                $table->dropSoftDeletes();

                // بازگرداندن ستون‌های اصلاح‌شده به حالت اولیه
                $table->string('name')->comment(null)->nullable(false)->change();
                $table->string('email')->unique()->index(false)->comment(null)->nullable(false)->change();
                $table->string('password')->comment(null)->change();
                $table->timestamp('email_verified_at')->nullable()->comment(null)->change();
        });
    }
};
