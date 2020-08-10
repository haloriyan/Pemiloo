<?php

class User {
    public function handle() {
        $data = Session::get('user');
        if ($data == "" or count($data) == 0) {
            redirect("", [
                'message' => "You have to login first"
            ]);
        }
    }
}
