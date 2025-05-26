<?php

use App\Models\Job;

it('it belongs to an employer', function () {

    //Arrange
    $employer = Employer::factory()->create();
    $job = Job::factory()->create([
        'employer_id' => $employer->id,

    ]);

    // Act and Assert

    expect($job->employer->is($employer))->toBeTrue();
    //Assert
});

it('can have tags', function(){
    //aaa
    $job = Job::factory()->create();
    
    $job-> tag('frontend');

    expect($job->tags)->toHaveCount(1);
});