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
        $channel_url = substr(strstr($channel_url, '@'), strlen('@'));
        if ($channel_url == false){
            $channel_url = $req->input('url');
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
                    ->orWhere('name', 'like', '%'.$query.'%')
                    ->orWhere('description', 'like', '%'.$query.'%')
                    ->orWhere('category', 'like', '%'.$query.'%')
                    ->get();

            }
            else
            {
                $data = DB::table('channels')
                    ->orderBy('id', 'desc')
                    ->get();
            }
            $total_row = $data->count();

            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                         <div class="col-6 pb-4 bg-white d-flex pt-3">
                            <img class="rounded-circle" style="width: 55px; height: 55px;" src="/storage/channels/'.$row->url.'.jpg">
                            <div class="pl-4">
                                <h5>'.$row->name.'</h5>
                                <p><a style="font-size: 15px" href="https://t.me/'.$row->url.'">@'.$row->url.'</a><span class="pl-2">'.$row->members.' membres</span></p>
                                <p>'.$row->description.'</p>
                            </div>
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
}
