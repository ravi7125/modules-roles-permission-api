<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\job;
use App\Traits\Listingapi;
class JobController extends Controller
{
    use Listingapi;

    public function list(Request $request)
   {
        $validaiton = Validator::make($request->all(), [
            'page'    => 'required',
            'perpage' => 'required',
            'search'  => 'required',
       
        ]);   
        if ($validaiton->fails())
            return $validaiton->errors();
        $query = job::query(); // get all modules
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
    $validaiton = Validator::make($request->all(), [
        "name"          => "required",
        "description"   => "required|max:255", 

    ]);   
    if ($validaiton->fails())
        return $validaiton->errors();
        $job = new job();
        $job->name =$request->name;
        $job->description=$request->description;
        $job->save();
        return message($job);
    }

// show modules
    public function view($id = null){
        $job = $id ? job::findOrFail($id) : job::all();

        if ($job->isEmpty()) {
            return 'Data is not available';
     }
        return message($job);
    }

//modules update 
    public function update(Request $request,$id)
   {
        $job = job::findOrFail($request->id);
        $job->name=$request->name;
        $job->description=$request->description;
        $job->save();
            return response()->json([
            'message' => 'job updated successfully'
        ]);
    }
//Delete modules data.. 
    function Delete($id){
        $job = job::findOrFail($id);
        $job->delete();     
            return message('Job data deleted');
    }
}
