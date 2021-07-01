<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\post;
use Illuminate\Http\Request;

Use Illuminate\Support\Facades\Storage; // Para poder eliminar imagenes

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->get(); // Consultar los post y los envia

        return view('posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        // Guardar
        $post = Post::create([
            'user_id' => auth()->user()->id

        ] + $request->all());
        // Imagen
        if($request->file('file')){
            $post -> image = $request->file('file')->store('post','public');
            $post -> save();
        }
        //retornar
        return back()->with('status','Creado con éxito'); // Siempre se van a imprimir las variables status
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, post $post)
    {
        $post->update($request->all());
        // Imagen
        if($request->file('file')){
            // Primero Eliminar para imagenes
            Storage::disk('public')->delete($post->image);
            // Luego Guardar
            $post -> image = $request->file('file')->store('post','public');
            $post -> save();

        }

        return back()->with('status','Actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(post $post)
    {
        //eliminación de una imagen
        Storage::disk('public')->delete($post->image);
        $post->delete();
        return back()->with('status','Eliminado con éxito');
    }
}
