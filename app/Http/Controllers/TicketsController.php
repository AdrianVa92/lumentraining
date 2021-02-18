<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 22/07/2018
 * Time: 16:40
 */

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TicketsController extends Controller
{
    /**
     * @param $categoryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($categoryId)
    {
        return Response::json(Ticket::OfCategory($categoryId)->paginate(), 200);
    }

    /**
     * @param Request $request
     * @param $categoryId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, $categoryId)
    {
        $this->validate($request, [
          "name"=> "required|unique:tickets",
          "description"=> "required|min:2",
        ]);

        $newAddedTicket=$request->auth->addTicket(new Ticket($request->all()), $categoryId);
        if (!$newAddedTicket instanceof Ticket) {
            $response = Response::json(
                [
                    "error"=>[
                        "message" => "Ticket could not be found."
                    ]],
                400
            );
            return $response;
        }

        return Response::json(
            ["message"=> "Ticket has been created successfully",
            "data"=>$newAddedTicket],
            201
        );
    }

    /**
     * @param Request $request
     * @param $categoryId
     * @param $ticketId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $categoryId, $TicketId)
    {
        $category = $request->auth->categories()->find($categoryId);
        if (!$category instanceof Category) {
            $response = Response::json(
                [
                    "error"=>[
                        "message" => "Ticket could not be found."
                    ]],
                400
            );
            return $response;
        }
        $ticket=$category->tickets()->find($TicketId);
        if (!$ticket instanceof Ticket) {
            $response = Response::json(
                [
                    "error"=>[
                        "message" => "Ticket could not be found."
                    ]],
                400
            );
            return $response;
        }
        return Response::json($ticket, 200);
    }

    /**
     * @param Request $request
     * @param $categoryId
     * @param $ticketId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $categoryId, $TicketId)
    {
        $ExistingCategory = $request->auth->categories()->find($categoryId);
        if (!$ExistingCategory instanceof Category) {
            $response = Response::json(
                [
                    "error"=>[
                        "message" => "Ticket could not be found."
                    ]],
                404
            );
            return $response;
        }

        $ExistingTicket=$ExistingCategory->tickets()->find($ticketId);
        if (!$ExistingTicket instanceof Ticket) {
            $response = Response::json(
                [
                    "error"=>[
                        "message" => "The ticket could be found."
                    ]],
                404
            );
            return $response;
        }

        $ExistingTicket->update($request->all());

        return Response::json(["message"=>"Ticket updated successfully","data"=>$ExistingTicket], 200);
    }

    /**
     * @param Request $request
     * @param $categoryId
     * @param $ticketId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $categoryId, $TicketId)
    {
        $ExistingCategory = $request->auth->categories()->find($categoryId);
        if (!$ExistingCategory instanceof Category) {
            $response = Response::json(
                [
                    "error"=>[
                        "message" => "The ticket could be found."
                    ]],
                400
            );
            return $response;
        }
        $ticket=$ExistingCategory->tickets()->find($ticketId);
        if (!$ticket instanceof Ticket) {
            $response = Response::json(
                [
                    "error"=>[
                        "message" => "The ticket could be found."
                    ]],
                400
            );
            return $response;
        }
        $ticket->delete();
        return Response::json(["message"=>"Ticket deleted successfully"], 200);
    }
}
