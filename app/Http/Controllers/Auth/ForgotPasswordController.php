<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\ResetPasswordMail;
use Throwable;

class ForgotPasswordController extends Controller
{
    /**
     * Form nhập email quên mật khẩu
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Gửi link reset mật khẩu
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // 1️⃣ Kiểm tra email có tồn tại
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withErrors([
                    'email' => 'Email không tồn tại trong hệ thống.'
                ])
                ->withInput();
        }

        try {
            // 2️⃣ Tạo token
            $token = Str::random(64);

            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $user->email],
                [
                    'token' => Hash::make($token),
                    'created_at' => Carbon::now(),
                ]
            );

            // 3️⃣ Link reset (CHUẨN: token + email)
            $resetLink = route('password.reset', [
                'token' => $token,
                'email' => $user->email,
            ]);

            // 4️⃣ Gửi mail
            Mail::to($user->email)->send(
                new ResetPasswordMail($resetLink)
            );

            return back()->with('success', 'Link reset mật khẩu đã được gửi về email.');
        } catch (Throwable $e) {
            // Log để dev xem, user không thấy 500
            logger()->error('Reset password mail error', [
                'email' => $request->email,
                'message' => $e->getMessage(),
            ]);

            return back()->withErrors([
                'email' => 'Không thể gửi email. Vui lòng thử lại sau.'
            ]);
        }
    }

    /**
     * Form nhập mật khẩu mới
     */
    public function showResetForm(Request $request, $token)
    {
        $email = $request->query('email');

        return view('auth.reset-password', compact('token', 'email'));
    }

    /**
     * Reset mật khẩu
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        // Token không tồn tại hoặc sai
        if (!$record || !Hash::check($request->token, $record->token)) {
            return back()->withErrors([
                'email' => 'Link reset không hợp lệ.'
            ]);
        }

        // ⏱ TOKEN HẾT HẠN SAU 1 PHÚT
        if (Carbon::parse($record->created_at)->addMinute()->isPast()) {
            return back()->withErrors([
                'email' => 'Link reset đã hết hạn (quá 1 phút).'
            ]);
        }

        // Cập nhật mật khẩu mới
        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        // Xóa token (chỉ dùng 1 lần)
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect()->route('login')
            ->with('success', 'Đổi mật khẩu thành công!');
    }
}
