<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Traits\Listingapi;

class RoleController extends Controller
{
    use Listingapi;

    public function list()
    {
        $query = Role::query(); // get all role
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

    public function add(Request $request)
   {
        $role = new Role();
        $role->name =$request->name;
        $role->description=$request->description;
        $role->save();
        $role->permission()->sync($request->input('permission'));
        return message($role);           
    }
    
    public function view($id = null){
        $roles = $id ? Role::findOrFail($id) : Role::all();
    
        if ($roles->isEmpty()) {
            return 'No Data Available First Create User Role';
        }   
            return message($roles);
    }
    
    public function update(Request $request)
   {
        $role = Role::findOrFail($request->id);
        $role->name=$request->name;
        $role->description=$request->description;
        $role->save();
            return response()->json
      ([
                'message' => 'role updated successfully'
        ]);
    }
    function Delete($id){
        $role = Role::findOrFail($id);
        $role->delete();
        return message('Role Data Deleted Successfully'); 
    }
 
}