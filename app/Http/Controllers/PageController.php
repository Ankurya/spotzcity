<?php

namespace SpotzCity\Http\Controllers;

use SpotzCity\Page;

use Illuminate\Http\Request;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;

class PageController extends Controller
{
    /**
     * Display a listing of the resource. (Admin only)
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( !\Auth::user()->admin ) die(403);

        return view('admin.pages', [
          'pages' => Page::sitePages()->get(),
          'isBlog' => false
        ]);
    }

    /**
     * Display a listing of the blog pages. (Admin only)
     *
     * @return \Illuminate\Http\Response
     */
    public function blogIndex()
    {
        if( !\Auth::user()->admin ) die(403);

        return view('admin.pages', [
          'pages' => Page::blogs()->get(),
          'isBlog' => true
        ]);
    }

    /**
     * Show the form for creating a new resource. (Admin only)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create( Request $request )
    {
      if( !\Auth::user()->admin ) die(403);

      return view('admin.create-page', [
        'blog' => $request->query('blog')
      ]);
    }

    /**
     * Store a newly created resource in storage. (Admin only)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if( !\Auth::user()->admin ) die(403);

      try {
        $page = new Page;
        $page->title = $request->title;
        $page->slug = $request->slug;
        $page->active = $request->active === 'on' ? true : false;
        $page->sidebar = $request->sidebar === 'on' ? true : false;
        $page->public = $request->public === 'on' ? true : false;
        $page->show_in_nav = $request->show_in_nav === 'on' ? true : false;
        $page->show_in_footer = $request->show_in_footer === 'on' ? true : false;
        $page->content = $request->content;
        $page->blog = $request->has( 'blog' );
        $page->save();
      } catch (\Exception $e) {
        Bugsnag::notifyException( $e );
        flash()->error($e->getMessage());
        return redirect()->to( route( 'Create Page' ) );
      }

      if($page->blog) {
        flash()->success( 'Blog Created!' );
        return redirect()->to( route( 'Blogs' ) );
      } else {
        flash()->success( 'Page Created!' );
        return redirect()->to( route( 'Pages' ) );
      }
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $page = Page::where( 'slug', $slug )->firstOrFail();

        if( !$page->public && !auth()->check() ) {
          return redirect()->to( route( 'login' ) );
        }

        return view( 'page', [
          'page' => $page
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function edit( Request $request )
    {
      if( !\Auth::user()->admin ) die(403);

      return view('admin.edit-page', [
        'page' => Page::find( $request->id ),
        'blog' => $request->query('blog')
      ]);
    }

    /**
     * Update the specified resource in storage. (Admin only)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      if( !\Auth::user()->admin ) die(403);

      try {
        $page = Page::find( $id );
        $page->title = $request->title;
        $page->slug = $request->slug;
        $page->active = $request->active === 'on' ? true : false;
        $page->sidebar = $request->sidebar === 'on' ? true : false;
        $page->public = $request->public === 'on' ? true : false;
        $page->show_in_nav = $request->show_in_nav === 'on' ? true : false;
        $page->show_in_footer = $request->show_in_footer === 'on' ? true : false;
        $page->content = $request->content;
        $page->blog = $request->has( 'blog' );
        $page->save();
      } catch (\Exception $e) {
        Bugsnag::notifyException( $e );
        flash()->error($e->getMessage());
        return redirect()->to( route( 'Create Page' ) );
      }

      if($page->blog) {
        flash()->success( 'Blog Updated!' );
        return redirect()->to( route( 'Blogs' ) );
      } else {
        flash()->success( 'Page Updated!' );
        return redirect()->to( route( 'Pages' ) );
      }
    }

    /**
     * Remove the specified resource from storage. (Admin only)
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      if( !\Auth::user()->admin ) die(403);

      try {
        $page = Page::find( $id );
        $page->delete();
      } catch (\Exception $e) {
        Bugsnag::notifyException( $e );
        flash()->error($e->getMessage());
        return redirect()->to( route( 'Create Page' ) );
      }

      flash()->success( 'Page Deleted!' );
      return redirect()->to( route( 'Pages' ) );
    }

    /**
     * Public blog list
     *
     * @return \Illuminate\Http\Response
     */
    public function blogList()
    {
      $blogs = Page::blogs()->get();

      return view('blogs', [
        'blogs' => $blogs
      ]);
    }
}
