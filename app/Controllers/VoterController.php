<?php
include 'Controller.php';

use Controller as App;
use Session as Session;
use Mailer as Mailer;
use AdminController as AdminCtrl;
use VoterController as VoterCtrl;
use PollingController as PollingCtrl;
use CandidateController as CandidateCtrl;

class VoterController {
    public function me() {
        return Session::get('user');
    }
    public function get($filter) {
        $data = DB::table('voters')
                    ->select()
                    ->where($filter)
                    ->get();
        return $data;
    }
    public function generateToken($length) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	$charactersLength = strlen($characters);
    	$randomString = '';
    	for ($i = 0; $i < $length; $i++) {
        	$randomString .= $characters[rand(0, $charactersLength - 1)];
    	}
    	return $randomString;
	}
    public function create($PollId) {
        $polling = PollingCtrl::get([
            ['id', '=', $PollId]
        ])[0];
        return view('admin.voter.create', [
            'myData' => AdminCtrl::me(),
            'polling' => $polling
        ]);
    }
    public function store() {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $polling_id = $_POST['polling_id'];
        $token = $this->generateToken(8);

        $polling = PollingCtrl::get([
            ['id', '=', $polling_id]
        ])[0];

        $saveData = DB::table('voters')
                        ->create([
                            'name' => $name,
                            'email' => $email,
                            'polling_id' => $polling_id,
                            'token' => $token
                        ])
                        ->execute();

        Mailer::to($email, $name)
                ->subject("Your Token is HERE")
                ->from(env('MAIL_USERNAME'), env('APP_NAME'))
                ->send(
                    view('email.sendToken', [
                        'name' => $name,
                        'token' => $token,
                        'appName' => env('APP_NAME'),
                        'polling' => $polling
                    ])
                );

        redirect('admin/voter', ['message' => "Voter successfully added", "poll_id" => $id]);
    }
    public function edit($id) {
        $voter = $this->get([
            ['id', '=', $id]
        ])[0];
        return view('admin.voter.edit', [
            'voter' => $voter,
            'myData' => AdminCtrl::me(),
        ]);
    }
    public function update($id) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $token = $this->generateToken(8);

        $updateData = DB::table('voters')
                        ->update([
                            'name' => $name,
                            'email' => $email,
                            'token' => $token
                        ])
                        ->where([
                            ['id', '=', $id]
                        ])
                        ->execute();

        Mailer::to($email, $name)
                ->subject("Token Changed!")
                ->from(env('MAIL_USERNAME'), env('APP_NAME'))
                ->send(
                    view('email.tokenChange', [
                        'name' => $name,
                        'token' => $token,
                        'appName' => env('APP_NAME')
                    ])
                );

        redirect('admin/voter', ['message' => "Voter successfully changed", "poll_id" => $id]);
    }
    public function delete($id) {
        $voter = DB::table('voters')
                    ->delete()
                    ->where([
                        ['id', '=', $id]
                    ])
                    ->execute();

        redirect('admin/voter', ['message' => "Voter successfully deleted", "poll_id" => $id]);
    }
    public function index() {
        return view('index');
    }
    public function login() {
        $token = $_POST['token'];
        $loggingIn = $this->get([
            ['token', '=', $token]
        ])[0];

        if (count($loggingIn) > 0) {
            Session::set('user', $loggingIn);
            redirect('vote');
        }

        return redirect('/', ['message' => "Invalid token"]);
    }
    public function hasVote($voter_id, $polling_id) {
        $data = DB::table('votes')
                    ->select('voter_id', 'polling_id')
                    ->where([
                        ['voter_id', '=', $voter_id],
                        ['polling_id', '=', $polling_id]
                    ])
                    ->get();

        return count($data);
    }
    public function vote() {
        $myData = $this->me();
        $polling = PollingCtrl::get([
            ['id', '=', $myData['polling_id']]
        ])[0];

        $candidates = CandidateCtrl::get([
            ['polling_id', '=', $polling->id]
        ]);
        
        return view('vote', [
            'myData' => $myData,
            'polling' => $polling,
            'candidates' => $candidates,
            'hasVote' => $this->hasVote($myData['id'], $polling->id)
        ]);
    }
    public function doVote() {
        $candidate_id = $_POST['candidate_id'];
        $polling_id = $_POST['polling_id'];
        $voter_id = $_POST['voter_id'];

        $vote = DB::table('votes')
                    ->create([
                        'polling_id' => $polling_id,
                        'voter_id' => $voter_id,
                        'candidate_id' => $candidate_id,
                    ])
                    ->execute();
    }
    public function getResult($candidateId) {
        $data = DB::table('votes')->select()->where([
            ['candidate_id', '=', $candidateId]
        ])->get();
        return $data;
    }
    public function getVotes($PollID) {
        return DB::table('votes')->select()->where([
            ['polling_id', '=', $PollID]
        ])->get();
    }
    public function testMail() {
        Mailer::to('riyan.satria.619@gmail.com', 'Riyan Satria')
                ->subject("New Notification!")
                ->from('halobni@gmail.com', 'Belajar Ngeweb ID')
                ->send(
                    view('email.tokenChange', [
                        'name' => "riyan",
                        'token' => "qe23gw"
                    ])
                );
    }
    public function percentage($num, $total) {
        return $num / $total * 100;
    }
    public function result() {
        App::middleware('User');
        $myData = $this->me();
        $polling = PollingCtrl::get([
            ['id', '=', $myData['polling_id']]
        ])[0];

        $candidates = CandidateCtrl::get([
            ['polling_id', '=', $myData['polling_id']]
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
            ['polling_id', '=', $myData['polling_id']]
        ]);
        
        // get percentage for each candidate
        foreach ($votes as $vote) {
            if (is_array($vote)) {
                $votes[$vote['data'][0]->candidate_id]['percentage'] = $this->percentage($vote['count'], $votes['totalData']);
            }
        }

        return view('result', [
            'polling' => $polling,
            'candidates' => $candidates,
            'votes' => $votes,
        ]);
    }
}
