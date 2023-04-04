<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Modules;
use App\Models\Permission;
use App\Traits\Listingapi;

class ModulesController extends Controller
{ 
    use Listingapi;

    public function list()
    {
        $query = Modules::query(); // get all modules
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
        $rules = array(
             "name"          => "required",
             "description"   => "required|max:255",    
    );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
        return $validator->errors();
    }

        $modules = new Modules();
        $modules->name =$request->name;
        $modules->description=$request->description;
        $modules->save();
        return message($modules);
    }

    public function view($id = null)
   {
        $modules  = $id ? Modules::findOrFail($id) : Modules::all();       
        if ($modules->isEmpty()) {
            return " No Data Found First Create Modules";
        }      
        return message($modules);
    
    }

    public function update(Request $request,$id)
   {
        $modules = Modules::findOrFail($request->id);
        $modules->name=$request->name;
        $modules->description=$request->description;
        $modules->save();
             return message('Modules Data Updated Successfully'); 
    }
    
    function Delete($id){
        $modules = Modules::findOrFail($id);
        $modules->delete(); 
        return message('Modules Data Deleted Successfully'); 
    }

}