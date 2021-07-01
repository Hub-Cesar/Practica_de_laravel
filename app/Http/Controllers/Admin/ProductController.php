<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\ProductImage;
use App\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);
        return view('admin.products.index')->with(compact('products')); //Permite ver el listado de productos
    }
    public function create()
    {
        return view('admin.products.create'); //Permite ver el formulario de registro
    }
    public function store(Request $request)
    {
        //Validar registros
        $messages = [
            'name.required' => 'No has ingresado un nombre para el producto.',
            'name.min' => 'El nombre del producto debe tener al menos 3 caracteres.',
            'description.required' => 'La descripción corta es un campo obligatorio.',
            'description.max' => 'La descripción corta admite hasta 200 caracteres.',
            'price.required' => 'No has ingresado un precio para el producto.',
            'price.numeric' => 'Ingresa un precio valido.',
            'price.min' => 'No se admiten valores negativos.'
        ];
        $rules = [
            'name' => 'required|min:3',
            'description' => 'required|max:200',
            'price' => 'required|numeric|min:0',
        ];
        $this->validate($request, $rules, $messages);
        //Permite registrar el nuevo producto en la BD
        //dd($request->all());
        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->long_description = $request->input('long_description');
        $product->save(); //INSERT sobre la tabla de productos

        return redirect('/admin/products');
    }

    public function edit($id)
    {
        //return "Mostar aqui formulario de edicion para el producto con id $id";
        $product = Product::find($id);
        return view('admin.products.edit')->with(compact('product')); //Permite ver el formulario de registro
    }
    public function update(Request $request, $id)
    {
        //Validar
        $messages = [
            'name.required' => 'No has ingresado un nombre para el producto.',
            'name.min' => 'El nombre del producto debe tener al menos 3 caracteres.',
            'description.required' => 'La descripción corta es un campo obligatorio.',
            'description.max' => 'La descripción corta admite hasta 200 caracteres.',
            'price.required' => 'No has ingresado un precio para el producto.',
            'price.numeric' => 'Ingresa un precio valido.',
            'price.min' => 'No se admiten valores negativos.'
        ];
        $rules = [
            'name' => 'required|min:3',
            'description' => 'required|max:200',
            'price' => 'required|numeric|min:0',
        ];
        $this->validate($request, $rules, $messages);
        //Permite registrar el nuevo producto en la BD
        //dd($request->all());
        $product = Product::find($id);
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->long_description = $request->input('long_description');
        $product->save(); //UPDATE sobre la tabla de productos

        return redirect('/admin/products');
    }

    public function destroy($id)
    {
        //eliminar ProductImage por que estaba relacionada
        ProductImage::where('product_id', $id)->delete();
        //eliminar producto
        $product = Product::find($id);
        $product->delete(); //DELETE elimina el producto seleccionado

        return back();
    }
}
