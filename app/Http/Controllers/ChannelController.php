<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use danog\MadelineProto\Exception;
use Hu\MadelineProto\MadelineProto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChannelController extends Controller
{
    public function index(){
        return view('home');
    }

    public function submit(Request $req){
        $validatedData = $req->validate([
            'url' => 'required|unique:channels|max:255'
        ]);

        $channel_url = $req->input('url');
        $channel_url = substr(strstr($channel_url, 't.me/'), strlen('t.me/'));
        if ($channel_url == false){
            $channel_url = $req->input('url');
        }
        $channel_url2 = $channel_url;
        $channel_url = substr(strstr($channel_url, '@'), strlen('@'));
        if ($channel_url == false){
            $channel_url = $channel_url2;
        }
        try {
            $messages = \Hu\MadelineProto\Facades\MadelineProto::getClient()->channels->getFullChannel(['channel' => "@" . $channel_url,]);
        } catch (\Exception $e){
            return redirect('/add')->with('error', "Il y a eu un problème... Vérifiez bien l'url du canal. ");
        }
        $channel = new Channel();
        $channel->url = $channel_url;
        $channel->name = $messages['chats']['0']['title'];
        $channel->proposed_description = $req->input('description');
        $channel->description = $messages['full_chat']['about'];
        $channel->category = $req->input('category');
        $channel->members = $messages['full_chat']['participants_count'];
        $channel->verified = $messages['chats']['0']['verified'];
        $channel->valid = false;
        $channel->save();
        $url = $messages['full_chat']['chat_photo'];
        try {
            \Hu\MadelineProto\Facades\MadelineProto::getClient()->downloadToFile($url, '../storage/app/public/channels/' . $channel_url . '.jpg');
        }catch (\Exception $e){

        }
        return redirect('/add')->with('success', 'Le canal va bientôt être ajouté.');
    }

    function action(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('channels')
                    ->where('url', 'like', '%'.$query.'%')
                    ->where('valid',  '1')
                    ->orWhere('name', 'like', '%'.$query.'%')
                    ->orWhere('description', 'like', '%'.$query.'%')
                    ->orWhere('category', 'like', '%'.$query.'%')
                    ->orderBy('members', 'desc')
                    ->get();

            }
            else
            {
                $data = DB::table('channels')
                    ->where('valid', '1')
                    ->orderBy('members', 'desc')
                    ->get();
            }
            $total_row = $data->count();

            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                         <div class="col-sm-6 pb-4 pt-3 p-3 bg-white">
                            <div class="d-flex">
                                <img class="rounded-circle" style="width: 55px; height: 55px;" src="/storage/channels/'.$row->url.'.jpg">
                                <div class="pl-4">
                                    <h5><strong>'.$row->name.'</strong></h5>
                                    <p><a style="font-size: 15px" href="https://t.me/'.$row->url.'">@'.$row->url.'</a><span class="pl-2">'.$row->members.' membres</span></p>
                                </div>
                            </div>
                            <p>'.$row->description.'</p>
                        </div>
                        ';
                }
            }
            else
            {
                $output = "
                    <div align='center'>Désolé, je n'ai rien trouvé :(
                   ";
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );

            echo json_encode($data);
        }
    }

    public function allData(){
        $channel = new Channel;
        return view('channels.admin', ['data' => $channel->all()->where('valid', '0')]);
    }

    public function accept($id){
        $channel = Channel::find($id);
        $channel->valid = true;
        $channel->save();

        return redirect()->route('admin');
    }

    public function reject($id){
        Channel::find($id)->delete();
        return redirect()->route('admin', $id);
    }
}
