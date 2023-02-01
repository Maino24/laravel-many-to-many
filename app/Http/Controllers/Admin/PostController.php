<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Mail\CreatePostMail;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'posts' => Post::with('category')->paginate(10)
        ];

        return view('admin.posts.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$data = [
            //'categories' => Category::All()
        //];

        $categories = Category::All();
        $tags = Tag::All();

        return view('admin.posts.create', compact('categories', 'tags'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        //dd($data);

        //validezione dei campi
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $newPost = new Post();
        //controllo se l'immagine è stata caricata nell'input
        if( array_key_exists('image', $data)){
            $cover_url = Storage::put('post_covers', $data['image']);
            $data['cover'] = $cover_url;
        }
        $newPost->fill($data);
        $newPost->save();

        //controllo se l'utente ha cliccato delle checkbox
        if( array_key_exists('tags', $data) ){
            $newPost->tags()->sync($data['tags']);
        }

        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $singolo_post = Post::findOrFail($id);

        return view('admin.posts.show', compact('singolo_post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        $categories = Category::All();

        $tags = Tag::All();

        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
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
        $data = $request->all();
        $singolopost = Post::findOrFail($id);

        $singolopost->update($data);

        //controlla se l'utente ha cliccato o erano già selezionate delle checkbox
        if(array_key_exists('tags', $data)){
            $singolopost->tags->sync($data['tags']);
        }else{
            //non ci sono checkbox selezionate
            $singolopost->tags()->sync([]);
        }

        //invio mail di creazione
        $mail = new CreatePostMail();
        $email_utente = Auth::user()->email;//recupera email dell'utente che è loggato
        Mail::to($email_utente)->send($mail);

        return redirect()->route('admin.posts.show', $singolopost->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $singolo_post = Post::findOrFail($id);

        //se calncello un post con questo comando si cancella anche l'immagine dentro la cartella storage
        if($singolo_post->cover){
            Storage::delete($singolo_post->cover);
        }

        $singolo_post ->tags()->sync([]);
        $singolo_post->delete();

        return redirect()->route('admin.posts.index');
    }
}
