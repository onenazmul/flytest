<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Merchant;
use App\Post;
 use Mail;
 use Session;
class visitorController extends Controller
{
    public function visitorcontact(Request $request){
      $this->validate($request, [
         'contact_email'=>'required',
         'contact_text'=>'required',
        ]);
      $data = array(
         'contact_title' => $request->contact_title,
         'contact_email' => $request->contact_email,
         'contact_text' => $request->contact_text,
        );
        $send = Mail::send('frontEnd.emails.contact', $data, function($textmsg) use ($data){
         $textmsg->from($data['contact_email']);
         $textmsg->to('support@packenmove.com');
         $textmsg->subject($data['contact_text']);
        });


        if($send){
          Toastr::success('message', 'Message sent successfully!');
          return redirect('/contact-us');
        }else{
          Toastr::success('message', 'Message sent successfully!');
          return redirect('/contact-us');
        }
    }
    public function merchantsupport(Request $request){
      $this->validate($request, [
         'subject'=>'required',
         'description'=>'required',
        ]);
      $findMerchant = Merchant::find(Session::get('merchantId'));
      $data = array(
         'contact_email' => $findMerchant->emailAddress,
         'description' => $request->description,
        );
        $send = Mail::send('frontEnd.emails.support', $data, function($textmsg) use ($data){
         $textmsg->from($data['contact_email']);
         $textmsg->to('support@packenmove.com');
         $textmsg->subject($data['description']);
        });


        if($send){
          Toastr::success('message', 'Message sent successfully!');
          return redirect()->back();
        }else{
         Toastr::success('message', 'Message sent successfully!');
           return redirect()->back();
        }
    }
     public function careerapply(Request $request){
      $this->validate($request, [
         'name'=>'required',
         'email'=>'required',
         'address'=>'required',
         'phone'=>'required',
         'subject'=>'required',
         'cv'=>'required',
        ]);
        $data = array(
         'name' => $request->name,
         'email' => $request->email,
         'address' => $request->address,
         'phone' => $request->phone,
         'subject' => $request->subject,
         'cv' => $request->cv,
        );
      // return $data;
         
         $send = Mail::send('frontEnd.emails.career', $data, function($textmsg) use ($data){
         $textmsg->from($data['email']);
         $textmsg->to('support@packenmove.com');
         $textmsg->subject($data['subject']);
         
         $textmsg->attach($data['cv']->getRealPath(), array(
             'as'=> 'cv.'. $data['cv']->getClientOriginalExtension(),
             'mime' => $data['cv']->getMimeType())
         
         );
        });
        
        if($send){
          Toastr::success('message', 'Apply successfully!');
          return redirect()->back();
        }else{
          Toastr::success('message', 'Apply successfully!');
          return redirect()->back();
        }
        
    }
}