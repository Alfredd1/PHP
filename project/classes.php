<?php

class User {
    public $username;
    public $password;
    public $email;
    public $pdo;
    public function __construct($pdo) { // Dependency Injection
        $this->pdo = $pdo;
    }
    public function registerUser($username, $password, $email) {
        $stmt = $this->pdo->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        $stmt->execute([$username, $password, $email]);

    }
    public function authenticateUser($username, $password) {
        $this->password = $password;
        $this->username = $username;
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        return $stmt->execute([$username, $this->password]);
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
        $stmt = $this->pdo->prepare("INSERT INTO topics (userId, title, description) VALUES (?, ?, ?)");
        return $stmt->execute([$userId, $title, $this->description]);
    }

    public function getTopics(){
        $stmt = $this->pdo->prepare("SELECT * FROM topics");
        return $stmt->fetchAll();
    }

    public function getCreatedTopics($userId){
        $stmt = $this->pdo->prepare("SELECT * FROM topics WHERE userId = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
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
        $stmt = $this->pdo->prepare("INSERT INTO votes (userId, topicId, voteType) VALUES (?, ?, ?)");
        return $stmt->execute([$userId, $this->topicId, $this->voteType]);
    }

    public function hasVoted($topicId, $userId){
        $stmt = $this->pdo->prepare("SELECT * FROM votes WHERE topicId = ? and userId = ?");
        return $stmt->execute([$topicId, $userId]);
    }

    public function getUserVoteHistory($userId){
        $stmt = $this->pdo->prepare("SELECT * FROM votes WHERE userId = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
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

        $stmt = $this->pdo->prepare("INSERT INTO comments (userId, topicId, comment) VALUES (?, ?, ?)");
        return $stmt->execute([$userId, $this->topicId, $this->comment]);
    }

    public function getComments($topicId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM comments WHERE topicId = ?");
        $stmt->execute([$topicId]);
        return $stmt->fetchAll();
    }
}

class TimeFormatter {
    public static function formatTimeStamp($timestamp) {
        $timeElapsed = time() - $timestamp;
        if ($timeElapsed < (60*60*24*365)) {
            return date("M k, Y", $timestamp);
        } else {
            $days = floor($timestamp / 86400);
            $hours = floor(($timestamp % 86400) / 3600);
            $minutes = floor(($timestamp % 3600) / 60);
            $secs = $timestamp % 60;

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