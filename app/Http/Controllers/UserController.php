<?php

namespace App\Http\Controllers;

use App\Mail\Aprovemail;
use App\Mail\otpmail;
use App\Models\Categorie;
use App\Models\Chating;
use App\Models\Feedback;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function login()
    {
        if (!empty(Auth::check())) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }
    public function dashboard()
    {
        return view('panel.dashboard');
    }
    public function register()
    {
        return view('panel.user.add');
    }
    public function userlist()
    {
        $users = User::where('type', 0)->orWhere('type', 1)->get();
        return view('panel.admin.list', compact('users'));
    }
    public function userdetial()
    {
        $detail = Auth::user();
        return view('panel.user.userlist', compact('detail'));
    }

    public function create_user(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'number' => 'required|numeric|min:11|unique:users,number',
            'password' => 'required'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'number' => $request->number,
            'password' => Hash::make($request->password)
        ]);
        if ($user) {
            return redirect()->route('ulogin')->with('success', 'User created successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to create user');
        }
    }

    public function auth_login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        if ($request->email == 'admin@gmail.com') {
            Auth::attempt($credentials);
            return view('panel.dashboard');
        }
        Session()->put('email', $email);
        session()->put('password', $password);
        Mail::to($email)->send(new otpmail($email));

        return view('otp');
    }

    public function OTPAction(Request $request)
    {
        $request->validate([
            'otp' => 'required',
        ]);

        // set_environment($request->all());
        $otp = $request->input('otp');
        if ($otp == session::get('otp')) {
            if (Auth::attempt(['email' => session::get('email'), 'password' => session::get('password')])) {
                $user = Auth::user();
                if ($user->type == 1) {
                    session()->forget(['email', 'password', 'otp']);
                    return view('panel.dashboard');
                } elseif ($user->type == 0) {
                    Auth::logout();
                    session()->flush();
                    return redirect()->route('ulogin')->with('error', 'User not authorized.');
                }
                return view('panel.dashboard');
            } else {
                session()->forget(['email', 'password', 'otp']);
                return redirect()->route('ulogin')->with('error', 'Invalid username or password');
            }
        } else {
            return redirect()->route('otp')->with('error', 'Invalid  OTP ');
        }
    }

    public function resendotp()
    {
        $email = session::get('email');
        Mail::to($email)->send(new otpmail($email));
        return redirect()->route('otp')->with('success', 'otp send successfully');
    }

    public function auth_logout()
    {
        Auth::logout();
        return redirect()->route('ulogin');
    }

    public function adminaprove($id)
    {

        $user = User::find($id);

        if ($user) {
            if ($user->type) {
                $user->type = 0;
                Mail::to($user->email)->send(new Aprovemail($user));
            } else {
                $user->type = 1;
                Mail::to($user->email)->send(new Aprovemail($user));
            }
        }

        $user->save();

        return redirect()->route('listdata')->with('success', 'User approved successfully');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $user,
        ]);
    }

    public function updatedetail(Request $request)
    {
        //dd($request->all());
        $id = $request->input('detail_id');
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

        $user = User::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'number' => $request->number,
        ]);

        if ($user) {
            Auth::logout();
            return redirect()->route('ulogin')->with('success', 'User updated successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to update user');
        }
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect()->route('ulogin')->with('success', 'User deleted successfully');
        } else {
            return redirect()->route('listdata')->with('error', 'User not found');
        }
    }
    public function admindel($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect()->route('listdata')->with('success', 'User deleted successfully');
        } else {
            return redirect()->route('listdata')->with('error', 'User not found');
        }
    }

    public function envfile()
    {
        return view('panel.admin.adenv');
    }


    //update env file dynamically
    public function updateenv(Request $request)
    {

        $data = $request->validate([
            'MAIL_MAILER' => 'required',
            'MAIL_HOST' => 'required',
            'MAIL_PORT' => 'required|numeric',
            'MAIL_USERNAME' => 'required|email',
            'MAIL_PASSWORD' => 'required',
            'MAIL_FROM_ADDRESS' => 'required|email',
            'MAIL_FROM_NAME' => 'required',
            'MAIL_ENCRYPTION' => 'required'
        ]);
        $this->set_environment($data);
        return redirect()->route('envfile')->with('success', 'Environment updated successfully');
    }


    // function set_environment($settings)
    // {
    //     $path = '../.env';
    //     foreach ($settings as $key => $value) {
    //         $pattern = preg_quote(strtoupper($key), '/');
    //         $pattern = "/^.$pattern.\$/m";
    //         $current_environment_settings = file_get_contents($path);
    //         if (preg_match_all($pattern, $current_environment_settings, $matches)) {
    //             $setting = explode("=", implode("\n", $matches[0]));
    //             $settingName = $setting[0];
    //             $settingValue = $setting[1];
    //             $value = "'" . $value . "'";

    //             $updated_envionment_settings = str_replace($settingName . "=" . $settingValue, $settingName . "=" . $value, $current_environment_settings);
    //             file_put_contents($path, $updated_envionment_settings);
    //         }
    //     }
    // }
    function set_environment($settings)
    {
        // Load the .env file contents
        $path = base_path('.env');
        $env_contents = file_get_contents($path);

        // Iterate over each setting and replace or add them in the file
        foreach ($settings as $key => $value) {
            // Check if the key exists in the file
            $key = strtoupper($key);
            $escaped_key = preg_quote($key, '/');
            $pattern = "/^$escaped_key=.*$/m";

            // Ensure proper value formatting, add quotes if necessary
            $value = (strpos($value, ' ') !== false) ? '"' . $value . '"' : $value;

            if (preg_match($pattern, $env_contents)) {
                // Update the existing key with the new value
                $env_contents = preg_replace($pattern, "$key=$value", $env_contents);
            } else {
                // Add the key-value pair if it doesn't exist
                $env_contents .= "\n$key=$value";
            }
        }

        // Save the updated contents back to the .env file
        file_put_contents($path, $env_contents);
    }


    //**************** Admin Send Message to User *************************
    public function adminchat()
    {
        $users = User::where('type', 1)->get();
        return view('panel.admin.adminchat', compact('users'));
    }
    public function Adminmsg(Request $request)
    {
        $user_id = $request->input('id');
        $login_id = Auth::user()->id;

        $recieved = Message::where('receiver_id', $user_id)->Where('sender_id', $login_id)->get();
        $sender = Message::where('receiver_id', $login_id)->Where('sender_id', $user_id)->get();

        $allmessage = $recieved->concat($sender)->sortBy('created_at')->values();

        return response()->json([
            'data' => [
                'allmessage' => $allmessage,
                // 'recieved' => $recieved,
                // 'sender' => $sender,
            ],
        ]);
    }

    public function sendmessageuser(Request $request)
    {
        // dd($request->all());
        $user_id = $request->input('user_id');
        $message = $request->input('message');

        $msg = Message::create([
            'sender_id' => Auth::user()->id,
            'receiver_id' => $user_id,
            'message' => $message,
        ]);
    }
    //****************** * end ***********************



    //**************** User Send Message to Admin *************************
    public function userchat()
    {
        $users = Auth::user();
        return view('panel.user.userchat', compact('users'));
    }

    public function usermsg(Request $request)
    {
        $userid = $request->input('id');
        $admin = User::where('type', 2)->first();
        $adminid = $admin->id;

        $recieved = Message::where('receiver_id', $userid)->Where('sender_id', $adminid)->get();
        //dd($recieved);
        $sender = Message::where('receiver_id', $adminid)->Where('sender_id', $userid)->get();

        // $mergedMessages = array_merge($sender->toArray(), $recieved->toArray());
        $mergedMessages = $recieved->concat($sender)->sortBy('created_at')->values();
        // dd($mergedMessages);

        return response()->json([
            'data' => [
                'allmessages' => $mergedMessages,
                // 'recieved' => $recieved,
                // 'sender' => $sender,
            ],
        ]);
    }
    public function sendmessageadmin(Request $request)
    {
        // dd($request->all());
        $message = $request->input('message');
        $userid = $request->input('user_Id');
        $admin = User::where('type', 2)->first();
        $adminid = $admin->id;

        $msg = Message::create([
            'sender_id' => $userid,
            'receiver_id' => $adminid,
            'message' => $message,
        ]);
    }

    // ********************* end of sendmessageadmin ********************
}
