<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Comment;

class PostController extends Controller
{   
    private $posts = [];

    public function __construct()
    {
        $posts = Post::all();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $posts = $this->populate();
        //return "" . count($posts) ." comments: " . count($posts[0]['comments']);
        return view('posts', compact(['posts']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        // Tem que popular o user aqui
        $user = User::find(intval($request->user_id));

        $new_post = Post::create([
            'author'=>($user->name),
            'title'=>($request->title),
            'content'=>(strip_tags($request->content)),
            'user_id'=>($user->id)
        ]);
        if ($new_post->save())
            return redirect()->route('posts.index');
        else 
            // deu errado ué, mas manda assim mesmo por enquanto
            return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // No need to create
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // No need to create
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /**
         * <form action="{{ route('posts.destroy', $item['id']) }}" method="POST">
         *                  @csrf
         *                  @method('DELETE')
         *                    <input type="submit" value="Apagar">
         * </form>
         * Adicioar dentro dos cards de post
         */
        return redirect()->route('posts.index');
    }

    private function populate()
    {
        $given_posts = Post::all();

        // Send post with its comments attached
        $posts = [];
        foreach($given_posts as $item) {
            $posts[] = [
                'id' => ($item->id),
                'author' => ($item->author),
                'title' => ($item->title),
                'content' => ($item->content),
                'comments' => (Comment::where('post_id', $item->id)->get())
            ];
        }

        return $posts;
    }
}
