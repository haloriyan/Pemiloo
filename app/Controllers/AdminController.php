<?php

use DB as DB;
use Session as Session;
use Controller as App;
use VoterController as VoterCtrl;
use PollingController as PollCtrl;
use CandidateController as CandidateCtrl;

class AdminController {
    
    public function __construct() {
        App::middleware('Admin', ['login','test','loginAction']);
    }
    public function me() {
        return Session::get('admin');
    }
    public function login() {
        return view('admin.login');
    }
    public function dashboard() {
        $dateNow = date('Y-m-d');
        $activePolls = PollCtrl::get([
            ['end_date', '>=', $dateNow]
        ]);

        $candidates = [];
        foreach ($activePolls as $poll) {
            $candidates = CandidateCtrl::get([
                ['polling_id', '=', $poll->id]
            ]);

            $voters = VoterCtrl::get([
                ['polling_id', '=', $poll->id]
            ]);
            
            $votes = VoterCtrl::getVotes($poll->id);
        }

        return view('admin.dashboard', [
            'myData' => $this->me(),
            'activePolls' => $activePolls,
            'candidates' => $candidates,
            'voters' => $voters,
            'votes' => $votes,
        ]);
    }
    public function loginAction(Request $req) {
        $email = $req->email;
        $password = md5($req->password);
        
        $loggingIn = DB::table('admins')
                            ->select('id', 'name', 'email')
                            ->where([
                                ['email', '=', $email],
                                ['password', '=', $password],
                            ])
                            ->first();
        

        if ($loggingIn) {
            Session::set('admin', $loggingIn);
            redirect('admin/dashboard');
        }else {
            redirect('admin/login', [
                'message' => 'Email / Password salah'
            ]);
        }
    }
    public function logout() {
        Session::unset('admin');
        redirect('admin/login');
    }

    public function polling() {
        $pollings = PollCtrl::get();
        return view('admin.polling', [
            'myData' => $this->me(),
            'pollings' => $pollings
        ]);
    }
    public function candidate() {
        $poll_id = base64_decode(@$_GET['poll_id']);

        $pollings = PollCtrl::get();
        $candidates = CandidateCtrl::get([
            ['polling_id', '=', $poll_id]
        ]);
        return view('admin.candidate', [
            'myData' => $this->me(),
            'pollings' => $pollings,
            'candidates' => $candidates
        ]);
    }
    public function voter() {
        $pollings = PollCtrl::get();
        $voters = [];
        if (@$_GET['poll_id']) {
            $voters = VoterCtrl::get([
                ['polling_id', '=', base64_decode($_GET['poll_id'])]
            ]);
        }
        return view('admin.voter', [
            'myData' => $this->me(),
            'pollings' => $pollings,
            'voters' => $voters
        ]);
    }
    public function percentage($num, $total) {
        return $num / $total * 100;
    }
    public function result() {
        $pollings = PollCtrl::get();
        $candidates = CandidateCtrl::get([
            ['polling_id', '=', base64_decode(@$_GET['poll_id'])]
        ]);

        $votes = ['totalData' => 0];
        foreach ($candidates as $candidate) {
            $result = VoterCtrl::getResult($candidate->id);
            $votes[$candidate->id]['count'] = count($result);
            $votes[$candidate->id]['data'] = $result;
        }

        // get votes total data
        foreach ($votes as $vote) {
            $votes['totalData'] += $vote['count'];
        }

        $totalVoter = VoterCtrl::get([
            ['polling_id', '=', base64_decode(@$_GET['poll_id'])]
        ]);
        $notVotedYet = count($totalVoter) - $votes['totalData'];

        // get percentage for each candidate
        foreach ($votes as $vote) {
            if (is_array($vote)) {
                $votes[$vote['data'][0]->candidate_id]['percentage'] = $this->percentage($vote['count'], $votes['totalData']);
            }
        }
        
        return view('admin.result', [
            'myData' => $this->me(),
            'pollings' => $pollings,
            'candidates' => $candidates,
            'votes' => $votes,
            'notVotedYet' => $notVotedYet,
        ]);
    }
    public function resultByCandidate($candidateId) {
        $candidate = CandidateCtrl::get([
            ['id', '=', $candidateId]
        ])[0];

        $votes = DB::table('votes')->select()->where([
            ['candidate_id', '=', $candidateId]
        ])->get();

        $i = 0;
        foreach ($votes as $vote) {
            $voterData = VoterCtrl::get([
                ['id', '=', $vote->voter_id]
            ])[0];
            $votes[$i++]->voter = $voterData;
        }

        return view('admin.resultByCandidate', [
            'myData' => $this->me(),
            'candidate' => $candidate,
            'votes' => $votes
        ]);
    }
}
