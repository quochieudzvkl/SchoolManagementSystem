<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Container\Attributes\Log;

class SchoolController extends Controller
{
    public function school_list()
    {
        $data['meta_title'] = "School List";
        return view('backend.school.list', $data);
    }

    public function create_school()
    {
        $data['meta_title'] = "School Create";
        return view('backend.school.create', $data);
    }

    public function store(Request $request)
    {
        // 1. Validation dữ liệu đầu vào
        // $validated = $request->validate([
        //     'name'       => 'required|string|max:255',
        //     'email'      => 'required|email|unique:users,email',
        //     'password'   => 'required|min:6|confirmed',
        //     'address'    => 'nullable|string|max:500',
        //     'status'     => 'required|in:0,1',
        //     'profile_pic'=> 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // max 2MB
        // ]);

        try {
            // 2. Tạo user (school)
            $user = new User;
            $user->name           = $request->name;
            $user->email          = $request->email;
            $user->password       = bcrypt($request->password);
            $user->address        = $request->address;
            $user->status         = $request->status;
            $user->is_admin       = 3; // role school
            $user->created_by_id  = Auth::user()->id;
            $user->save();

            // 3. Upload ảnh profile lên Cloudinary (nếu có)
            if ($request->hasFile('profile_pic')) {
                $file = $request->file('profile_pic');

                if ($file->isValid()) {
                    // Upload lên Cloudinary
                    $upload = Cloudinary::upload($file->getRealPath(), [
                        'folder'         => 'users/profile',
                        'resource_type'  => 'image',
                        'overwrite'      => true,
                        'quality'        => 'auto',
                        'fetch_format'   => 'auto',
                    ]);

                    // Lấy URL an toàn (secure_url)
                    if ($upload && method_exists($upload, 'getSecurePath')) {
                        $user->profile_pic = $upload->getSecurePath();
                    } else {
                        // Dự phòng nếu package trả về array (một số version cũ/mới)
                        $result = $upload ? $upload->getArrayCopy() : [];
                        $user->profile_pic = $result['secure_url'] ?? null;
                    }

                    // Lưu lại URL ảnh vào DB
                    if ($user->profile_pic) {
                        $user->save();
                    }
                }
            }

            // 4. Thành công
            return redirect()
                ->route('cpanel.school') // thay bằng tên route list school của bạn
                ->with('success', 'Trường học đã được tạo thành công!');

        } catch (ValidationException $e) {
            // Lỗi validation → Laravel tự redirect back với errors
            throw $e;

        } catch (\Exception $e) {
            // Lỗi bất ngờ (Cloudinary, DB, v.v.)
            \Log::error('Error creating school: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi tạo trường học. Vui lòng thử lại.');
        }
    }
}
