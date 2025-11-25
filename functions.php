<?php
if (class_exists('VotingAppTest')) {
    define('USERS_FILE', __DIR__ . '/tests/users.txt');
    define('TOPICS_FILE', __DIR__ . '/tests/topics.txt');
    define('VOTES_FILE', __DIR__ . '/tests/votes.txt');
}
// Standard application mode: files remain in the same directory as functions.php
else {

    define('USERS_FILE', __DIR__ . '/users.txt');
    define('TOPICS_FILE', __DIR__ . '/topics.txt');
    define('VOTES_FILE', __DIR__ . '/votes.txt');
}

function registerUser($username, $password): bool
{
    $users = file(USERS_FILE, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
    foreach ($users as $user) {
        $userInfo = explode(":", $user);
        if($userInfo[0] == $username){
            return false;
        }
    }

    $file = fopen(USERS_FILE, "a");
    $userInfo = $username.":".$password."\n";
    fwrite($file, $userInfo);
    fclose($file);
    return true;
}
function authenticateUser($username, $password): bool
{
    $users = file(USERS_FILE, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
    foreach ($users as $user) {
        $userInfo = explode(":", $user);
        if ($username === $userInfo[0] && $password === $userInfo[1]) {
            return true;
        }
    }
    return false;
}
function createTopic($username, $title, $description): bool
{
    $file = fopen(TOPICS_FILE, "a");
    if (!fwrite($file, getID()."|".$username."|".$title."|".$description."\n")){
        fclose($file);
        return false;
    }
    fclose($file);
    return true;
}
function getTopics(): array
{

    $topics = file(TOPICS_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $collectionTopics = [];
    foreach($topics as $topic) {
        $topicInfo = explode("|", trim($topic));
        $collectionTopics[] = [
            'topicID' => $topicInfo[0],
            'creator' => $topicInfo[1],
            'title' => $topicInfo[2],
            'description' => $topicInfo[3]
        ];
    }

    return $collectionTopics;
}
function vote($username, $topicID, $voteType): bool{
    //Format: 3|maziar|up

    $votes = file(VOTES_FILE, FILE_SKIP_EMPTY_LINES |  FILE_IGNORE_NEW_LINES);
    foreach($votes as $vote) {
        $voteInfo = explode("|", $vote);
        if($username == $voteInfo[1] && $topicID == $voteInfo[0]){
            return false;
        }
    }
    $file = fopen(VOTES_FILE, "a");
    if (fwrite($file, $topicID . "|" . $username . "|" . $voteType . "\n") === false) {
        fclose($file);
        return false;
    }
    fclose($file);
    return true;
}
function hasVoted($username, $topicID): bool{
    $votes = file(VOTES_FILE, FILE_SKIP_EMPTY_LINES |  FILE_IGNORE_NEW_LINES);
    foreach($votes as $vote) {
        $voteInfo = explode("|", $vote);
        if($username == $voteInfo[1] && $topicID == $voteInfo[0]){
            return true;
        }
    }
    return false;
}
function getVoteResults($topicID): array
{
    //3|maziar|up
    $votes = file(VOTES_FILE, FILE_SKIP_EMPTY_LINES |  FILE_IGNORE_NEW_LINES);
    $upVotes = 0;
    $downVotes = 0;
    foreach($votes as $vote) {
        $voteInfo = explode("|", $vote);
        if ((int)$voteInfo[0] === (int)$topicID) {
            if ($voteInfo[2] === 'up') {
                $upVotes++;
            } elseif ($voteInfo[2] === 'down') {
                $downVotes++;
            }
        }
    }
    return ['up' => $upVotes, 'down' => $downVotes];
}
function setSession($key, $value): void
{
    $_SESSION[$key] = $value;
}
function getSession($key){
    if(isset($_SESSION[$key])){
        return $_SESSION[$key];
    }
    return null;
}
function set_cookie($key, $value): bool
{
// Check if running in CLI (command line) mode
    if (php_sapi_name() == 'cli') { // Directly set $_COOKIE for testing in CLI
        $_COOKIE[$key] = $value;
    } else {
// Use setcookie() for browser environment
    }
    return true;
}
function getCookie($key){
    if(isset($_COOKIE[$key])){
        return $_COOKIE[$key];
    }
    return null;
}

function getID()
{

    $file_name = 'ids';
    if (!file_exists($file_name)) {
        touch($file_name);
        $handle = fopen($file_name, 'r+');
        $id = 0;
    } else {
        $handle = fopen($file_name, 'r+');
        $id = fread($handle, filesize($file_name));
        settype($id, "integer");
    }
    rewind($handle);
    fwrite($handle, ++$id);

    fclose($handle);
    return $id;

}

function getUserVotingHistory($username): array {
    $votes = file(VOTES_FILE, FILE_SKIP_EMPTY_LINES |  FILE_IGNORE_NEW_LINES);
    $voteHistory = [];
    foreach($votes as $vote) {
        $voteInfo = explode("|", $vote);
        if ($voteInfo[1] === $username) {
            $voteHistory[] = $voteInfo;
        }
    }
    return $voteHistory;
}

function getTotalVotesCast($username): int {
    $votes = file(VOTES_FILE, FILE_SKIP_EMPTY_LINES |  FILE_IGNORE_NEW_LINES);
    $voteCount = 0;
    foreach($votes as $vote){
        $voteInfo = explode("|", $vote);
        if($voteInfo[1] === $username){
            $voteCount++;
        }
    }
    return $voteCount;
}
function getTotalTopicsCreated($username): int {
    $topics = file(TOPICS_FILE, FILE_SKIP_EMPTY_LINES |  FILE_IGNORE_NEW_LINES);
    $topicCount = 0;
    foreach($topics as $topic){
        $topicInfo = explode("|", $topic);
        if($topicInfo[1] === $username){
            $topicCount++;
        }
    }
    return $topicCount;
}
function logOut(): void
{
    session_start();
    session_unset();
    session_destroy();
    header("location: login.php");
}
function setTheme(): void
{
    if (isset($_POST['theme'])) {
        $theme = $_POST['theme'];
        setcookie('theme', $theme, time() + (86400 * 30), "/");
    }
}
