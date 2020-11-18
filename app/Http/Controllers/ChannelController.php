<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use danog\MadelineProto\Exception;
use Hu\MadelineProto\MadelineProto;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    public function submit(Request $req){
        try {
            $channel_url = substr(strstr($req->input('url'), 't.me/'), strlen('t.me/'));
            $channel_url = substr(strstr($channel_url, '@'), strlen('@'));
            try {
                $messages = \Hu\MadelineProto\Facades\MadelineProto::getClient()->channels->getFullChannel(['channel' => "@" . $channel_url,]);
            }catch (\Exception $e){
                return redirect('/add')->with('error', "Il y a eu un problème... Vérifiez bien l'url du canal.");
            }
            $channel = new Channel();
            $channel->url = $channel_url;
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
        }catch (Exception $e){
            return redirect('/add')->with('error', "Il y a eu un problème... Vérifiez bien l'url du canal.");
        }
        return redirect('/add')->with('success', 'Le canal va bientôt être ajouté.');
    }

    public function index()
    {
        $channel = Channel::all();
        return view('home', compact('channel'));
    }
}
