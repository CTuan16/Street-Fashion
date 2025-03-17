<?php

namespace App\Http\Controllers\Admin;

use App\Models\Group_Module;
use App\Models\Log_activities;
use App\Models\Modules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
class BaseController extends Controller
{
    protected $user;
    protected $title = 'Title';

    public function __construct()
{
    $permissionPrefix = str_replace('-', '', ucwords(request()->segment(2), '-')); // Xử lý tên phân đoạn

    if (!empty($permissionPrefix)) {
        // Thiết lập các middleware cho các hành động
        $permissions = [
            "{$permissionPrefix}-view",
            "{$permissionPrefix}-create",
            "{$permissionPrefix}-edit",
            "{$permissionPrefix}-delete",
            "{$permissionPrefix}-import",
            "{$permissionPrefix}-export",
        ];

        // Middleware chung cho 'index' và 'store'
        $this->middleware('can:' . implode('|', $permissions), ['only' => ['index', 'store']]);

        // Các middleware riêng cho từng hành động
        $this->middleware('can:' . "{$permissionPrefix}-create", ['only' => ['create', 'store']]);
        $this->middleware('can:' . "{$permissionPrefix}-edit", ['only' => ['edit', 'update']]);
        $this->middleware('can:' . "{$permissionPrefix}-delete", ['only' => ['destroy']]);
        $this->middleware('can:' . "{$permissionPrefix}-import", ['only' => ['import']]);
        $this->middleware('can:' . "{$permissionPrefix}-export", ['only' => ['export']]);
    }

    // Middleware bổ sung cho việc khởi tạo người dùng và lấy module
    $this->middleware(function ($request, $next) {
        $this->user = Auth::user();
        $this->getListModule();  // Gọi phương thức để lấy danh sách module
        return $next($request);
    });
}



    public function getListModule()
    {
        $user_permission = $this->user->getPermissionsViaRoles()->pluck('name');
        $arr_module = [];
        foreach ($user_permission as $permisstion) {
            $string = explode('-', $permisstion);
            $arr_module[] = strtolower(preg_replace('/(?<!^)([A-Z])/', '-$1', $string[0]));
        }
        $groupModules = Cache::get('menu-aside');
        // If the menu is not available in cache, generate it and store in cache
        if ($groupModules === null) {
            if ($this->user->hasRole('Super Admin') || $this->user->hasRole('Admin')) {
                $modules = Modules::get();
            } else {
                $modules = Modules::whereIn('uri', array_unique($arr_module))->get();
            }
            $groupModules = [];

            // Loop through group modules to create an array with group module ids as keys

            foreach (Group_Module::all() as $groupModule) {
                $groupModules[$groupModule->id] = (object) [
                    'group_module_name' => $groupModule->group_module_name,
                    'children' => []
                ];
            }
            foreach ($modules as $module) {
                $groupModuleId = $module->group_module_id;
                if (isset($groupModules[$groupModuleId])) {
                    $groupModules[$groupModuleId]->children[] = $module;
                }
            }
            $groupModules = array_filter($groupModules, function ($item) {
                return !empty($item->children);
            });
            // Store the menu in cache for 60 minutes
            Cache::put('menu-aside', $groupModules, 5);
        }
        View::share(['groupModule' => $groupModules, 'title'=>$this->title]);
    }

    public function addToLog(Request $request)
    {
        $tmpStr = '******';
        $listParamNeedProtect = ['password','current_password','password_confirmation'];
        $listParamNeedRemove = ['_token','_pjax','_method'];
        $data = $request->input();
        foreach($listParamNeedRemove as $key){
            if($request->$key){
                unset($data[$key]);
            }
        };
        foreach($listParamNeedProtect as $key){
            if($request->$key){
                $data[$key] = $tmpStr;
            }
        };
        $log = [];
        $log['param'] = !empty($data) ? json_encode($data) : '';
        $log['url'] = request()->url();
        $log['method'] = request()->method();
        $log['ip'] = request()->ip();
        $log['agent'] = request()->header('user-agent');
        $log['user_id'] = Auth::check() ? Auth::user()->id : 1;
        Log_activities::create($log);
    }
}
