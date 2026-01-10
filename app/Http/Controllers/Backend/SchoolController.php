<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\CloudinaryService;
use Log;

class SchoolController extends Controller
{
    protected CloudinaryService $cloudinary;

    public function __construct(CloudinaryService $cloudinary)
    {
        $this->cloudinary = $cloudinary;
    }
    public function school_list(Request $request)
    {
        $query = User::where('is_admin', 3);

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

        $schoolList = $query
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->appends($request->query()); 

        $meta_title = "School List";

        return view('backend.school.list', compact('schoolList', 'meta_title'));
    }


    public function create_school()
    {
        $data['meta_title'] = "School Create";
        return view('backend.school.create', $data);
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
            $user->is_admin      = 3;
            $user->created_by_id = Auth::id();
            $user->save();

            // Upload ảnh
            if ($request->hasFile('profile_pic')) {

                $publicId = "{$user->slug}-{$user->id}";

                $upload = $this->cloudinary->uploadImage(
                    $request->file('profile_pic'),
                    'School/List',
                    $publicId
                );

                $user->profile_pic = $upload['url'];
                $user->save();
            }

            return redirect()
                ->route('cpanel.school')
                ->with('success', 'Trường học đã được tạo thành công!');
        } catch (\Exception $e) {

            Log::error('Error creating school', [
                'message' => $e->getMessage(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi tạo trường học.');
        }
    }

    public function edit($slug)
    {
        $schoollist = User::where('slug', $slug)->firstOrFail();
        $meta_title = "School Edit";
        return view('backend.school.edit', compact('schoollist' , 'meta_title'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:users,slug,' . $user->id,
            'email'       => 'required|email|unique:users,email,' . $user->id,
            'password'    => 'nullable|min:6',
            'address'     => 'required|string|max:500',
            'status'      => 'required|in:0,1',
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

            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }

            $user->save();

            if ($request->hasFile('profile_pic')) {

                $publicId = "{$user->slug}-{$user->id}";

                $upload = $this->cloudinary->uploadImage(
                    $request->file('profile_pic'),
                    'School/List',
                    $publicId
                );

                $user->profile_pic = $upload['url'];
                $user->save();
            }

            return redirect()
                ->route('cpanel.school')
                ->with('success', 'Cập nhật trường học thành công!');
        } catch (\Exception $e) {

            Log::error('Error updating school', [
                'message' => $e->getMessage(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi cập nhật trường học.');
        }
    }

    public function toggleStatus($id)
    {
        $school = User::findOrFail($id);

        $school->status = $school->status == 1 ? 0 : 1;
        $school->save();

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công');
    }

    public function destroy(User $school)
    {
        if ($school->profile_pic && Storage::exists($school->profile_pic)) {
            Storage::delete($school->profile_pic);
        }

        $school->delete();

        return redirect()
            ->route('cpanel.school')
            ->with('success', 'Trường học đã được xóa thành công.');
    }
}
