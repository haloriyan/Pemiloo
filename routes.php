<?php

$routes = [
    '/' => 'GET:VoterController@index',
    'login' => 'POST:VoterController@login',
    'vote' => 'GET:VoterController@vote',
    'doVote' => 'POST:VoterController@doVote',
    'result' => 'GET:VoterController@result',

    'testmail' => 'GET:VoterController@testMail',
    'mailview' => 'GET:VoterController@mailView',

    'admin/{UserId}/get/{method}' => 'GET:AdminController@login',
    'admin/dashboard/' => 'GET:AdminController@dashboard',
    'admin/polling' => 'GET:AdminController@polling',
    'admin/candidate' => 'GET:AdminController@candidate',

    'admin/login' => 'GET:AdminController@login',
    'admin/loginAction' => 'POST:AdminController@loginAction',
    'admin/logout' => 'GET:AdminController@logout',
    'admin/coupon/{id}' => 'GET:AdminController@coupon',
    'upload' => 'GET:AdminController@formUpload',
    'doUpload' => 'POST:AdminController@doUpload',

    'admin/polling/create' => 'GET:PollingController@create',
    'admin/polling/store' => 'POST:PollingController@store',
    'admin/polling/{id}/edit' => 'GET:PollingController@edit',
    'admin/polling/{id}/update' => 'POST:PollingController@update',
    'admin/polling/{id}/detail' => 'GET:PollingController@detail',
    'admin/polling/{id}/delete' => 'GET:PollingController@delete',

    'admin/candidate/{PollId}/create' => 'GET:CandidateController@create',
    'admin/candidate/store' => 'POST:CandidateController@store',
    'admin/candidate/{id}/delete' => 'GET:CandidateController@delete',
    'admin/candidate/{id}/edit' => 'GET:CandidateController@edit',
    'admin/candidate/{id}/update' => 'POST:CandidateController@update',

    'admin/voter' => 'GET:AdminController@voter',
    'admin/voter/{PollId}/create' => 'GET:VoterController@create',
    'admin/voter/store' => 'POST:VoterController@store',
    'admin/voter/{id}/edit' => 'GET:VoterController@edit',
    'admin/voter/{id}/update' => 'POST:VoterController@update',

    'admin/result' => 'GET:AdminController@result',
    'admin/result/{candidateId}' => 'GET:AdminController@resultByCandidate',
];