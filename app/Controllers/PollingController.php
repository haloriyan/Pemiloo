<?php

use DB as DB;
use Controller as App;
use AdminController as AdminCtrl;
use Request as Request;

class PollingController {
    public function __construct() {
        App::middleware('Admin');
    }
    public static function get($filter = NULL) {
        if ($filter == NULL) {
            return DB::table('pollings')->select()->orderBy('created_at', 'DESC')->get();
        }
        return DB::table('pollings')->select()->where($filter)->orderBy('created_at', 'DESC')->get();
    }
    public function create() {
        return view('admin.polling.create', [
            'myData' => AdminCtrl::me()
        ]);
    }
    public function detail($id) {
        $poll = self::get([
            ['id', '=', $id]
        ])[0];
        return view('admin.polling.detail', [
            'poll' => $poll,
            'myData' => AdminCtrl::me()
        ]);
    }
    public function store() {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $end_date = $_POST['end_date'];
        $cover = $_FILES['cover'];

        $saveData = DB::table('pollings')
                        ->create([
                            'title' => $title,
                            'cover' => $cover['name'],
                            'description' => $description,
                            'end_date' => $end_date,
                        ])
                        ->execute();

        $uploading = Storage::disk('cover')->store('/', $cover);

        redirect('admin/polling', ['message' => "Success creating new poll"]);
    }
    public function edit($id) {
        $poll = self::get([
            ['id', '=', $id]
        ])[0];
        return view('admin.polling.edit', [
            'poll' => $poll,
            'myData' => AdminCtrl::me()
        ]);
    }
    public function update($id, Request $req) {
        $title = $req->title;
        $description = $req->description;
        $end_date = $req->end_date;
        $cover = $_FILES['cover'];

        $toUpdate = [
            'title' => $title,
            'description' => $description,
            'end_date' => $end_date,
        ];

        if ($cover['name'] != "") {
            $toUpdate['cover'] = $cover['name'];
            $uploading = Storage::disk('cover')->store('/', $cover);
        }

        $updateData = DB::table('pollings')
                            ->update($toUpdate)
                            ->where([
                                ['id', '=', $id]
                            ])
                            ->execute();

        redirect('admin/polling', ['message' => "Data successfully changed"]);
    }
    public function delete($id) {
        $deleteData = DB::table('pollings')
        ->delete()
        ->where([
            ['id', '=', $id]
        ])
        ->execute();
        redirect('admin/polling', ['message' => "Poll successfully deleted"]);
    }
}
