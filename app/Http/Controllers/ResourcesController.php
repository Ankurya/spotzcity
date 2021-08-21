<?php

namespace SpotzCity\Http\Controllers;

use SpotzCity\Resource;
use SpotzCity\ResourceCategory;
use SpotzCity\ResourceCategoryLink;

use Illuminate\Http\Request;

class ResourcesController extends Controller
{
    /**
     * Display a listing of the resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('resources/index', [
          'categories' => ResourceCategory::all()
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $resource = new Resource;
        $resource->name = $request->input('resource_name');
        $resource->type = $request->has('type') ? $request->input('type') : 'N/A';
        $resource->city = $request->input('city');
        $resource->state = $request->input('state');
        $resource->phone = $request->input('phone');
        $resource->website = $request->input('website');
        $resource->user_id = \Auth::user()->id;
        $resource->approved = \Auth::user()->admin;

        $resource->save();

        $resource_category_link = new ResourceCategoryLink;
        $resource_category_link->resource_category_id = $request->input('category');
        $resource->categories()->save($resource_category_link);

        return [
          'success' => true
        ];
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $resource = Resource::find($id);
        $categories = ResourceCategory::all();
        return view('resources/edit', [
          'resource' => $resource,
          'categories' => $categories
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!\Auth::user()->admin){
          flash('Not allowed.', 'warning');
          return redirect()->to(route('Dashboard'));
        }

        $resource = Resource::find($id);
        $resource->name = $request->input('resource_name');
        $resource->type = $request->has('type') ? $request->input('type') : 'N/A';
        $resource->city = $request->input('city');
        $resource->state = $request->input('state');
        $resource->phone = $request->input('phone');
        $resource->website = $request->input('website');
        $resource->user_id = \Auth::user()->id;
        $resource->approved = true;

        $resource->save();

        $resource_category_link = $resource->categories->first();
        $resource_category_link->resource_category_id = $request->input('category');
        $resource_category_link->save();

        flash('Resource approved.', 'success');
        return redirect()->to(route('Dashboard'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Search for resources
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
      // Build query (if $request is empty, simply fetch results)
      if(!$request->has('keywords') && !$request->has('categories')){
        $resources = Resource::with('categories')->where('approved', true)->orderBy('updated_at', 'desc')->paginate(15);
        return $resources;
      }

      $resources = Resource::with('categories')->where('approved', true)->when($request->has('categories'), function($q) use ($request){
        return $q->whereHas('categories', function($q) use ($request) {
          $q->whereIn('resource_category_id', $request->input('categories'));
        });
      })->when($request->has('keywords'), function($q) use ($request){
        return $q->where(function($q) use ($request){
          foreach($request->input('keywords') as $keyword){
            $q->orWhere('type', 'like', "%$keyword%")
              ->orWhere('city', 'like', "%$keyword%")
              ->orWhere('state', 'like', "%$keyword%");
          }
        });
      })->paginate(15);

      return $resources;
    }


}
