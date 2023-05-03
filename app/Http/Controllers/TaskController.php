<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Carbon\Carbon;

use function Termwind\render;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with('assignBy', 'assignTo', 'status')->where('assign_by', Auth::user()->id)->orWhere('assign_to', Auth::user()->id)->get();
        //dd($tasks->toArray());
        return Inertia::render('Tasks/Index')->with('tasks', $tasks);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('usertype', 'User')->get();
        $statuses = Status::all();
        // dd($users->toArray());
        return Inertia::render('Tasks/Create')->with('users', $users)->with('statuses', $statuses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'min:3'],
            'file' => 'nullable|image',
        ]);
        $filePath = '';
        if ($request->hasFile('file')) {
            $fileName = time() . '_' . $request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('tasks', $fileName, 'public');
        }

        //  dd($request->all());
        Task::create([
            'assign_by' => Auth::user()->id,
            'assign_to' => $request->assign_to,
            'title' => $request->title,
            'description' => $request->description,
            'file' => $filePath,
            'deadline' => $request->deadline,
            'status_id' => $request->status_id
        ]);

        return redirect(route('tasks.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $users = User::all();
        $statuses = Status::all();
        $task = Task::where('id', $task->id)->with('assignBy', 'assignTo', 'status')->first();
        $comments = Comment::where('task_id', $task->id)->with('user')->get();
        //  dd($comments->toArray());
        return Inertia::render('Tasks/Edit')->with('users', $users)->with('statuses', $statuses)->with('task', $task)->with('comments', $comments);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        // $request->validate([
        //     'title' => ['required', 'min:3'],
        //     'file' => 'nullable|image',
        // ]);

        $filePath = '';
        if ($request->hasFile('file')) {
            $fileName = time() . '_' . $request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('tasks', $fileName, 'public');
        }

        $comment = $request->comment;
        $file = $request->hasFile('file');

        if ($file == NULL) {
            $data = Task::where('id', $task->id)->first();
            $data->title = $request->title;
            $data->description = $request->description;
            $data->status_id = $request->status_id;
            $data->deadline = $request->deadline;
            $data->save();

            if (!$comment == NULL) {
                $userId = Auth::user()->id;
                $comment = new Comment();
                $comment->user_id = $userId;
                $comment->task_id = $task->id;
                $comment->comment = $request->comment;
                $comment->save();
            }

            return redirect()->back();
        } else {

            $data = Task::where('id', $task->id)->first();
            $data->title = $request->title;
            $data->description = $request->description;
            $data->status_id = $request->status_id;
            $data->assign_to = $request->assign_to;
            $data->file = $filePath;
            $data->deadline = $request->deadline;
            $data->save();

            if (!$comment == NULL) {
                $userId = Auth::user()->id;
                $comment = new Comment();
                $comment->user_id = $userId;
                $comment->task_id = $task->id;
                $comment->comment = $request->comment;
                $comment->save();
            }

            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }

    //    public function viewComment(){
    //         $comments = Comment::all();
    //         return Inertia::render('tasks.edit')->with('comments', $comments);
    //     } 
}
