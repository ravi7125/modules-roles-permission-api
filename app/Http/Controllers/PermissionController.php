<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Permission;
use App\Models\Module_Permission;
use App\Models\Modules;
use App\Models\Role;
use App\Traits\Listingapi;


class PermissionController extends Controller
{     
       
    use Listingapi;

    public function list()
   {
        $query = Permission::query(); // get all modules
        $searchable_fields = ['name']; // fields to search
    
        // validate request
        $this->ListingValidation();
    
        // filter, search and paginate data
        $data = $this->filterSearchPagination($query, $searchable_fields);
    
        // return response
        return response()->json([
            'success' => true,
            'data' => $data['query']->get(),
            'total' => $data['count']
        ]);
    }

    public function add(Request $request){
    
        $permission = Permission::create($request->only('name', 'description'));

    foreach ($request->input('modules') as $modules) {
        $module_permission = new Module_Permission([
            'modules_id' => $modules['modules_id'],
            'add_access'     => $modules['add_access'],
            'delete_access'  => $modules['delete_access'],
            'view_access'    => $modules['view_access'],
            'edit_access'    => $modules['edit_access'],        
        ]);
        $permission->access()->save($module_permission);
    }
            return message($permission);
      
    }
// show id throw Permission
    public function view($id = null){
        $permissions = $id ? Permission::findOrFail($id) : Permission::all();
        if ($permissions->isEmpty()) {
            return 'No data available first create permission';
        }
            return message($permissions);
    }

//update Permission 
    public function update(Request $request, $id)
   {
        $permission = Permission::findOrFail($id);
        $permission->name = $request->input('name');
        $permission->description = $request->input('description');
        $permission->save();
        return message('Permission Data updated successfully'); 
       
    }
//delete Permission.. 
    function Delete($id){
        $permission = Permission::findOrFail($id);
        $permission->delete(); 
        return message('Permission Data successfully deleted'); 
    }
 
}