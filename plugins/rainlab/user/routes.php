<?php

use RainLab\User\Models\User;

Route::get('/api/users', function () {
    $users = User::all();
    return $users;
});