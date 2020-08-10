<?php

use Controller as App;
use Storage as Storage;
use AdminController as AdminCtrl;
use PollingController as PollingCtrl;

class CandidateController {
    public function get($filter = NULL) {
        if ($filter == NULL) {
            return DB::table('candidates')->select()->orderBy('created_at', 'DESC')->get();
        }
        return DB::table('candidates')->select()->where($filter)->orderBy('created_at', 'DESC')->get();
    }
    public function create($PollId) {
        $polling = PollingCtrl::get([
            ['id', '=', $PollId]
        ])[0];
        return view('admin.candidate.create', [
            'myData' => AdminCtrl::me(),
            'polling' => $polling
        ]);
    }
    public function store() {
        $polling_id = $_POST['polling_id'];
        $name = $_POST['name'];
        $bio = $_POST['bio'];
        $label_color = $_POST['label_color'];
        $photo = $_FILES['photo'];

        $saveData = DB::table('candidates')
                        ->create([
                            'polling_id' => $polling_id,
                            'name' => $name,
                            'bio' => $bio,
                            'label_color' => $label_color,
                            'photo' => $photo['name'],
                        ])
                        ->execute();

        $uploading = Storage::disk('photo')->store('/', $photo);

        return redirect('admin/candidate', [
            'message' => "Candidate successfully added",
            'poll_id' => $polling_id
        ]);
    }
    public function edit($id) {
        $candidate = $this->get([
            ['id', '=', $id]
        ])[0];

        return view('admin.candidate.edit', [
            'myData' => AdminCtrl::me(),
            'candidate' => $candidate
        ]);
    }
    public function update($id, Request $req) {
        $name = $req->name;
        $bio = $req->bio;
        $label_color = $req->label_color;
        $photo = $_FILES['photo'];

        $toUpdate = [
            'name' => $name,
            'bio' => $bio,
        ];

        if ($photo['name'] != "") {
            $toUpdate['photo'] = $photo['name'];
            $uploading = Storage::disk('photo')->store('/', $photo);
        }

        $updateData = DB::table('candidates')->update($toUpdate)->where([
            ['id', '=', $id]
        ])->execute();

        return redirect('admin/candidate', ['message' => "Data successfully changed", "poll_id" => $id]);
    }
    public function delete($id) {
        $polling_id = DB::table('candidates')->select('polling_id')->where([
            ['id', '=', $id]
        ])->get()[0];
        $deleteData = DB::table('candidates')
                            ->delete()
                            ->where([
                                ['id', '=', $id]
                            ])
                            ->execute();
                            
        return redirect('admin/candidate', [
            'message' => "Candidate successfully deleted",
            'poll_id' => $polling_id
        ]);
    }
}