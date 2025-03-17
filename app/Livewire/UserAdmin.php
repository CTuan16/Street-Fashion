<?php


namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserAdmin extends Component
{
    public $result_user;
    public $editingUser;
    public $showModal = false;
    public $name;
    public $email;
    public $password;
    public $phone;
    public $birthday;
    public $role;
    public $user;
    public $id;
    public $gender;
    public $status;
    public $avatar;
    public $showtogleEdit=false;

    public function mount()
    {
        
        $this->result_user = User::all();
        $this->editingUser = null;
       

    }
    
    public function createUser(){
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8', 
            'phone' => 'required|string|max:15',
            'birthday' => 'required|date',
            'gender' => 'required|in:male,female,other',  
            'role' => 'required|in:admin,customer',  
        ],[
            'name.required' => 'Họ và tên là bắt buộc.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã được sử dụng.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.digits' => 'Số điện thoại phải là 10 chữ số.',
            'date.required' => 'Ngày sinh là bắt buộc.',
            'gender.required' => 'Giới tính là bắt buộc.',
            'role.required' => 'Vai trò là bắt buộc.',


        ]);
        User::create([
            'name'=>$this->name,
            'email'=>$this->email,
            'password'=>Hash::make( $this->password),
            'phone'=>$this->phone,
            'birthday'=>$this->birthday,
            'gender'=>$this->gender,
            'avatar'=>'/img/avt/no_avt.jpg',
            'role' => 'admin'
        ]);
        $this->result_user = User::all();
        $this->showModal=false;
        session()->flash('message', 'Người dùng đã được tạo thành công.');
    }
    public function updatedGender($valuegender){
        $this->gender=$valuegender;

    }
    public function updatedRole($valuerole){
        $this->role=$valuerole;
    }
    public function deleteUser($userId)
    {
    // Tìm người dùng theo ID và xóa
    $user = User::find($userId);
    if ($user) {
        $user->delete();
    }
    $this->result_user = User::all();
    
    // Thông báo hoặc reload dữ liệu (nếu cần)
    session()->flash('message', 'Người dùng đã được xóa.');
    }
    public function editUser($userId){
        if ($this->showtogleEdit) {
            $this->showtogleEdit=false;
     
        }else{
        $this->showtogleEdit=true;

        }

        $this->id=$userId;
        $this->user = User::find($userId);
        $this->status = $this->user->status;
    }

    public function updatedStatus($value)
    {
        // Handle the change logic here
        // For example:
        $this->status=$value;

    }
    public function updateUser()
    {
        User::where('id', $this->id)->update(['status' => $this->status]);
        $this->showtogleEdit=false;
        $this->result_user = User::all();

        session()->flash('message', 'Người dùng sửa thành công!');
    }
    public function openModal(){
        $this->showModal=true;
    }
    public function closeModal()
    {
        
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.user-admin', );
    }
}


