<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRoles;
use Hash;
use App\Traits\Listingapi;
class UserController extends Controller
{
    use Listingapi;

    public function list()
    {
        $query = User::query(); // get all user
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

    public function view($id = null){
        $users = $id ? User::findOrFail($id) : User::all();
    
        if ($users->isEmpty()) {
            return 'No Data Available First Create a User';
        }
    
        return $users;
    }
    
    public function update(Request $request)
   {
        $user = User::findOrFail($request->id);
        $user->name=$request->name;
        $user->email =$request->email;
        $user->phone =$request->phone;
        $user->password =$request->password;
   
        $user->save();
            return response()->json([
                'message' => 'user updated successfully'
        ]);
    }
//delete modules data.. 
    function Delete($id){
        $user = User::findOrFail($id);
        $user->delete();
        return message('User Data Deleted Successfully'); 
    }

}

