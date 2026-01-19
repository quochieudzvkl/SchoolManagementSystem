<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\CloudinaryService;
use App\Models\User;
use Log;

class AdminController extends Controller
{
    protected CloudinaryService $cloudinary;

    public function __construct(CloudinaryService $cloudinary)
    {
        $this->cloudinary = $cloudinary;
    }
    public function admin_list(Request $request)
    {
        $query = User::whereIn('is_admin', array('1', '2'));

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('address')) {
            $query->where('address', 'like', '%' . $request->address . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('is_admin')) {
            $query->where('is_admin', $request->is_admin);
        }

        $adminList = $query
            ->orderBy('id', 'desc')
            ->paginate(20)
            ->appends($request->query());

        $meta_title = "Admin List";

        return view('backend.admin.list', compact('adminList', 'meta_title'));
    }

    public function create_admin()
    {
        $data['meta_title'] = "admin Create";
        return view('backend.admin.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:users,slug',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|min:6',
            'address'     => 'required|string|max:500',
            'status'      => 'required|in:0,1',
            'is_admin' => 'required|in:1,2',
            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {

            // Nếu không nhập slug → tự tạo từ name
            $baseSlug = $request->slug
                ? Str::slug($request->slug)
                : Str::slug($request->name);

            $slug = $baseSlug;
            $count = 1;

            while (User::where('slug', $slug)->exists()) {
                $slug = "{$baseSlug}-{$count}";
                $count++;
            }

            $user = new User();
            $user->name          = $request->name;
            $user->slug          = $slug;
            $user->email         = $request->email;
            $user->password      = bcrypt($request->password);
            $user->address       = $request->address;
            $user->status        = $request->status;
            $user->is_admin      = $request->is_admin;
            $user->created_by_id = Auth::id();
            $user->save();

            // Upload ảnh
            if ($request->hasFile('profile_pic')) {

                $publicId = "{$user->slug}-{$user->id}";

                $upload = $this->cloudinary->uploadImage(
                    $request->file('profile_pic'),
                    'Admin/List',
                    $publicId
                );

                $user->profile_pic = $upload['url'];
                $user->save();
            }

            return redirect()
                ->route('cpanel.admin')
                ->with('success', 'Admin đã được tạo thành công!');
        } catch (\Exception $e) {

            Log::error('Error creating admin', [
                'message' => $e->getMessage(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi tạo admin.');
        }
    }

    public function edit_admin(User $user)
    {
        $adminlist = $user;
        $meta_title = "Admin Edit";
        return view('backend.admin.edit', compact('adminlist', 'meta_title'));
    }

    public function update(Request $request, $slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();

        $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:users,slug,' . $user->id,
            'email'       => 'sometimes|nullable|email|unique:users,email,' . $user->id,
            'password'    => 'nullable|min:6',
            'address'     => 'required|string|max:500',
            'status'      => 'required|in:0,1',
            'is_admin' => 'required|in:1,2',
            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {

            $baseSlug = $request->slug
                ? Str::slug($request->slug)
                : Str::slug($request->name);

            $slug = $baseSlug;
            $count = 1;

            while (
                User::where('slug', $slug)
                ->where('id', '!=', $user->id)
                ->exists()
            ) {
                $slug = "{$baseSlug}-{$count}";
                $count++;
            }

            $user->name    = $request->name;
            $user->slug    = $slug;
            $user->email   = $request->email;
            $user->address = $request->address;
            $user->status  = $request->status;
            $user->is_admin = $request->is_admin;

            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }

            $user->save();

            if ($request->hasFile('profile_pic')) {

                $publicId = "{$user->slug}-{$user->id}";

                $upload = $this->cloudinary->uploadImage(
                    $request->file('profile_pic'),
                    'Admin/List',
                    $publicId
                );

                $user->profile_pic = $upload['url'];
                $user->save();
            }

            return redirect()
                ->route('cpanel.admin')
                ->with('success', 'Cập nhật admin thành công!');
        } catch (\Exception $e) {

            Log::error('Error updating admin', [
                'message' => $e->getMessage(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi cập nhật admin.');
        }
    }

    public function destroy(User $user)
    {
        if ($user->profile_pic && Storage::exists($user->profile_pic)) {
            Storage::delete($user->profile_pic);
        }

        $user->delete();

        return redirect()
            ->route('cpanel.admin')
            ->with('success', 'admin đã được xóa thành công.');
    }
}
