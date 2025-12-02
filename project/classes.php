<?php

class User {
    public $username;
    public $password;
    public $email;
    public $pdo;
    public function __construct($pdo) { // Dependency Injection
        $this->pdo = $pdo;
    }
    public function registerUser($username, $email, $password): bool {
        // search first for existing
        if(strlen($password) < 9) { // cannot be less than 9
            return false;
        }
        if($username == "" || $email == "" || !preg_match("/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/", $email)) { // check if variables are invalid
            return false;
        }
        $stmt = $this->pdo->prepare("SELECT * FROM Users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        $result = $stmt->fetch();
        if($result){
            // user found
            return false;
        } else {
            $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare("INSERT INTO Users (username, email, password) VALUES (?, ?, ?)");
            return $stmt->execute([$username, $email, $hashed_pass]);
        }

    }
    public function authenticateUser($username, $password): bool {
        $this->password = $password;
        $this->username = $username;
        $stmt = $this->pdo->prepare("SELECT * FROM Users WHERE username = ? AND password = ?");
        return $stmt->execute([$username, $this->password]);
    }
    public function getUserId($username){
        $stmt = $this->pdo->prepare("SELECT id FROM Users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetchColumn();
    }
    public function getUsername($userId){
        $stmt = $this->pdo->prepare("SELECT username FROM Users WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn();
    }

}

class Topic {
    public $userId;
    public $title;
    public $description;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createTopic($userId, $title, $description) {
        $this->userId = $userId;
        $this->title = $title;
        $this->description = $description;
        $stmt = $this->pdo->prepare("INSERT INTO Topics (user_id, title, description) VALUES (?, ?, ?)");
        return $stmt->execute([$userId, $title, $this->description]);
    }

    public function getTopics(){
        $stmt = $this->pdo->prepare("SELECT * FROM Topics");
        $stmt->execute();
        $topicsArray = $stmt->fetchAll();

        $topics = [];
        foreach ($topicsArray as $topicData) {
            $topic = new Topic($this->pdo);
            $topic->userId = $topicData['user_id'];
            $topic->title = $topicData['title'];
            $topic->description = $topicData['description'];
            $topic->id = $topicData['id'];
            $topic->createdAt = $topicData['created_at'];
            $topics[] = $topic;
        }
        return $topics;
    }

    public function getCreatedTopics($userId){
        $stmt = $this->pdo->prepare("SELECT * FROM Topics WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    public function getTotalTopicsCreated($userId){
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Topics WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn();
    }
}

class Vote {
    public $userId;
    public $topicId;
    public $voteType;
    public $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function vote($userId, $topicId, $voteType) {
        $this->userId = $userId;
        $this->topicId = $topicId;
        $this->voteType = $voteType;
        $stmt = $this->pdo->prepare("INSERT INTO Votes (user_id, topic_id, vote_type) VALUES (?, ?, ?)");
        return $stmt->execute([$userId, $this->topicId, $this->voteType]);
    }

    public function hasVoted($topicId, $userId){
        $stmt = $this->pdo->prepare("SELECT * FROM Votes WHERE topic_id = ? and user_id = ?");
        $stmt->execute([$topicId, $userId]);
        $result = $stmt->fetch();
        if($result){
            return true;
        } else {
            return false;
        }
    }

    public function getUserVoteHistory($userId){ // TODO
        $stmt = $this->pdo->prepare("SELECT * FROM Votes WHERE user_id = ?");
        $stmt->execute([$userId]);
        $votesArray = $stmt->fetchAll();

        $votes = [];
        foreach ($votesArray as $voteData) {
            $vote = new Topic($this->pdo);
            $vote->userId = $voteData['user_id'];
            $vote->topicId = $voteData['topic_id'];
            $vote->voteType = $voteData['vote_type'];
            $vote->votedAt = $voteData['voted_at'];
            $vote->id = $voteData['id'];
            $votes[] = $vote;
        }
        return $votes;
    }
    public function getVotes(){
        $stmt = $this->pdo->prepare("SELECT * FROM Votes");
        $stmt->execute();
        $votesArray = $stmt->fetchAll();

        $votes = [];
        foreach ($votesArray as $voteData) {
            $vote = new Topic($this->pdo);
            $vote->userId = $voteData['user_id'];
            $vote->topicId = $voteData['topic_id'];
            $vote->voteType = $voteData['vote_type'];
            $vote->votedAt = $voteData['voted_at'];
            $vote->id = $voteData['id'];
            $votes[] = $vote;
        }
        return $votes;
    }
    public function getTotalVotesCast($userId){
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Votes WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn();
    }
    public function getTotalUpVotes($topicId){
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Votes WHERE topic_id = ? AND vote_type = 'up'");
        $stmt->execute([$topicId]);
        return $stmt->fetchColumn();
    }
    public function getTotalDownVotes($topicId){
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Votes WHERE topic_id = ? AND vote_type = 'down'");
        $stmt->execute([$topicId]);
        return $stmt->fetchColumn();
    }
}

class Comment
{
    public $userId;
    public $topicId;
    public $comment;
    public $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function addComment($userId, $topicId, $comment)
    {
        $this->userId = $userId;
        $this->topicId = $topicId;
        $this->comment = $comment;

        $stmt = $this->pdo->prepare("INSERT INTO Comments (user_id, topic_id, comment) VALUES (?, ?, ?)");
        return $stmt->execute([$userId, $this->topicId, $this->comment]);
    }

    public function getComments($topicId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Comments WHERE topic_id = ?");
        $stmt->execute([$topicId]);
        return $stmt->fetchAll();
    }
}

class TimeFormatter {
    public static function formatTimeStamp($timestamp) {
        $timeElapsed = time() - $timestamp;
        if ($timeElapsed > (60*60*24*365)) {
            return date("M d, Y", $timestamp);
        } else {
            $days = floor($timeElapsed / 86400);
            $hours = floor(($timeElapsed % 86400) / 3600);
            $minutes = floor(($timeElapsed % 3600) / 60);
            $secs = $timeElapsed % 60;

            if ($days > 0) {
                return "$days days ago";
            } else if ($hours > 0) {
                return "$hours hours ago";
            } else if ($minutes > 0) {
                return "$minutes minutes ago";
            } else if ($secs > 0) {
                return "$secs seconds ago";
            } else {
                return "just now";
            }
        }
    }
}