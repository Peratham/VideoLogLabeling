<?php
$users = require(__DIR__ . '/users.php');
$teams = require(__DIR__ . '/teams.php');

return [
    'log_dir' => 'log',
    'ownTeamName' => 'Berlin United',
    'logo' => 'img/naoth-logo.png',
    'users' => $users,
    'teams' => $teams,
];