<?php

namespace SpotzCity\Http\Controllers;

use Illuminate\Http\Request;

use SpotzCity\User;
use SpotzCity\Business;
use SpotzCity\ECategory;
use SpotzCity\ECategoryLink;
use SpotzCity\Commodity;
use SpotzCity\CommodityLink;
use DB;
use Auth;

class AdminController extends Controller
{

    /**
     * Display admin search panel
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
      if(!\Auth::user()->admin){
        flash('Oops. You weren\'t supposed to go there!', 'warning');
        return redirect()->to( route('Dashboard') );
      }
      return view('admin/search');
    }


    public function UserReport()
    {
      if(!\Auth::user()->admin){
        flash('Oops. You weren\'t supposed to go there!', 'warning');
        return redirect()->to( route('Dashboard') );
      }
      //$reports = DB::table("block_list")->where("type","Report")->get();
      // $messages = DB::table('block_list')->where('id',$id)->first();

      $reports = DB::select( DB::raw("SELECT bl.id , bl.from_user_id , bl.block_user_id, bl.message , from_user.display_name as from_name , from_user.email as from_email, to_user.display_name as to_name FROM block_list bl INNER JOIN users as from_user ON from_user.id = bl.from_user_id INNER JOIN users as to_user ON to_user.id = bl.block_user_id WHERE bl.type = 'Report'  ORDER BY id DESC "));
      // dd($reports);

      // foreach ($reports as $key => $value) {
      //   $data[$key] = $value;
      //   $data[$key]->from_user_id = $this->GetUserFromId($value->from_user_id);
      //   $data[$key]->block_user_id = $this->GetUserFromId($value->block_user_id);
      //   // $data[$key]-> = $this->GetUserFromId($value->block_user_id);

      // }
      // //echo "<pre>";print_r($data);
      // //echo $reports;die;

      return view('admin/user-report',["reports"=>$reports]);
    }

    private function GetUserFromId($id){
      return DB::table("users")->where("id",$id)->first();
    }

    /**
     * Display admin edit categories
     *
     * @return \Illuminate\Http\Response
     */
    public function categories()
    {
      if(!\Auth::user()->admin){
        flash('Oops. You weren\'t supposed to go there!', 'warning');
        return redirect()->to( route('Dashboard') );
      }
      return view('admin/categories', [
        'e_categories' => ECategory::orderBy('name', 'asc')->get(),
        'commodities' => Commodity::orderBy('name', 'asc')->get()
      ]);
    }


    /**
     * Delete category
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function deleteCategory( Request $request, $id )
    {
      try {
        ECategoryLink::where('e_category_id', $id)->delete();
        ECategory::find($id)->delete();

        flash('Diversity category deleted!', 'success');
        return redirect()->to('/admin/categories');
      } catch (\Exception $e) {
        flash('Error deleting category.', 'warning');
        return redirect()->to('/admin/categories');
      }
    }


    /**
     * Delete commodity
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteCommodity( Request $request, $id )
    {
      try {
        CommodityLink::where('commodity_id', $id)->delete();
        Commodity::find($id)->delete();

        flash('Commodity category deleted!', 'success');
        return redirect()->to('/admin/categories');
      } catch (\Exception $e) {
        flash('Error deleting commodity.', 'warning');
        return redirect()->to('/admin/categories');
      }
    }


    /**
     * Create category
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function createCategory( Request $request )
    {
      if(!\Auth::user()->admin){
        return abort(403);
      }

      $category = $request->type === 'ecat' ? new ECategory : new Commodity;
      $category->name = $request->name;
      $category->save();

      return $category;
    }


    /**
     * Update category
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function updateCategory( Request $request )
    {
      if(!\Auth::user()->admin){
        return abort(403);
      }

      $category = $request->type === 'ecat' ? ECategory::find($request->id) : Commodity::find($request->id);
      $category->name = $request->name;
      $category->save();

      return $category;
    }


    /**
     * Return user search results
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function searchUsers(Request $request)
    {
      return User::select('id as _id', 'display_name as name', 'email', 'has_business', 'created_at as user_since', 'admin')
        ->when($request->has('keywords'), function($q) use ($request){
          return $q->where(function($q) use ($request){
            foreach($request->input('keywords') as $keyword){
              $q->orWhere('display_name', 'like', "%$keyword%")
                ->orWhere('email', 'like', "%$keyword%");
            }
          });
        })
        ->paginate(15);
    }


    /**
     * Return business search results
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function searchBusinesses(Request $request)
    {
      return Business::select('slug as _id', 'name', 'city', 'state', 'zip', 'rating', 'verified')
        ->when($request->has('keywords'), function($q) use ($request){
          return $q->where(function($q) use ($request){
            foreach($request->input('keywords') as $keyword){
              $q->orWhere('name', 'like', "%$keyword%")
                ->orWhere('city', 'like', "%$keyword%")
                ->orWhere('state', 'like', "%$keyword%")
                ->orWhere('zip', 'like', "%$keyword%");
            }
          });
        })
        ->paginate(15);
    }


    // public function show()
    // {
    //     return view('show', compact('report'));
    // }
}
