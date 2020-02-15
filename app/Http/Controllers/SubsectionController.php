<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subsection;
use App\SubsectForQuest as SFQ;

class SubsectionController extends Controller
{

  public function createSubsect(){
    return view("create_subsect",["title" => "Create"]);
  }
  public function createSubsectAJAX(){
    return view("create_subsect_ajax",["title" => "AJAX"]);
  }

  public function editSubsect($id){
      $subsect = Subsection::find($id);

    return view("edit_subsect",["subsect" => $subsect, "title" => "Edit"]);
  }

   public function index(){
     $subsection = Subsection::latest()->get();
     return view("list_subsect", ["subsections" => $subsection, "title" => "List"]);
   }

   public function showSubsect($id){
       $subsect = Subsection::findOrFail($id);

       $name = $subsect->name;

     return view("specific_subsect",["subsect" => $subsect, "title" => $name ]);
   }

   public function storeSubsect(Request $req){
     Subsection::create([
       "number" =>  $req->input("number"),
       "name" =>  $req->input("name"),
     ]);

     return redirect("subsections");
   }
   
   public function storeSubsectAJAX(Request $req){
     $input = $req->all();
     $req->validate([
       "name" => "required",
       "number" => "required"
     ]);

     Subsection::create([
       "number" =>  $req->input("number"),
       "name" =>  $req->input("name"),
     ]);

     return response()->json(["data" => $input]);
   }

   public function updateSubsect(Request $req, $id){
      Subsection::where("id",$id)
      ->update([
        "name" => $req->input("name"),
        "number" => $req->input("number"),
      ]);

      return redirect("subsections");
   }
}
