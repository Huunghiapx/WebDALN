<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Xóa bảng nếu tồn tại
        Schema::dropIfExists('users');

        // Tạo lại bảng 'users'
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // ID tự động tăng
            $table->string('name'); // Tên người dùng
            $table->string('phone_number', 20)->nullable(); // Số điện thoại, có thể null
            $table->string('image')->nullable(); // Đường dẫn ảnh, có thể null
            $table->string('address', 255)->nullable(); // Địa chỉ, có thể null
            $table->string('email')->unique(); // Email, giá trị phải là duy nhất
            $table->timestamp('email_verified_at')->nullable(); // Thời gian xác nhận email, có thể null
            $table->string('password'); // Mật khẩu
            $table->enum('role', ['customer', 'admin'])->default('customer'); // Phân quyền người dùng, mặc định là customer
            $table->rememberToken(); // Token để ghi nhớ đăng nhập
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }

    public function down()
    {
        // Xóa bảng 'users' nếu cần rollback
        Schema::dropIfExists('users');
    }
};
