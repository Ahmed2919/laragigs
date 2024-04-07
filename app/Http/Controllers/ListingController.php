<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

use Illuminate\Validation\Rule;
use function Laravel\Prompts\search;

class ListingController extends Controller
{
    //
    public static function index(){
        //dd(request('tag'));
        return view('listings.index',[
            'listings' => Listing::latest()->filter(request(['tag','search']))->paginate(6)
        ]
        );
    }

    

    //
    public static function create(){
        return view('listings.create');
    }

   public static function store(Request $request){
   // dd($request->hasFile('logo'));
       $formList = $request->validate([
            'title' => 'required',
            'company' => ['required' , Rule::unique('listings','company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required' , 'email'],
            'tags' => 'required',
            'description' => 'required'

       ]);

       if($request->hasFile('logo')){
            $formList['logo']= $request->file('logo')->store('logos','public');
           // dd($formList);
       }

       $formList['user_id'] = auth()->id();

       Listing::create($formList);
       return redirect('/')->with('message' , 'Listing Created Successfuly');

    }

    // Edit list
    public function edit(Listing $listing){
        return view('listings.edit',[
            'listing' => $listing
        ]
    );

    }
    // Update list
    public static function update(Request $request , Listing $listing){
        if($listing->user_id != auth()->id()){
            abort(403,'Unautherized Action');
        }
        // dd($request->hasFile('logo'));
            $formList = $request->validate([
                 'title' => 'required',
                 'company' => ['required' ],
                 'location' => 'required',
                 'website' => 'required',
                 'email' => ['required' , 'email'],
                 'tags' => 'required',
                 'description' => 'required'
     
            ]);
     
            if($request->hasFile('logo')){
                 $formList['logo']= $request->file('logo')->store('logos','public');
                // dd($formList);
            }
            $listing->update($formList);
            return Back()->with('message' , 'Listing Updated Successfuly');
     
         }

         // Delete list 
         public function destroy(Listing $listing){
            if($listing->user_id != auth()->id()){
                abort(403,'Unautherized Action');
            }
            $listing->delete();
            return redirect('/')->with('message' , 'Listing Deleted Successfuly');

         }

    // Manage
    public static function manage(){
        return view('listings.manage', [' ' => auth()->user()->listings()->get()]);
    }
    //
    public static function show(Listing $listing){
        return view('listings.show',[
            'listing' => $listing
        ]
    );
    }
}
