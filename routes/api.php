<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;


//tenant
Route::group([
    'prefix' => '/{tenant}',
    'middleware' => [InitializeTenancyByPath::class, 'auth'],
], function () {
    Route::middleware('auth:api')->group(function () {
        /** Users Routes */
        Route::get('userlist', 'API\UserController@index');
        Route::get('usershow', 'API\UserController@show');
        Route::post('userupdate', 'API\UserController@update');
        Route::post('resetPassword', 'API\UserController@resetPassword');
        Route::get('userdelete/{id}', 'API\UserController@softDeletes');
        /** Clients Routes */
        Route::get('clientlist', 'API\ClientController@index');
        Route::post('clientstore', 'API\ClientController@store');
        Route::get('clientshow/{id}', 'API\ClientController@show');
        Route::get('userclientshow', 'API\ClientController@userclient');
        Route::post('clientupdate/{id}', 'API\ClientController@update');
        Route::get('clientdelete/{id}', 'API\ClientController@softDeletes');
        /** ContactClients Routes */
        Route::get('contactclientlist', 'API\ContactClientController@index');
        Route::get('usercontactclientlist', 'API\ContactClientController@usercontactclient');
        Route::post('contactclientstore', 'API\ContactClientController@store');
        Route::get('contactclientshow/{id}', 'API\ContactClientController@show');
        Route::get('contactclientupdate/{id}', 'API\ContactClientController@update');
        Route::get('contactclientdelete/{id}', 'API\ContactClientController@softDeletes');
        /** Jobs Routes */
        Route::get('joblist', 'API\JobController@index');
        Route::get('userclientjoblist', 'API\JobController@userclientjob');
        Route::post('jobstore', 'API\JobController@store');
        Route::get('jobshow/{id}', 'API\JobController@show');
        Route::get('jobupdate/{id}', 'API\JobController@update');
        Route::get('jobdelete/{id}', 'API\JobController@softDeletes');
        /** Candidates Routes */
        Route::get('candidatelist', 'API\candidateController@index');
        Route::get('usercandidate', 'API\candidateController@usercandidate');
        Route::post('candidatestore', 'API\candidateController@store');
        Route::get('candidateshow/{id}', 'API\candidateController@show');
        Route::post('candidateupdate/{id}', 'API\candidateController@update');
        Route::get('candidatedelete/{id}', 'API\candidateController@softDeletes');
        /** Activities Routes */
        Route::get('activitylist', 'API\ActivityController@index');
        Route::get('useractivitylist', 'API\ActivityController@useractivitylist');
        Route::post('activitystore', 'API\ActivityController@store');
        Route::get('activityshow/{id}', 'API\ActivityController@show');
        Route::get('activityupdate/{id}', 'API\ActivityController@update');
        Route::get('activitydelete/{id}', 'API\ActivityController@softDeletes');
        /** Positions Routes */
        Route::get('positionlist', 'API\PositionController@index');
        Route::post('positionstore', 'API\PositionController@store');
        Route::get('positionshow/{id}', 'API\PositionController@show');
        Route::get('positionupdate/{id}', 'API\PositionController@update');
        Route::get('positiondelete/{id}', 'API\PositionController@softDeletes');
        /** Files Routes */
        Route::get('filelist', 'API\FileController@index');
        Route::post('candidatefilestore', 'API\FileController@storeCandidate');
        Route::post('positionfilestore', 'API\FileController@storePosition');
        Route::get('fileshow/{id}', 'API\FileController@show');
        Route::get('filedelete/{id}', 'API\FileController@softDeletes');
        /** Educations Routes */
        Route::get('educationlist', 'API\EducationController@index');
        Route::post('educationstore', 'API\EducationController@store');
        Route::get('educationshow/{id}', 'API\EducationController@show');
        Route::get('educationupdate/{id}', 'API\EducationController@update');
        Route::get('educationdelete/{id}', 'API\EducationController@softDeletes');
        /** Skills Routes */
        Route::get('skilllist', 'API\SkillController@index');
        Route::post('skillstore', 'API\SkillController@store');
        Route::get('skillshow/{id}', 'API\SkillController@show');
        Route::get('skillupdate/{id}', 'API\SkillController@update');
        Route::get('skilldelete/{id}', 'API\SkillController@softDeletes');
        /** Levels Routes */
        Route::get('levellist', 'API\levelController@index');
        Route::post('levelstore', 'API\levelController@store');
        Route::get('levelshow/{id}', 'API\levelController@show');
        Route::get('levelupdate/{id}', 'API\levelController@update');
        Route::get('leveldelete/{id}', 'API\levelController@softDeletes');
        /** Notes Routes */
        Route::get('notelist', 'API\NoteController@index');
        Route::post('notestore', 'API\NoteController@store');
        Route::get('noteshow/{id}', 'API\NoteController@show');
        Route::get('noteupdate/{id}', 'API\NoteController@update');
        Route::get('notedelete/{id}', 'API\NoteController@softDeletes');
        /** Contract Routes */
        Route::get('contractlist', 'API\ContractController@index');
        Route::post('contractstore', 'API\ContractController@store');
        Route::get('contractshow/{id}', 'API\ContractController@show');
        Route::get('contractdelete/{id}', 'API\ContractController@softDeletes');

        //Countries
        Route::get('countries', 'API\CountryController@index');

        //import
        Route::post('importclient', 'API\clientController@importclient');
        Route::post('importcandidate', 'API\CandidateController@importcandidate');
        Route::post('importcontactclient', 'API\ContactClientController@importcontactclient');
        //Export
        Route::get('exportclient-excel', 'API\ClientController@exportExcel');
        Route::get('exportcandidate-excel', 'API\CandidateController@exportExcel');

    });

});

//tenant

//Register Route
Route::post('userregister', 'API\CentralUserController@register');
//Login Route
Route::post('userlogin', 'API\CentralUserController@login');

Route::get('userlist', 'API\UserController@index');


