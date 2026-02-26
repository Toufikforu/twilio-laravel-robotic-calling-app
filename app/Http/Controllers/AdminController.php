<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\HtmlString;
use App\Models\Subscription;

class AdminController extends Controller
{
    public function admindashboard()
    {
        $liza = User::count();
    
        // Count users who are either subscribed via Stripe OR manually approved by admin
        $activeUserCount = User::where(function ($query) {
            $query->whereNotNull('stripe_id')
                  ->orWhere('is_admin_approved', 1);
        })->count();
    
        // Count users who are NOT subscribed via Stripe AND NOT admin approved
        $inActiveUserCount = User::whereNull('stripe_id')
                                 ->where('is_admin_approved', '!=', 1)
                                 ->count();
    
        return view('admin.dashboard', compact('liza', 'activeUserCount', 'inActiveUserCount'));
    }
    
    
    public function alluser()
    {
        $liza = User::latest()->paginate(6);
    
        // Ensure subscriptions exist for users
        $latestSubscriptions = Subscription::whereIn('user_id', $liza->pluck('id')->toArray())
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('user_id');
    
        return view('admin.alluser', compact('liza', 'latestSubscriptions'));
    }
    
    
    
    
    // Eidt Function
    public function editUser($id)
    {
        $liza = User::find($id);
        if (!$liza) {
            return redirect()->route('alluser')->with('error', 'User not found.');
        }

        return view('admin.edituser', compact('liza'));
    }

    // Updated function
    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
    
        if (!$user) {
            return redirect()->route('alluser')->with('error', 'User not found.');
        }
    
        // Update user fields
        $user->name = $request->name;
        $user->email = $request->email;
    
        // Handle admin approval (checkbox checked = true)
        $user->is_admin_approved = $request->has('is_admin_approved');
    
        // Set the admin approval date if the admin approves the user
        if ($user->is_admin_approved) {
            $user->admin_approval_date = now();
        } else {
            // If admin unchecks approval, set the date to null
            $user->admin_approval_date = null;
        }
    
        // Update subscription's created_at date if admin approves the user
        if ($user->is_admin_approved) {
            $latestSubscription = $user->subscriptions()->latest()->first();
            if ($latestSubscription) {
                // Set the created_at date to now if the admin approves
                $latestSubscription->created_at = now();
                $latestSubscription->save();
            }
        }
    
        $user->save();
    
        return redirect()->route('alluser')->with('message', 'User updated with admin approval status!');
    }
    
    
    
  
    
    
    // Delete Function
	public function userDelete($id)
	{
		$liza = User::find($id);
		$liza->delete();
		return redirect()->route('alluser',compact('liza'))->with('message','User delete Successfully!');
	}


    // Admin Create Reg Page
    public function admCreateReg()
    {
        return view('admin.createReg');
    }
    
	public function admUserReg(Request $request)
	{
		        /* 
		* To check submited data by json formate
		dd( $request->all() );
		*/

		/* To store data */
		User::create([
			'name'		=>	$request->name,
			'email'		=>	$request->email,
			'phone'		=>	$request->phone,
			'password' => Hash::make($request['password']),
		]);
		//success message
		//Session::flash('status','Created Successfully!');
		//User go to
		return redirect()->back()->with('message','User Created Successfully!');;
		
	}
    
    // Search User
    public function searchUser(Request $request)
    {
        $search_text = $request['search'];
        $liza = User::where('name','LIKE','%'.$search_text.'%')->paginate(6);
        return view('admin.searchUser', compact('liza'));
      // dd($liza);
    }

    // Download All User
    public function downloadUser()
    {
        $data = User::latest()->get();
        $filename = "AllUser.csv";
        $fp = fopen($filename,"w+");
        fputcsv($fp, array('name','email','created_at','Status'));

        foreach($data as $row){
            fputcsv($fp, array($row->name, $row->email, $row->created_at,$row->stripe_id));
        }

        fclose($fp);

        $headers = array('Content-Type' => 'text/csv');

        return response()->download($filename, 'AllUser.csv', $headers);

    }



    // Template Form View
    public function templateForm()
    {
        return view('admin.templateForm');
    }


    // Template Form Sending
    public function sendingEmailDropdown(Request $request)
    {
        $request->validate([
            'to' => 'required|email',
            'subject' => 'required|string|max:255',
            'template' => 'required|string',
        ]);

        // Fetch template content based on selection
        $templateContent = $this->getTemplateContent($request->template);

        if (!$templateContent) {
            return back()->withErrors('Invalid template selected.');
        }

        // Email data
        $emailData = [
            'to' => $request->to,
            'subject' => $request->subject,
            'content' => $templateContent,
        ];

        // Send email using a mail service
        Mail::send('admin.template.emailHotel', ['content' => $templateContent], function ($message) use ($emailData) {
            $message->to($emailData['to'])
                    ->subject($emailData['subject']);
        });

        return back()->with('success', 'Email sent successfully!');
    }

    // Helper function to get template content
    private function getTemplateContent($template)
    {
        $templates = [
            'template1' => 'This is the content of Template 1.',
            'template2' => 'This is the content of Template 2.',
        ];

        return $templates[$template] ?? null;
    }

    // Manual Form View
    public function manualForm()
    {
        return view('admin.manualForm');
    }

    // Sending Manual Email

    public function sendingManualForm(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'to' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
    
        // Extract form data
        $to = $request->input('to');
        $subject = $request->input('subject');
        $messageContent = $request->input('message');
    
        try {
            // Send email using Laravel's Mail facade with HtmlString for message content
            Mail::send('admin.template.customMessage', ['messageContent' => $messageContent, 'subject'=> $subject], function ($message) use ($to, $subject) {
                $message->to($to)
                        ->subject($subject);
            });
            
    
            // Return a success response
            return back()->with('success', 'Email sent successfully!');
        } catch (\Exception $e) {
            // Log error and return failure message
            Log::error('Email sending failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to send email. Please try again.');
        }
    }

    // // Sending Template Email
    // public function sendingEmail(Request $request)
    // {
    //     // Validate the request data
    //     $validatedData = $request->validate([
    //         'to' => ['required', 'email'],
    //         'subject' => ['required', 'string', 'max:255'],
    //         'message' => ['required', 'string'], 
    //     ]);
    
    //     // Prepare the data array for the email template
    //     $emailData = [
    //         'message' => $validatedData['message'], 
    //     ];
    
    //     // Send the email using the Blade template 'admin.template.emailHotel'
    //     Mail::send('admin.template.emailHotel', $emailData, function($message) use ($validatedData) {
    //         $message->to($validatedData['to']) // Receiver's email address
    //                 ->subject($validatedData['subject']); // Email subject
    //     });
    
    //     // Redirect back with a success message
    //     return redirect()->back()->with('success', 'Email sent successfully!');
    // }


    // Message Box & Template together , but not working both only template working.
    // public function sendingEmail(Request $request)
    // {
    //     // Validate the request data
    //     $validatedData = $request->validate([
    //         'to' => ['required', 'email'],
    //         'subject' => ['required', 'string', 'max:255'],
    //         'messageOption' => ['required'], // Radio button option (custom_message or template)
    //     ]);
    
    //     // Determine the view template based on user selection
    //     if ($request->input('messageOption') === 'custom_message') {
    //         // Use the custom message from the form
    //         $message = $request->input('message'); // Prepare the custom message
    //         $viewTemplate = 'admin.template.customMessage'; // Set the view for custom messages
    //         $emailContent = compact('message'); // Use compact to pass the message to the view

    //                 // Log the custom message content for debugging
    //     Log::info('Custom message content: ', ['message' => $message]);
    //     } elseif ($request->input('messageOption') === 'template') {
    //         // Use the selected template
    //         $templateName = $request->input('template');
    
    //         // Set the appropriate view based on the selected template
    //         if ($templateName === 'template1') {
    //             $viewTemplate = 'admin.template.emailHotel'; // Blade template for Template 1
    //             $emailContent = []; // No additional content needed for template
    //         } else {
    //             return redirect()->back()->with('error', 'Invalid template selected.');
    //         }
    //     } else {
    //         // If no valid option is selected, return an error
    //         return redirect()->back()->with('error', 'Invalid message option selected.');
    //     }
    
    //     // Send the email
    //     Mail::send($viewTemplate, $emailContent, function ($message) use ($validatedData) {
    //         $message->to($validatedData['to'])
    //                 ->subject($validatedData['subject']);
    //     });
    
    //     // Redirect back with a success message
    //     return redirect()->back()->with('success', 'Email sent successfully!');
    // }
    
    
    


}
