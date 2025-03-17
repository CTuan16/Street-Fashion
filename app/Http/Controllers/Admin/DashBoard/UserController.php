<?php

namespace App\Http\Controllers\Admin\DashBoard;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\DataTables\Admin\UserDataTable;
use App\Http\Requests\UserStoreRequest;
use App\Http\Controllers\Admin\BaseController;

class UserController extends BaseController
{
    public $model;
    public function __construct()
    {
        parent::__construct();
        $this->title = 'List User';
        $this->model = new User();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserDataTable $dataTable, Request $request)
    {
        return $dataTable->render('admin.user.index');
    }

    public function create()
    {
        $role = Role::get();
        return view('admin.user.create')->with(['role'=>$role]);
    }

    public function store(UserStoreRequest $request)
    {
        // Xác định role và role_id trước
        if(!empty($request->administrator)) {
            $role = Role::firstOrCreate(['name' => 'Admin']);
            $roleId = 1;  // Set role_id = 1 cho Admin
        } else {
            $role = Role::firstOrCreate(['name' => $request->role]);
            $roleId = $role->id;
        }
    
        // Merge tất cả dữ liệu cần thiết
        $request->merge([
            'password' => Hash::make($request->password),
            'created_at' => auth()->user()->id,
            'role_id' => $roleId  // Thêm role_id đã xác định
        ]);
    
        // Tạo user với role_id đã được set
        $user = User::create($request->only([
            'name', 
            'email', 
            'password',
            'role_id'
        ]));
    
        // Sync role
        $user->syncRoles([$role->name]);
    
        return redirect()->route('user.index')->with([
            'status' => 'success', 
            'html' => 'Thành công'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $role = Role::get();
        $user = User::find($id);
        
        return view('admin.user.edit')->with(['user'=>$user, 'role'=>$role]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,$id",
            'password' => 'nullable|min:6',
            'password_confirmation' => 'nullable|same:password',
            'role_id' => 'required|string',
        ]);
    
        $request->request->remove('password_confirmation');
        
        // Chuẩn bị dữ liệu cập nhật
        $updateData = ['name', 'email'];
        
        if($request->password != null){
            $request->merge([
                'password' => Hash::make($request->password),
                'created_at' => auth()->user()->id
            ]);
            $updateData[] = 'password';
        }
    
        $user = User::find($id);
        
        // Xác định role trước
        if (!empty($request->administrator)) {
            $role = Role::firstOrCreate(['name' => 'Super Admin']);
            // Set role_id = 1 cho Super Admin
            $request->merge(['role_id' => 1]);
        } else {
            $role = Role::firstOrCreate(['name' => $request->role]);
            // Set role_id tương ứng với role được chọn
            $request->merge(['role_id' => $role->id]);
        }
        
        // Thêm role_id vào dữ liệu cập nhật
        $updateData[] = 'role_id';
        
        // Cập nhật user với dữ liệu đã chuẩn bị
        $user->update($request->only($updateData));
        
        // Sync role
        $user->syncRoles($role);
        
        $this->addToLog($request);
        return redirect()->route('user.index')->with(['status'=>'success', 'html' => 'Thành công']);
    }
    public function login(Request $request)
    {
        auth()->loginUsingId($request->id);
        return redirect()->intended('/admin');
    }

    public function destroy(Request $request)
    {
        $user = User::find($request->id);
    
        if (!$user) {
            return response()->json(['message' => 'Người dùng không tồn tại!'], 404);
        }
    
        $user->delete();
        $this->addToLog($request);
    
        return response()->json(['message' => 'Xóa thành công!']);
    }
}
