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
    public function school_list()
    {
        $schoolList = User::where('is_admin', 3)
        ->where('trang_thai', 1)
        ->get();
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
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|min:6',
            'address'     => 'required|string|max:500',
            'status'      => 'required|in:0,1',
            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {
            $user = new User();
            $user->name          = $request->name;
            $user->email         = $request->email;
            $user->password      = bcrypt($request->password);
            $user->address       = $request->address;
            $user->status        = $request->status;
            $user->is_admin      = 3;
            $user->created_by_id = Auth::id();
            $user->save();

            if ($request->hasFile('profile_pic')) {

                $slug = Str::slug($request->name);
                $publicId = "{$slug}-{$user->id}";

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
                'trace'   => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi tạo trường học.');
        }
    }
}