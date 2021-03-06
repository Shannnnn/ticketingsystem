<?php

namespace App\Http\Controllers;

use App\User;
use App\Ticket;
use App\Comment;
use App\Http\Requests;
use App\Mailers\AppMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
	/**
	 * Persist comment and mail user
	 * @param  Request  $request
	 * @param  AppMailer $mailer
	 * @return Response
	 */
    public function postComment(Request $request, AppMailer $mailer)
    {
    	$this->validate($request, [
            'comment'   => 'required'
        ]);

        $comment = Comment::create([
        	'ticket_id' => $request->input('ticket_id'),
        	'user_id'	=> Auth::user()->id,
        	'comment'	=> $request->input('comment'),
        ]);

        $ticket = Ticket::where('id', $comment->ticket_id)->first();
        // send mail if the user commenting is not the ticket owner
        //if ($comment->ticket->user->id !== Auth::user()->id) {
        //$mailer->sendTicketComments(Auth::user(), $ticket, $comment);
        //}
        
        return redirect()->back()->with("status", "Your comment has be submitted.");
    }
}
