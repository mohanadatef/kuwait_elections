<?php

namespace App\Http\Controllers\Api\Social_Media;

use App\Http\Resources\ACL\UserResource;
use App\Http\Resources\Social_Media\ChatResource;
use App\Models\ACL\Friend;
use App\Models\Image;
use App\Models\Social_Media\Message;
use App\Models\Social_Media\Message_User;
use App\Repositories\ACL\LogRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    private $logRepository;

    public function __construct(LogRepository $LogRepository)
    {
        $this->middleware('auth:api');
        $this->logRepository = $LogRepository;
    }

    public function index()
    {
        $friend_s = DB::table('friends')->where('user_send_id', Auth::user()->id)->where('status', 1)->pluck('user_receive_id', 'id');
        $friend_r = DB::table('friends')->where('user_receive_id', Auth::user()->id)->where('status', 1)->pluck('user_send_id', 'id');
        $friend = array_merge($friend_s->toArray(), $friend_r->toArray());
        $last_chat = Message::wherein('user_send_id', $friend)->where('user_receive_id', Auth::user()->id)
            ->orwherein('user_receive_id', $friend)->where('user_send_id', Auth::user()->id)->get();
        $last_message = array();
        $s = array();
        foreach ($last_chat as $last_chats) {
            if ($last_chats->user_send_id == Auth::user()->id) {
                $last_message = Message_User::where('message_id', $last_chats->id)->where('status', '!=', 3)->where('status', '!=', 1)->orderby('created_at','desc')->first();
            } elseif ($last_chats->user_receive_id == Auth::user()->id) {
                $last_message = Message_User::where('message_id', $last_chats->id)->where('status', '!=', 3)->where('status', '!=', 2)->orderby('created_at','desc')->first();
            }
            if ($last_message) {
                array_push($s, '' . $last_message->id . '');
            }
        }

        $last_message = Message_User::wherein('id', $s)->get();
        if ($last_message) {
            $last_message = ChatResource::collection($last_message);
        } else {
            $last_message = array();
        }
        $friend = User::wherein('id', $friend)->get();
        if ($friend) {
            $friend = UserResource::collection($friend);
        } else {
            $friend = array();
        }
        return response(['status' => 1, 'data' => [
            'count_message' => count($last_message), 'last_message' => $last_message,
            'count_friend' => count($friend), 'friend' => $friend,
        ], 'message' => 'قائمه الرسائل'], 200);
    }

    public function chat_for_user(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        if ($user->status == 0) {
            return response(['status' => 0, 'data' => array(), 'message' => 'برجاء الاتصال بخدمه العملاء'], 400);
        }
        $user_chat = User::find($request->user_chat_id);
        if (!$user_chat) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        if ($user_chat->status == 0) {
            return response(['status' => 0, 'data' => array(), 'message' => 'برجاء الاتصال بخدمه العملاء'], 400);
        }
        if ($user->id == Auth::user()->id) {
            $message_check = Message::where('user_send_id', $user->id)->where('user_receive_id', $user_chat->id)
                ->orwhere('user_receive_id', $user->id)->where('user_send_id', $user_chat->id)
                ->count();
            if ($message_check == 0) {
                $message = new Message();
                $message->user_send_id = $user->id;
                $message->user_receive_id = $user_chat->id;
                $message->save();
            }
            $message = Message::where('user_send_id', $user->id)->where('user_receive_id', $user_chat->id)
                ->orwhere('user_receive_id', $user->id)->where('user_send_id', $user_chat->id)->first();
            if ($message->user_send_id == Auth::user()->id) {
                $chat = Message_User::where('message_id', $message->id)->where('status', '!=', 3)->where('status', '!=', 1)->paginate(100);
            } elseif ($message->user_receive_id == Auth::user()->id) {
                $chat = Message_User::where('message_id', $message->id)->where('status', '!=', 3)->where('status', '!=', 2)->paginate(100);
            }
            if ($chat) {
                $chat = ChatResource::collection($chat);
            } else {
                $chat = array();
            }
            return response(['status' => 1, 'data' => ['count_chat' => count($chat),'chat_id'=>$message->id, 'chat' => $chat
            ], 'message' => 'لا يوجد رسائل بعد'], 200);
        }
        return response(['status' => 0, 'data' => array(), 'message' => 'لا يمكن اتمام الطلب'], 400);
    }

    public function store(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        if ($user->status == 0) {
            return response(['status' => 0, 'data' => array(), 'message' => 'برجاء الاتصال بخدمه العملاء'], 400);
        }
        $message = Message::find($request->message_id);
        if (!$message) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات الشات'], 400);
        }
        if ($user->id == Auth::user()->id) {
            if ($request->image_post) {
                $validate = \Validator::make($request->all(), [
                    'details' => 'required|string|max:255',
                    'image_message' => 'string',
                ]);
            } else {
                $validate = \Validator::make($request->all(), [
                    'details' => 'required|string|max:255',
                ]);
            }
            if ($validate->fails()) {
                return response(['status' => 0, 'data' => array(), 'message' => $validate->errors()], 422);
            }
            $message_chat = new Message_User();
            $message_chat->details = $request->details;
            $message_chat->status = 0;
            $message_chat->user_id = $user->id;
            $message_chat->message_id = $message->id;
            $message_chat->save();
            if ($request->image_message) {
                $message_image = new Image();
                $message_image->category = 'message-'.$message->id;
                $message_image->status = 1;
                $message_image->category_id = $message_chat->id;
                $folderPath = public_path('images/message/' . $message->id . '/');
                $image_type = 'png';
                $image_base64 = base64_decode($request->image_message);
                $imageName = time() . uniqid() . '.' . $image_type;
                $file = $folderPath . $imageName;
                if (!\File::isDirectory($folderPath)) {
                    \File::makeDirectory($folderPath, 0777, true, true);
                }
                file_put_contents($file, $image_base64);
                $message_image->image = $imageName;
                $message_image->save();
            }
            if ($message->user_send_id == Auth::user()->id) {
                $chat = Message_User::where('message_id', $message->id)->where('status', '!=', 3)->where('status', '!=', 1)->paginate(100);
            } elseif ($message->user_receive_id == Auth::user()->id) {
                $chat = Message_User::where('message_id', $message->id)->where('status', '!=', 3)->where('status', '!=', 2)->paginate(100);
            }
            if ($chat) {
                return response(['status' => 1, 'data' => ['chat_id' => $message->id, 'chat' => ChatResource::collection($chat)], 'message' => 'لا يوجد رسائل بعد'], 200);
            }
            return response(['status' => 1, 'data' => ['chat_id' => $message->id, 'chat' => array()], 'message' => 'لا يوجد رسائل بعد'], 200);
        }
        return response(['status' => 0, 'data' => array(), 'message' => 'لا يمكن اتمام الطلب'], 400);
    }

    public function delete(Request $request)
    {

        $user = User::find($request->user_id);
        if (!$user) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات المستخدم'], 400);
        }
        if ($user->status == 0) {
            return response(['status' => 0, 'data' => array(), 'message' => 'برجاء الاتصال بخدمه العملاء'], 400);
        }
        $chat = Message::find($request->chat_id);
        if (!$chat) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات الشات'], 400);
        }
        $message = Message_User::wherein('id', $request->message_id)->where('status', '1')
            ->orwherein('id', $request->message_id)->where('status', '0')
            ->orwherein('id', $request->message_id)->where('status', '2')->count();

        if ($message == 0) {
            return response(['status' => 0, 'data' => array(), 'message' => 'خطا فى تحميل البيانات الرساله'], 400);
        }
        if ($user->id == Auth::user()->id) {
            $messages = Message_User::wherein('id', $request->message_id)->where('status', '1')
                ->orwherein('id', $request->message_id)->where('status', '0')
                ->orwherein('id', $request->message_id)->where('status', '2')->get();

            foreach ($messages as $message) {
                if ($message->status == 0) {
                    if ($chat->user_send_id == Auth::user()->id) {
                        $message->status = 1;
                    } elseif ($chat->user_receive_id == Auth::user()->id) {
                        $message->status = 2;
                    }
                } elseif ($message->status == 1 || $message->status == 2) {
                    $message->status = 3;
                }
                $message->save();
            }
            if ($chat->user_send_id == Auth::user()->id) {
                $message = Message_User::where('message_id', $chat->id)->where('status', '!=', 3)->where('status', '!=', 1)->paginate(100);
            } elseif ($chat->user_receive_id == Auth::user()->id) {
                $message = Message_User::where('message_id', $chat->id)->where('status', '!=', 3)->where('status', '!=', 2)->paginate(100);
            }
            if ($message) {
                return response(['status' => 1, 'data' => ['chat_id' => $chat->id, 'chat' => ChatResource::collection($message)], 'message' => 'لا يوجد رسائل بعد'], 200);
            }
            return response(['status' => 1, 'data' => ['chat_id' => $chat->id, 'chat' => array()], 'message' => 'لا يوجد رسائل بعد'], 200);
        }
        return response(['status' => 0, 'data' => array(), 'message' => 'لا يمكن اتمام الطلب'], 400);
    }
}
